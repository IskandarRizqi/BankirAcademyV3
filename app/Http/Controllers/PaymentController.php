<?php

namespace App\Http\Controllers;

use App\Models\BiayaSertifikatModel;
use App\Models\ClassesModel;
use App\Models\ClassParticipantModel;
use App\Models\ClassPaymentModel;
use App\Models\ClassPricingModel;
use App\Models\DataPayment;
use App\Models\SertifikatPesertaModel;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class PaymentController extends Controller
{
    private const MEMBERSHIP_PRICE = 3000000;
    private const MEMBERSHIP_PAYMENT_DUE_MINUTES = 60;

    public function paymentmembership(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            abort(401);
        }

        $profile = UserProfileModel::where('user_id', $user->id)->first();

        if (!$profile) {
            return back()->with('error', 'Profil pengguna tidak ditemukan.');
        }

        $clientId = env('DOKU_CLIENT_ID');
        $secretKey = env('DOKU_SECRET_KEY');
        $dokuUrl = rtrim((string) env('DOKU_URL'), '/');

        if (!$clientId || !$secretKey || !$dokuUrl) {
            return back()->with('error', 'Konfigurasi pembayaran belum lengkap.');
        }

        $qty = 1;
        $totalbayar = self::MEMBERSHIP_PRICE * $qty;
        $temporaryInvoice = 'BANKIR-PENDING-' . now()->format('YmdHisv') . '-' . random_int(1000, 9999);

        $datapayment = DataPayment::create([
            'no_invoice' => $temporaryInvoice,
            'user_id' => $user->id,
            'pembelian' => DataPayment::PURCHASE_MEMBERSHIP,
            'nominal' => $totalbayar,
            'expired' => self::MEMBERSHIP_PAYMENT_DUE_MINUTES,
            'qty' => $qty,
            'status' => DataPayment::STATUS_PENDING,
            'keterangan' => 'Membership perusahaan',
        ]);

        $nomorinvoice = 'BANKIR-' . $datapayment->created_at->format('YmdHis') . '-' . $datapayment->id;
        $datapayment->update(['no_invoice' => $nomorinvoice]);

        $timestamp = now()->toIso8601ZuluString();
        $requestId = Str::uuid()->toString();

        $body = [
            'order' => [
                'amount' => $totalbayar,
                'invoice_number' => $nomorinvoice,
                'callback_url' => url('/pembayaran'),
                'line_items' => [
                    [
                        'name' => 'Membership',
                        'price' => self::MEMBERSHIP_PRICE,
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
                'pembelian_tipe' => 1,
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

    public function paymentorderclass(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            abort(401);
        }

        $validated = $request->validate([
            'class_id' => ['required', 'integer', 'exists:classes,id'],
            'jml_peserta' => ['required', 'integer', 'min:1'],
            'sertifikat_invoice' => ['required', 'in:0,1'],
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
        $class = ClassesModel::select('id', 'participant_limit')->whereKey($classId)->first();

        if (!$class) {
            return back()->withInput()->with('error', 'Kelas tidak ditemukan.');
        }

        $remainingQuota = ClassParticipantModel::remainingQuotaForClass($classId, (int) $class->participant_limit);

        if ($remainingQuota !== null && $jumlahPeserta > $remainingQuota) {
            return back()->withInput()->with('error', 'Kuota kelas tidak mencukupi. Sisa kuota: ' . $remainingQuota . ' peserta.');
        }

        $pricing = ClassPricingModel::where('class_id', $classId)->first();

        if (!$pricing) {
            return back()->withInput()->with('error', 'Harga kelas belum tersedia.');
        }

        $isFreeClass = $pricing->isFree();
        $pricePerParticipant = $pricing->effectivePrice();

        $classTotal = $pricePerParticipant * $jumlahPeserta;
        $certificateTotal = 0;

        if (!$isFreeClass && (int) $validated['sertifikat_invoice'] === 1) {
            $certificateFee = BiayaSertifikatModel::where('class_id', $classId)->first();

            if ($certificateFee) {
                $certificatePerParticipant = (int) $certificateFee->type > 0
                    ? ($pricePerParticipant * ((float) $certificateFee->nominal / 100))
                    : (float) $certificateFee->nominal;
            } else {
                $certificatePerParticipant = 100000;
            }

            $certificateTotal = $certificatePerParticipant * $jumlahPeserta;
        }

        $grandTotal = $classTotal + $certificateTotal;
        $paymentStatus = $isFreeClass ? DataPayment::STATUS_PAID : DataPayment::STATUS_PENDING;

        $result = DB::transaction(function () use (
            $user,
            $classId,
            $jumlahPeserta,
            $pricePerParticipant,
            $certificateTotal,
            $grandTotal,
            $paymentStatus,
            $isFreeClass,
            $validated
        ) {
            $class = ClassesModel::select('id', 'participant_limit')->whereKey($classId)->lockForUpdate()->first();

            if (!$class) {
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

            $temporaryInvoice = 'BANKIR-CLASS-PENDING-' . now()->format('YmdHisv') . '-' . random_int(1000, 9999);

            $classPayment = ClassPaymentModel::create([
                'status' => $paymentStatus === DataPayment::STATUS_PAID ? 1 : 0,
                'user_id' => $user->id,
                'class_id' => $classId,
                'unique_code' => random_int(0, 999),
                'price' => $pricePerParticipant,
                'biaya_sertifikat' => $certificateTotal,
                'price_final' => $grandTotal,
                'expired' => now()->endOfDay(),
                'no_invoice' => $temporaryInvoice,
                'jumlah' => $jumlahPeserta,
            ]);

            $dataPayment = DataPayment::create([
                'no_invoice' => 'BANKIR-CLASS-DATA-PENDING-' . now()->format('YmdHisv') . '-' . random_int(1000, 9999),
                'user_id' => $user->id,
                'class_id' => $classId,
                'pembelian' => DataPayment::PURCHASE_CLASS,
                'nominal' => $grandTotal,
                'qty' => $jumlahPeserta,
                'status' => $paymentStatus,
                'keterangan' => 'Pembelian kelas',
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
                'needsPaymentGateway' => !$isFreeClass,
            ];
        });

        if (!$result['success']) {
            return back()->withInput()->with('error', $result['message']);
        }

        if ($result['needsPaymentGateway']) {
            $paymentUrl = $this->createClassDokuPaymentUrl(
                $result['dataPayment']->no_invoice,
                $grandTotal,
                $user,
                $classId,
                $jumlahPeserta
            );

            if (!$paymentUrl) {
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

        return redirect('dash-beranda')->with([
            'success_payment' => 'Data pembelian kelas berhasil disimpan.',
            'invoice_number' => $result['dataPayment']->no_invoice,
        ]);
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

        if (!$clientId || !$secretKey || !$dokuUrl) {
            Log::warning('Konfigurasi DOKU kelas belum lengkap', [
                'invoice' => $invoiceNumber,
                'class_id' => $classId,
            ]);

            return null;
        }

        $timestamp = now()->toIso8601ZuluString();
        $requestId = Str::uuid()->toString();
        $body = [
            'order' => [
                'amount' => $paymentAmount,
                'invoice_number' => $invoiceNumber,
                'callback_url' => url('/pembayaran'),
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
}
