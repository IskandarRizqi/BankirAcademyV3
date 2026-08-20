<?php

namespace App\Http\Controllers;

use App\Models\BiayaSertifikatModel;
use App\Models\ClassesModel;
use App\Models\ClassParticipantModel;
use App\Models\ClassPaymentModel;
use App\Models\DataPayment;
use App\Models\RiwayatTransaksi;
use App\Models\SertifikatPesertaModel;
use App\Models\UserProfileModel;
use App\Services\ClassPricingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class PaymentController extends Controller
{
    private const MEMBERSHIP_PAYMENT_DUE_MINUTES = 60;

    private const IHT_PAYMENT_DUE_MINUTES = 60;

    public function paymentmembership(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            abort(401);
        }

        $validated = $request->validate([
            'membership_tipe' => ['required', 'integer', Rule::in(DataPayment::MEMBERSHIP_TYPES)],
        ]);
        $membershipType = (int) $validated['membership_tipe'];
        $membership = $this->membershipConfiguration($membershipType);

        $profile = UserProfileModel::where('user_id', $user->id)->first();

        if (! $profile) {
            return back()->with('error', 'Profil pengguna tidak ditemukan.');
        }

        $clientId = env('DOKU_CLIENT_ID');
        $secretKey = env('DOKU_SECRET_KEY');
        $dokuUrl = rtrim((string) env('DOKU_URL'), '/');

        if (! $clientId || ! $secretKey || ! $dokuUrl) {
            return back()->with('error', 'Konfigurasi pembayaran belum lengkap.');
        }

        $qty = 1;
        $totalbayar = $membership['price'] * $qty;
        $temporaryInvoice = 'BANKIR-PENDING-' . now()->format('YmdHisv') . '-' . random_int(1000, 9999);

        $datapayment = DataPayment::create([
            'no_invoice' => $temporaryInvoice,
            'user_id' => $user->id,
            'pembelian' => DataPayment::PURCHASE_MEMBERSHIP,
            'nominal' => $totalbayar,
            'expired' => self::MEMBERSHIP_PAYMENT_DUE_MINUTES,
            'qty' => $qty,
            'status' => DataPayment::STATUS_PENDING,
            'keterangan' => $membership['description'],
            'tipe_pembelian' => DataPayment::PURCHASE_TYPE_MEMBERSHIP,
            'tipe_membership' => $membershipType,
        ]);

        $nomorinvoice = 'BANKIR-' . $datapayment->created_at->format('YmdHis') . '-' . $datapayment->id;
        $datapayment->update(['no_invoice' => $nomorinvoice]);

        $timestamp = now()->toIso8601ZuluString();
        $requestId = Str::uuid()->toString();

        $body = [
            'order' => [
                'amount' => $totalbayar,
                'invoice_number' => $nomorinvoice,
                'callback_url' => url('/pembayaran?invoice_number=' . urlencode($nomorinvoice)),
                'line_items' => [
                    [
                        'name' => $membership['label'],
                        'price' => $membership['price'],
                        'quantity' => $qty,
                    ],
                ],
            ],
            'customer' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'payment' => [
                'payment_due_date' => self::MEMBERSHIP_PAYMENT_DUE_MINUTES,
            ],
            'additional_info' => [
                'user_id' => $user->id,
                'pembelian_tipe' => DataPayment::PURCHASE_TYPE_MEMBERSHIP,
                'membership_tipe' => $membershipType,
                'override_notification_url' => env('DOKU_NOTIFICATION_URL', url('/api/c4/notifikasi')),
            ],
        ];

        $jsonBody = json_encode($body);
        $digest = base64_encode(hash('sha256', $jsonBody, true));

        $rawSignature = 'Client-Id:' . $clientId . "\n" .
            'Request-Id:' . $requestId . "\n" .
            'Request-Timestamp:' . $timestamp . "\n" .
            "Request-Target:/checkout/v1/payment\n" .
            'Digest:' . $digest;

        $signature = base64_encode(hash_hmac('sha256', $rawSignature, $secretKey, true));

        try {
            $response = Http::timeout(15)->withHeaders([
                'Client-Id' => $clientId,
                'Request-Id' => $requestId,
                'Request-Timestamp' => $timestamp,
                'Signature' => 'HMACSHA256=' . $signature,
                'Digest' => $digest,
                'Content-Type' => 'application/json',
            ])->post($dokuUrl . '/checkout/v1/payment', $body);
        } catch (Throwable $exception) {
            Log::error('Gagal membuat pembayaran membership DOKU', [
                'invoice' => $nomorinvoice,
                'error' => $exception->getMessage(),
            ]);

            $datapayment->update([
                'status' => DataPayment::STATUS_CANCELED,
                'keterangan' => 'Gagal menghubungi server pembayaran.',
            ]);

            return back()->with('error', 'Gagal menghubungi server pembayaran. Silakan coba lagi.');
        }

        $resData = $response->json();
        $paymentUrl = $resData['response']['payment']['url'] ?? null;

        if ($response->successful() && $paymentUrl) {
            $datapayment->update(['link_payment' => $paymentUrl]);
            $profile->update(['status_membership' => DataPayment::STATUS_PENDING]);

            return redirect()->away($paymentUrl);
        }

        Log::warning('DOKU tidak mengembalikan URL pembayaran membership', [
            'invoice' => $nomorinvoice,
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        $datapayment->update([
            'status' => DataPayment::STATUS_CANCELED,
            'keterangan' => Str::limit('Gagal membuat link pembayaran: ' . $response->body(), 500),
        ]);

        return back()->with('error', 'Gagal membuat link pembayaran. Silakan coba lagi.');
    }

    private function membershipConfiguration(int $membershipType): array
    {
        return match ($membershipType) {
            DataPayment::MEMBERSHIP_TYPE_COMPANY => [
                'label' => 'Membership Perusahaan',
                'description' => 'Membership perusahaan',
                'price' => 3000000,
            ],
            DataPayment::MEMBERSHIP_TYPE_INDIVIDUAL => [
                'label' => 'Membership Perorangan',
                'description' => 'Membership perorangan',
                'price' => 99000,
            ],
            default => throw new \InvalidArgumentException('Tipe membership tidak valid.'),
        };
    }

    public function paymentorderclass(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            abort(401);
        }

        $validated = $request->validate([
            'class_id' => ['required', 'integer', 'exists:classes,id'],
            'jml_peserta' => ['required', 'integer', 'min:1'],
            'sertifikat_invoice' => ['required', 'in:0,1'],
            'payment_method' => ['nullable', 'in:gateway,manual'], // Tambahan parameter skema pembayaran
            'nama' => ['required', 'array'],
            'nama.*' => ['required', 'string', 'max:255'],
            'email' => ['required', 'array'],
            'email.*' => ['required', 'email', 'max:255'],
            'nomor_handphone' => ['required', 'array'],
            'nomor_handphone.*' => ['required', 'string', 'max:30'],
        ]);

        $jumlahPeserta = (int) $validated['jml_peserta'];

        if (
            count($validated['nama']) !== $jumlahPeserta ||
            count($validated['email']) !== $jumlahPeserta ||
            count($validated['nomor_handphone']) !== $jumlahPeserta
        ) {
            return back()->withInput()->with('error', 'Jumlah data peserta tidak sesuai dengan jumlah peserta.');
        }

        $classId = (int) $validated['class_id'];
        $class = ClassesModel::select('id', 'participant_limit', 'kategori', 'iht')->whereKey($classId)->first();

        if (! $class) {
            return back()->withInput()->with('error', 'Kelas tidak ditemukan.');
        }

        $remainingQuota = ClassParticipantModel::remainingQuotaForClass($classId, (int) $class->participant_limit);

        if ($remainingQuota !== null && $jumlahPeserta > $remainingQuota) {
            return back()->withInput()->with('error', 'Kuota kelas tidak mencukupi. Sisa kuota: ' . $remainingQuota . ' peserta.');
        }

        $pricing = app(ClassPricingService::class)->resolve($class, $user);

        if (! $pricing['regular_purchase_allowed']) {
            return back()->withInput()->with('error', 'Kelas IHT hanya dapat diproses melalui order manual admin.');
        }

        if (! $pricing['base_price'] && ! $pricing['is_iht']) {
            return back()->withInput()->with('error', 'Harga kelas belum tersedia.');
        }

        $isFreeClass = $pricing['final_price'] <= 0;
        $pricePerParticipant = $pricing['final_price'];

        $classTotal = $pricePerParticipant * $jumlahPeserta;
        $certificateTotal = 0;

        if ((int) $validated['sertifikat_invoice'] === 1) {
            $certificateFee = BiayaSertifikatModel::where('class_id', $classId)->first();

            if ($certificateFee) {
                $certificatePerParticipant = $isFreeClass
                    ? (float) $certificateFee->nominal
                    : ((int) $certificateFee->type > 0
                        ? ($pricePerParticipant * ((float) $certificateFee->nominal / 100))
                        : (float) $certificateFee->nominal);
            } else {
                $certificatePerParticipant = 100000;
            }

            $certificateTotal = max(0, $certificatePerParticipant * $jumlahPeserta);
        }

        $grandTotal = $classTotal + $certificateTotal;

        // Tentukan opsi skema pembayaran
        $selectedPaymentMethod = $validated['payment_method'] ?? 'gateway';

        // Payment gateway hanya jika total > 0 DAN user memilih metode 'gateway'
        $needsPaymentGateway = $grandTotal > 0 && $selectedPaymentMethod === 'gateway';
        $paymentStatus = DataPayment::STATUS_PENDING; // Status default untuk manual/gateway yang belum lunas

        if ($grandTotal <= 0) {
            $paymentStatus = DataPayment::STATUS_PAID;
        }

        $result = DB::transaction(function () use (
            $user,
            $classId,
            $jumlahPeserta,
            $pricePerParticipant,
            $pricing,
            $certificateTotal,
            $grandTotal,
            $paymentStatus,
            $needsPaymentGateway,
            $validated,
            $selectedPaymentMethod
        ) {
            $class = ClassesModel::select('id', 'participant_limit')->whereKey($classId)->lockForUpdate()->first();

            if (! $class) {
                return [
                    'success' => false,
                    'message' => 'Kelas tidak ditemukan.',
                ];
            }

            $remainingQuota = ClassParticipantModel::remainingQuotaForClass($classId, (int) $class->participant_limit);

            if ($remainingQuota !== null && $jumlahPeserta > $remainingQuota) {
                return [
                    'success' => false,
                    'message' => 'Kuota kelas tidak mencukupi. Sisa kuota: ' . $remainingQuota . ' peserta.',
                ];
            }

            $temporaryInvoice = 'BANKIR-' . now()->format('YmdHisv') . '-' . random_int(1000, 9999);

            $classPayment = ClassPaymentModel::create([
                'status' => $paymentStatus === DataPayment::STATUS_PAID ? 1 : 0,
                'user_id' => $user->id,
                'class_id' => $classId,
                'unique_code' => random_int(0, 999),
                'price' => $pricePerParticipant,
                'additional_discount' => json_encode([
                    'base_price' => $pricing['base_price'],
                    'general_discount' => $pricing['general_discount'],
                    'membership_discount' => $pricing['membership_discount'],
                    'total_discount' => $pricing['total_discount'],
                    'discount_percent' => $pricing['discount_percent'],
                    'membership_type' => $pricing['membership_type'],
                    'discount_source' => $pricing['discount_source'],
                ]),
                'biaya_sertifikat' => $certificateTotal,
                'price_final' => $grandTotal,
                'expired' => now()->addDay(),
                'no_invoice' => $temporaryInvoice,
                'jumlah' => $jumlahPeserta,
            ]);

            $keterangan = $selectedPaymentMethod === 'manual'
                ? 'Pembelian kelas (Transfer Manual)'
                : 'Pembelian kelas';

            $dataPayment = DataPayment::create([
                'no_invoice' => 'BANKIR-' . now()->format('YmdHisv') . '-' . random_int(1000, 9999),
                'user_id' => $user->id,
                'class_id' => $classId,
                'pembelian' => DataPayment::PURCHASE_CLASS,
                'expired' => 1440,
                'nominal' => $grandTotal,
                'qty' => $jumlahPeserta,
                'status' => $paymentStatus,
                'keterangan' => $keterangan,
                'tipe_pembelian' => DataPayment::PURCHASE_TYPE_CLASS,
            ]);

            $invoiceNumber = 'BANKIR-' . $dataPayment->created_at->format('YmdHis') . '-' . $dataPayment->id;
            $dataPayment->update(['no_invoice' => $invoiceNumber]);
            $classPayment->update(['no_invoice' => $invoiceNumber]);

            ClassParticipantModel::updateOrCreate(
                [
                    'payment_id' => $classPayment->id,
                    'user_id' => $user->id,
                ],
                [
                    'class_id' => $classId,
                    'certificate' => (int) $validated['sertifikat_invoice'],
                    'jumlah' => $jumlahPeserta,
                ]
            );

            SertifikatPesertaModel::create([
                'user_id' => $user->id,
                'class_id' => $classId,
                'payment_class_id' => $classPayment->id,
                'nama' => json_encode($validated['nama']),
                'email' => json_encode($validated['email']),
                'nohp' => json_encode($validated['nomor_handphone']),
            ]);

            return [
                'success' => true,
                'classPayment' => $classPayment,
                'dataPayment' => $dataPayment,
                'needsPaymentGateway' => $needsPaymentGateway,
            ];
        });

        if (! $result['success']) {
            return back()->withInput()->with('error', $result['message']);
        }

        // Opsi A: Jika bayar via Virtual Account / Payment Gateway
        if ($result['needsPaymentGateway']) {
            $paymentUrl = $this->createClassDokuPaymentUrl(
                $result['dataPayment']->no_invoice,
                $grandTotal,
                $user,
                $classId,
                $jumlahPeserta
            );

            if (! $paymentUrl) {
                $result['dataPayment']->update([
                    'status' => DataPayment::STATUS_CANCELED,
                    'keterangan' => 'Gagal membuat link pembayaran kelas.',
                ]);

                return back()->withInput()->with('error', 'Gagal membuat link pembayaran kelas. Silakan coba lagi.');
            }

            $result['dataPayment']->update(['link_payment' => $paymentUrl]);
            $result['classPayment']->update(['file' => $paymentUrl]);

            return redirect()->away($paymentUrl);
        }

        // Opsi B: Jika bayar Manual atau Kelas Gratis (Langsung ke halaman konfirmasi/invoice)
        return redirect('/pembayaran?invoice_number=' . urlencode($result['dataPayment']->no_invoice));
    }

    public function paymentordermaterial(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            abort(401);
        }

        $validated = $request->validate([
            'class_id' => ['required', 'integer'],
            'price' => ['required', 'string'],
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'nomor_handphone' => ['required', 'string', 'max:30'],
        ]);
        $result = DB::transaction(function () use (
            $user,
            $validated
        ) {
            $dataPayment = DataPayment::create([
                'no_invoice' => 'BANKIR-' . now()->format('YmdHisv') . '-' . random_int(1000, 9999),
                'user_id' => $user->id,
                'materi_id' => $validated['class_id'],
                'pembelian' => DataPayment::PURCHASE_CLASS,
                'nominal' => $validated['price'],
                'qty' => 1,
                'status' => DataPayment::STATUS_PENDING,
                'keterangan' => 'Pembelian kelas',
                'tipe_pembelian' => DataPayment::PURCHASE_TYPE_CLASS,
            ]);

            $invoiceNumber = 'BANKIR-' . $dataPayment->created_at->format('YmdHis') . '-' . $dataPayment->id;
            $dataPayment->update(['no_invoice' => $invoiceNumber]);

            return [
                'success' => true,
                'dataPayment' => $dataPayment,
            ];
        });
        if (! $result['success']) {
            return back()->withInput()->with('error', $result['message']);
        }
        $paymentUrl = $this->createClassDokuPaymentUrl(
            $result['dataPayment']->no_invoice,
            $validated['price'],
            $user,
            $validated['class_id'],
            1
        );

        if (! $paymentUrl) {
            $result['dataPayment']->update([
                'status' => DataPayment::STATUS_CANCELED,
                'keterangan' => 'Gagal membuat link pembayaran kelas.',
            ]);

            return back()->withInput()->with('error', 'Gagal membuat link pembayaran materi. Silakan coba lagi.');
        }

        $result['dataPayment']->update(['link_payment' => $paymentUrl]);

        return redirect()->away($paymentUrl);
    }

    public function paymentorderebook(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            abort(401);
        }

        $validated = $request->validate([
            'class_id' => ['required', 'integer'],
            'price' => ['required', 'string'],
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'nomor_handphone' => ['required', 'string', 'max:30'],
        ]);
        $currentPayment = DataPayment::where('user_id', $user->id)->where('submateri_id', $validated['class_id'])->where('status', 2)->first();
        if ($currentPayment) {
            return redirect()->away($currentPayment->link_payment);
        }
        $needsPaymentGateway = $validated['price'] > 0;
        $paymentStatus = $needsPaymentGateway ? DataPayment::STATUS_PENDING : DataPayment::STATUS_PAID;
        // $currentPayment = DataPayment::where('')
        $result = DB::transaction(function () use (
            $user,
            $needsPaymentGateway,
            $paymentStatus,
            $validated
        ) {
            $dataPayment = DataPayment::create([
                'no_invoice' => 'BANKIR-' . now()->format('YmdHisv') . '-' . random_int(1000, 9999),
                'user_id' => $user->id,
                'submateri_id' => $validated['class_id'],
                'expired' => self::MEMBERSHIP_PAYMENT_DUE_MINUTES,
                'pembelian' => DataPayment::PURCHASE_EBOOK,
                'nominal' => $validated['price'],
                'qty' => 1,
                'status' => $paymentStatus,
                'keterangan' => 'Pembelian Ebook',
                'tipe_pembelian' => DataPayment::PURCHASE_TYPE_EBOOK,
            ]);

            $invoiceNumber = 'BANKIR-' . $dataPayment->created_at->format('YmdHis') . '-' . $dataPayment->id;
            $dataPayment->update(['no_invoice' => $invoiceNumber]);

            return [
                'success' => true,
                'needsPaymentGateway' => $needsPaymentGateway,
                'dataPayment' => $dataPayment,
            ];
        });
        if (! $result['success']) {
            return back()->withInput()->with('error', $result['message']);
        }
        if ($result['needsPaymentGateway']) {
            $paymentUrl = $this->createClassDokuPaymentUrl(
                $result['dataPayment']->no_invoice,
                $validated['price'],
                $user,
                $validated['class_id'],
                1
            );

            if (! $paymentUrl) {
                $result['dataPayment']->update([
                    'status' => DataPayment::STATUS_CANCELED,
                    'keterangan' => 'Gagal membuat link pembayaran kelas.',
                ]);

                return back()->withInput()->with('error', 'Gagal membuat link pembayaran ebook. Silakan coba lagi.');
            }

            $result['dataPayment']->update(['link_payment' => $paymentUrl]);

            return redirect()->away($paymentUrl);
        }
        DB::table('history_pelatihan')->updateOrInsert(
            [
                'user_id' => $user->id,
                'sub_materi_id' => $validated['class_id'],
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return redirect('/pembayaran?invoice_number=' . urlencode($result['dataPayment']->no_invoice));
    }

    public function paymentordervideo(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            abort(401);
        }

        $validated = $request->validate([
            'class_id'        => ['required', 'integer'],
            'price'           => ['required', 'numeric'],
            'nama'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'max:255'],
            'nomor_handphone' => ['required', 'string', 'max:30'],
        ]);

        // Cek jika transaksi pending sudah ada
        $currentPayment = DataPayment::where('user_id', $user->id)
            ->where('submateri_id', $validated['class_id'])
            ->where('status', DataPayment::STATUS_PENDING)
            ->first();

        if ($currentPayment && $currentPayment->link_payment) {
            return redirect()->away($currentPayment->link_payment);
        }

        $needsPaymentGateway = $validated['price'] > 0;
        $paymentStatus = $needsPaymentGateway ? DataPayment::STATUS_PENDING : DataPayment::STATUS_PAID;

        $result = DB::transaction(function () use ($user, $needsPaymentGateway, $paymentStatus, $validated) {
            $dataPayment = DataPayment::create([
                'no_invoice'     => 'BANKIR-' . now()->format('YmdHisv') . '-' . random_int(1000, 9999),
                'user_id'        => $user->id,
                'submateri_id'   => $validated['class_id'],
                'pembelian'      => DataPayment::PURCHASE_VIDEO,
                'expired'        => self::MEMBERSHIP_PAYMENT_DUE_MINUTES,
                'nominal'        => $validated['price'],
                'qty'            => 1,
                'status'         => $paymentStatus,
                'keterangan'     => 'Pembelian Video Interaktif',
                'tipe_pembelian' => DataPayment::PURCHASE_TYPE_VIDEO,
            ]);

            $invoiceNumber = 'BANKIR-' . $dataPayment->created_at->format('YmdHis') . '-' . $dataPayment->id;
            $dataPayment->update(['no_invoice' => $invoiceNumber]);

            // Riwayat Transaksi VA Gateway (manual = 0)
            RiwayatTransaksi::create([
                'user_id'           => $dataPayment->user_id,
                'class_id'          => $dataPayment->submateri_id,
                'nominal_transaksi' => $dataPayment->nominal,
                'metode_pembayaran' => 'Virtual Akun',
                'no_invoice'        => $invoiceNumber,
                'status'            => 'PENDING',
                'manual'            => 0, // 0 = Virtual Account
                'expired'           => now()->addMinutes(self::MEMBERSHIP_PAYMENT_DUE_MINUTES),
                'keterangan'        => 'Pembelian video pelatihan melalui virtual akun.'
            ]);

            return [
                'success'             => true,
                'needsPaymentGateway' => $needsPaymentGateway,
                'dataPayment'         => $dataPayment,
            ];
        });

        if (!$result['success']) {
            return back()->withInput()->with('error', 'Gagal memproses transaksi.');
        }

        if ($result['needsPaymentGateway']) {
            $paymentUrl = $this->createClassDokuPaymentUrl(
                $result['dataPayment']->no_invoice,
                $validated['price'],
                $user,
                $validated['class_id'],
                1
            );

            if (!$paymentUrl) {
                $result['dataPayment']->update([
                    'status'     => DataPayment::STATUS_CANCELED,
                    'keterangan' => 'Gagal membuat link pembayaran kelas.',
                ]);

                return back()->withInput()->with('error', 'Gagal membuat link pembayaran video. Silakan coba lagi.');
            }

            $result['dataPayment']->update(['link_payment' => $paymentUrl]);

            return redirect()->away($paymentUrl);
        }

        DB::table('history_pelatihan')->updateOrInsert(
            [
                'user_id'       => $user->id,
                'sub_materi_id' => $validated['class_id'],
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return redirect('/pembayaran?invoice_number=' . urlencode($result['dataPayment']->no_invoice));
    }

    /**
     * Pembayaran Transfer Manual (manual = 1, expired = 1 jam)
     */
    public function paymentOrderVideoManual(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            abort(401);
        }

        $validated = $request->validate([
            'class_id' => ['required', 'integer'],
            'price'    => ['required', 'numeric'],
        ]);

        $expiredTime = now()->addDay(); // Expired 1 Jam

        $dataPayment = DB::transaction(function () use ($user, $validated, $expiredTime) {
            $payment = DataPayment::create([
                'no_invoice'     => 'BANKIR-MNL-' . now()->format('YmdHisv') . '-' . random_int(1000, 9999),
                'user_id'        => $user->id,
                'submateri_id'   => $validated['class_id'],
                'pembelian'      => DataPayment::PURCHASE_VIDEO,
                'expired'        => 1440,
                'nominal'        => $validated['price'],
                'qty'            => 1,
                'status'         => DataPayment::STATUS_PENDING,
                'keterangan'     => 'Pembelian Video (Transfer Manual BCA)',
                'tipe_pembelian' => DataPayment::PURCHASE_TYPE_VIDEO,
            ]);

            $invoiceNumber = 'BANKIR-MNL-' . $payment->created_at->format('YmdHis') . '-' . $payment->id;
            $payment->update(['no_invoice' => $invoiceNumber]);

            // Riwayat Transaksi Transfer Manual (manual = 1)
            RiwayatTransaksi::create([
                'user_id'           => $user->id,
                'class_id'          => $validated['class_id'],
                'nominal_transaksi' => $validated['price'],
                'metode_pembayaran' => 'Transfer Manual BCA',
                'no_invoice'        => $invoiceNumber,
                'status'            => 'PENDING',
                'manual'            => 1,            // 1 = Transfer Manual
                'expired'           => $expiredTime, // Expired 1 Jam
                'keterangan'        => 'Pembelian video pelatihan via Transfer Manual BCA.'
            ]);

            return $payment;
        });

        // Redirect menggunakan ID dari DataPayment ($dataPayment->id)
        return redirect()->to('/materi/cetakinvoicepending/' . $dataPayment->id);
    }
    public function paymentOrderEbookManual(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            abort(401);
        }

        $validated = $request->validate([
            'class_id' => ['required', 'integer'],
            'price'    => ['required', 'numeric'],
        ]);

        $expiredTime = now()->addDay(); // Expired 1 Jam

        $dataPayment = DB::transaction(function () use ($user, $validated, $expiredTime) {
            $payment = DataPayment::create([
                'no_invoice'     => 'BANKIR-MNL-' . now()->format('YmdHisv') . '-' . random_int(1000, 9999),
                'user_id'        => $user->id,
                'submateri_id'   => $validated['class_id'],
                'pembelian'      => DataPayment::PURCHASE_EBOOK,
                'expired'        => 1440,
                'nominal'        => $validated['price'],
                'qty'            => 1,
                'status'         => DataPayment::STATUS_PENDING,
                'keterangan'     => 'Pembelian Video (Transfer Manual BCA)',
                'tipe_pembelian' => DataPayment::PURCHASE_TYPE_EBOOK,
            ]);

            $invoiceNumber = 'BANKIR-MNL-' . $payment->created_at->format('YmdHis') . '-' . $payment->id;
            $payment->update(['no_invoice' => $invoiceNumber]);

            // Riwayat Transaksi Transfer Manual (manual = 1)
            RiwayatTransaksi::create([
                'user_id'           => $user->id,
                'class_id'          => $validated['class_id'],
                'nominal_transaksi' => $validated['price'],
                'metode_pembayaran' => 'Transfer Manual BCA',
                'no_invoice'        => $invoiceNumber,
                'status'            => 'PENDING',
                'manual'            => 1,            // 1 = Transfer Manual
                'expired'           => $expiredTime, // Expired 1 Jam
                'keterangan'        => 'Pembelian video pelatihan via Transfer Manual BCA.'
            ]);

            return $payment;
        });

        // Redirect menggunakan ID dari DataPayment ($dataPayment->id)
        return redirect()->to('/materi/cetakinvoicepending/' . $dataPayment->id);
    }
    public function paymentIht(Request $request, DataPayment $payment)
    {
        $user = $request->user();

        if (! $user) {
            abort(401);
        }

        if ((int) $payment->user_id !== (int) $user->id) {
            abort(403);
        }

        Log::info('Permintaan pembayaran IHT diterima', [
            'payment_id' => $payment->id,
            'invoice' => $payment->no_invoice,
            'user_id' => $user->id,
        ]);

        $preparedPayment = DB::transaction(function () use ($payment) {
            $lockedPayment = DataPayment::whereKey($payment->id)->lockForUpdate()->first();

            if (! $lockedPayment) {
                return [
                    'success' => false,
                    'message' => 'Data pembayaran tidak ditemukan.',
                ];
            }

            if (! $lockedPayment->canPayConfirmedIht()) {
                Log::warning('Pembayaran IHT ditolak karena status order tidak valid', [
                    'payment_id' => $lockedPayment->id,
                    'invoice' => $lockedPayment->no_invoice,
                    'status' => $lockedPayment->status,
                    'is_iht' => $lockedPayment->is_iht,
                    'is_konfirmasi' => $lockedPayment->is_konfirmasi,
                    'expired' => $lockedPayment->expired,
                    'link_payment_exists' => (bool) $lockedPayment->link_payment,
                ]);

                return [
                    'success' => false,
                    'message' => 'Order IHT belum dapat dibayar atau sudah selesai diproses.',
                ];
            }

            if ($lockedPayment->link_payment) {
                if ((int) $lockedPayment->expired < 1) {
                    $lockedPayment->update(['expired' => self::IHT_PAYMENT_DUE_MINUTES]);
                }

                return [
                    'success' => true,
                    'payment' => $lockedPayment->fresh(),
                    'payment_url' => $lockedPayment->link_payment,
                    'class_payment_id' => optional($lockedPayment->classPayment)->id,
                ];
            }

            $paymentAmount = (int) round((float) $lockedPayment->nominal);

            if ($paymentAmount < 1) {
                Log::warning('Pembayaran IHT ditolak karena nominal tidak valid', [
                    'payment_id' => $lockedPayment->id,
                    'invoice' => $lockedPayment->no_invoice,
                    'nominal' => $lockedPayment->nominal,
                ]);

                return [
                    'success' => false,
                    'message' => 'Nominal pembayaran IHT belum valid.',
                ];
            }

            $classPayment = ClassPaymentModel::where('no_invoice', $lockedPayment->no_invoice)
                ->lockForUpdate()
                ->first();

            if (! $classPayment) {
                Log::warning('Pembayaran IHT ditolak karena class payment tidak ditemukan', [
                    'payment_id' => $lockedPayment->id,
                    'invoice' => $lockedPayment->no_invoice,
                ]);

                return [
                    'success' => false,
                    'message' => 'Data invoice kelas IHT tidak ditemukan.',
                ];
            }

            $quantity = max(1, (int) $lockedPayment->qty);

            $classPayment->update([
                'price' => $paymentAmount / $quantity,
                'price_final' => $paymentAmount,
                'jumlah' => $quantity,
            ]);

            return [
                'success' => true,
                'payment' => $lockedPayment->fresh(),
                'payment_url' => null,
                'class_payment_id' => $classPayment->id,
            ];
        });

        if (! $preparedPayment['success']) {
            return back()->with('error', $preparedPayment['message']);
        }

        if ($preparedPayment['payment_url']) {
            return redirect()->away($preparedPayment['payment_url']);
        }

        $paymentUrl = $this->createIhtDokuPaymentUrl($preparedPayment['payment'], $user);

        if (! $paymentUrl) {
            return back()->with('error', 'Gagal membuat link pembayaran IHT. Silakan coba lagi.');
        }

        DB::transaction(function () use ($preparedPayment, $paymentUrl) {
            $lockedPayment = DataPayment::whereKey($preparedPayment['payment']->id)->lockForUpdate()->first();

            if (! $lockedPayment || ! $lockedPayment->canPayConfirmedIht()) {
                return;
            }

            if (! $lockedPayment->link_payment) {
                $lockedPayment->update([
                    'link_payment' => $paymentUrl,
                    'expired' => self::IHT_PAYMENT_DUE_MINUTES,
                ]);
            }

            ClassPaymentModel::whereKey($preparedPayment['class_payment_id'])->update(['file' => $lockedPayment->link_payment ?: $paymentUrl]);
        });

        return redirect()->away($paymentUrl);
    }

    private function createClassDokuPaymentUrl(string $invoiceNumber, float $amount, $user, int $classId, int $quantity): ?string
    {
        $paymentAmount = (int) round($amount);

        if ($paymentAmount < 1) {
            return null;
        }

        $clientId = env('DOKU_CLIENT_ID');
        $secretKey = env('DOKU_SECRET_KEY');
        $dokuUrl = rtrim((string) env('DOKU_URL'), '/');

        if (! $clientId || ! $secretKey || ! $dokuUrl) {
            Log::warning('Konfigurasi DOKU kelas belum lengkap', [
                'invoice' => $invoiceNumber,
                'class_id' => $classId,
            ]);

            return null;
        }
        $callbackurl = null;
        $payment = DataPayment::where('no_invoice', $invoiceNumber)->firstOrFail();
        if ($payment->meteri_id) {
            $callbackurl = route('siswa.materi.belajar', $classId);
        } elseif ($payment->submateri_id) {
            $callbackurl = route('siswa.umum.belajar', $classId);
        }
        $timestamp = now()->toIso8601ZuluString();
        $requestId = Str::uuid()->toString();
        $body = [
            'order' => [
                'amount' => $paymentAmount,
                'invoice_number' => $invoiceNumber,
                'callback_url' => $user->siswa
                    ? $callbackurl
                    : url('/pembayaran?invoice_number=' . urlencode($invoiceNumber)),
                'line_items' => [
                    [
                        'name' => 'Pembayaran Kelas',
                        'price' => $paymentAmount,
                        'quantity' => 1,
                    ],
                ],
            ],
            'customer' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'payment' => [
                'payment_due_date' => self::MEMBERSHIP_PAYMENT_DUE_MINUTES,
            ],
            'additional_info' => [
                'user_id' => $user->id,
                'class_id' => $classId,
                'qty' => $quantity,
                'pembelian_tipe' => 2,
                'override_notification_url' => env('DOKU_NOTIFICATION_URL', url('/api/c4/notifikasi')),
            ],
        ];

        $jsonBody = json_encode($body);
        $digest = base64_encode(hash('sha256', $jsonBody, true));
        $rawSignature = 'Client-Id:' . $clientId . "\n" .
            'Request-Id:' . $requestId . "\n" .
            'Request-Timestamp:' . $timestamp . "\n" .
            'Request-Target:/checkout/v1/payment' . "\n" .
            'Digest:' . $digest;
        $signature = base64_encode(hash_hmac('sha256', $rawSignature, $secretKey, true));

        try {
            $response = Http::timeout(15)->withHeaders([
                'Client-Id' => $clientId,
                'Request-Id' => $requestId,
                'Request-Timestamp' => $timestamp,
                'Signature' => 'HMACSHA256=' . $signature,
                'Digest' => $digest,
                'Content-Type' => 'application/json',
            ])->post($dokuUrl . '/checkout/v1/payment', $body);
        } catch (Throwable $exception) {
            Log::error('Gagal membuat pembayaran kelas DOKU', [
                'invoice' => $invoiceNumber,
                'class_id' => $classId,
                'error' => $exception->getMessage(),
            ]);

            return null;
        }

        $paymentUrl = $response->json('response.payment.url');

        if ($response->successful() && $paymentUrl) {
            return $paymentUrl;
        }

        Log::warning('DOKU tidak mengembalikan URL pembayaran kelas', [
            'invoice' => $invoiceNumber,
            'class_id' => $classId,
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return null;
    }

    private function createIhtDokuPaymentUrl(DataPayment $payment, $user): ?string
    {
        $paymentAmount = (int) round((float) $payment->nominal);

        if ($paymentAmount < 1 || ! $payment->class_id) {
            return null;
        }

        $clientId = env('DOKU_CLIENT_ID');
        $secretKey = env('DOKU_SECRET_KEY');
        $dokuUrl = rtrim((string) env('DOKU_URL'), '/');

        if (! $clientId || ! $secretKey || ! $dokuUrl) {
            Log::warning('Konfigurasi DOKU IHT belum lengkap', [
                'invoice' => $payment->no_invoice,
                'class_id' => $payment->class_id,
            ]);

            return null;
        }

        $timestamp = now()->toIso8601ZuluString();
        $requestId = Str::uuid()->toString();
        $quantity = max(1, (int) $payment->qty);
        $classTitle = data_get($payment->paymentClass, 'title');
        $itemName = $this->sanitizeDokuText('Pembayaran Kelas IHT' . ($classTitle ? ' - ' . $classTitle : ''), 'Pembayaran Kelas IHT');
        $customerName = $this->sanitizeDokuText($user->name, 'Customer Bankir Academy', 100);
        $body = [
            'order' => [
                'amount' => $paymentAmount,
                'invoice_number' => $payment->no_invoice,
                'callback_url' => url('/pembayaran?invoice_number=' . urlencode($payment->no_invoice)),
                'line_items' => [
                    [
                        'name' => $itemName,
                        'price' => $paymentAmount,
                        'quantity' => 1,
                    ],
                ],
            ],
            'customer' => [
                'name' => $customerName,
                'email' => $user->email,
            ],
            'payment' => [
                'payment_due_date' => self::IHT_PAYMENT_DUE_MINUTES,
            ],
            'additional_info' => [
                'user_id' => $user->id,
                'class_id' => (int) $payment->class_id,
                'qty' => $quantity,
                'pembelian_tipe' => DataPayment::PURCHASE_TYPE_CLASS,
                'is_iht' => 1,
                'override_notification_url' => env('DOKU_NOTIFICATION_URL', url('/api/c4/notifikasi')),
            ],
        ];

        $jsonBody = json_encode($body);
        $digest = base64_encode(hash('sha256', $jsonBody, true));
        $rawSignature = 'Client-Id:' . $clientId . "\n" .
            'Request-Id:' . $requestId . "\n" .
            'Request-Timestamp:' . $timestamp . "\n" .
            'Request-Target:/checkout/v1/payment' . "\n" .
            'Digest:' . $digest;
        $signature = base64_encode(hash_hmac('sha256', $rawSignature, $secretKey, true));

        try {
            $response = Http::timeout(15)->withHeaders([
                'Client-Id' => $clientId,
                'Request-Id' => $requestId,
                'Request-Timestamp' => $timestamp,
                'Signature' => 'HMACSHA256=' . $signature,
                'Digest' => $digest,
                'Content-Type' => 'application/json',
            ])->post($dokuUrl . '/checkout/v1/payment', $body);
        } catch (Throwable $exception) {
            Log::error('Gagal membuat pembayaran IHT DOKU', [
                'invoice' => $payment->no_invoice,
                'class_id' => $payment->class_id,
                'error' => $exception->getMessage(),
            ]);

            return null;
        }

        $paymentUrl = $response->json('response.payment.url');

        if ($response->successful() && $paymentUrl) {
            return $paymentUrl;
        }

        Log::warning('DOKU tidak mengembalikan URL pembayaran IHT', [
            'invoice' => $payment->no_invoice,
            'class_id' => $payment->class_id,
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return null;
    }

    private function sanitizeDokuText(?string $value, string $fallback, int $limit = 255): string
    {
        $text = Str::ascii((string) $value);
        $text = preg_replace("/[^a-zA-Z0-9 .\-\/+,=_:'@%]/", ' ', $text) ?? '';
        $text = preg_replace('/\s+/', ' ', $text) ?? '';
        $text = trim($text);

        if ($text === '') {
            $text = $fallback;
        }

        return Str::limit($text, $limit, '');
    }
}
