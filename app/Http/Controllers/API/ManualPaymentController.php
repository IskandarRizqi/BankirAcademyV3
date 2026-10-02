<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BiayaSertifikatModel;
use App\Models\ClassesModel;
use App\Models\ClassParticipantModel;
use App\Models\ClassPaymentModel;
use App\Models\DataPayment;
use App\Models\RiwayatTransaksi;
use App\Models\SertifikatPesertaModel;
use App\Models\SubMateriModel;
use App\Services\ClassPricingService;
use App\Services\PaymentExpiryService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManualPaymentController extends Controller
{
    private const PAYMENT_DUE_MINUTES = 1440;

    public function __construct(
        private PaymentExpiryService $paymentExpiryService,
        private ClassPricingService $classPricingService
    ) {}

    public function storeClass(Request $request): JsonResponse
    {
        $this->normalizeParticipants($request);

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

        $participantCount = count($validated['nama']);

        if (
            count($validated['email']) !== $participantCount
            || count($validated['nomor_handphone']) !== $participantCount
            || (int) $validated['jml_peserta'] !== $participantCount
        ) {
            return $this->errorResponse('Jumlah data peserta tidak sesuai dengan jumlah peserta.', 422);
        }

        $user = $request->user();
        $class = ClassesModel::query()
            ->select('id', 'title', 'participant_limit', 'kategori', 'iht', 'date_start')
            ->whereKey((int) $validated['class_id'])
            ->first();

        if (! $class) {
            return $this->errorResponse('Kelas tidak ditemukan.', 404);
        }

        if ($class->date_start && now()->startOfDay()->lt(Carbon::parse($class->date_start)->startOfDay())) {
            return $this->errorResponse('Kelas masih upcoming dan belum dapat didaftarkan.', 422);
        }

        $remainingQuota = ClassParticipantModel::remainingQuotaForClass(
            (int) $class->id,
            (int) $class->participant_limit
        );

        if ($remainingQuota !== null && $participantCount > $remainingQuota) {
            return $this->errorResponse('Kuota kelas tidak mencukupi. Sisa kuota: '.$remainingQuota.' peserta.', 422);
        }

        $pricing = $this->classPricingService->resolve($class, $user, $participantCount);

        if (! $pricing['regular_purchase_allowed']) {
            return $this->errorResponse('Kelas IHT hanya dapat diproses melalui order manual admin.', 422);
        }

        if (! $pricing['base_price'] && ! $pricing['is_iht']) {
            return $this->errorResponse('Harga kelas belum tersedia.', 422);
        }

        $pricePerParticipant = (float) $pricing['final_price'];
        $certificateTotal = $this->certificateTotal(
            (int) $validated['class_id'],
            $pricePerParticipant,
            $participantCount,
            (int) $validated['sertifikat_invoice'] === 1
        );
        $grandTotal = ($pricePerParticipant * $participantCount) + $certificateTotal;
        $paymentStatus = $grandTotal <= 0 ? DataPayment::STATUS_PAID : DataPayment::STATUS_PENDING;

        $result = DB::transaction(function () use (
            $user,
            $class,
            $validated,
            $participantCount,
            $pricing,
            $pricePerParticipant,
            $certificateTotal,
            $grandTotal,
            $paymentStatus
        ) {
            $lockedClass = ClassesModel::query()
                ->select('id', 'participant_limit')
                ->whereKey($class->id)
                ->lockForUpdate()
                ->first();

            if (! $lockedClass) {
                return ['success' => false, 'message' => 'Kelas tidak ditemukan.'];
            }

            $remainingQuota = ClassParticipantModel::remainingQuotaForClass(
                (int) $lockedClass->id,
                (int) $lockedClass->participant_limit
            );

            if ($remainingQuota !== null && $participantCount > $remainingQuota) {
                return [
                    'success' => false,
                    'message' => 'Kuota kelas tidak mencukupi. Sisa kuota: '.$remainingQuota.' peserta.',
                ];
            }

            $temporaryInvoice = 'BANKIR-MNL-'.now()->format('YmdHisv').'-'.random_int(1000, 9999);
            $classPayment = ClassPaymentModel::create([
                'status' => $paymentStatus === DataPayment::STATUS_PAID ? 1 : 0,
                'user_id' => $user->id,
                'class_id' => $class->id,
                'unique_code' => random_int(0, 999),
                'price' => $pricePerParticipant,
                'additional_discount' => json_encode([
                    'base_price' => $pricing['base_price'],
                    'general_discount' => $pricing['general_discount'],
                    'membership_discount' => $pricing['membership_discount'],
                    'participant_discount' => $pricing['participant_discount'],
                    'participant_discount_total' => $pricing['participant_discount_total'],
                    'participant_discount_threshold' => $pricing['participant_discount_threshold'],
                    'participant_count' => $participantCount,
                    'total_discount' => $pricing['total_discount'],
                    'discount_percent' => $pricing['discount_percent'],
                    'membership_type' => $pricing['membership_type'],
                    'discount_source' => $pricing['discount_source'],
                ]),
                'biaya_sertifikat' => $certificateTotal,
                'price_final' => $grandTotal,
                'expired' => now()->addDay(),
                'no_invoice' => $temporaryInvoice,
                'jumlah' => $participantCount,
            ]);

            $dataPayment = DataPayment::create([
                'no_invoice' => $temporaryInvoice,
                'user_id' => $user->id,
                'class_id' => $class->id,
                'pembelian' => DataPayment::PURCHASE_CLASS,
                'expired' => self::PAYMENT_DUE_MINUTES,
                'nominal' => $grandTotal,
                'qty' => $participantCount,
                'status' => $paymentStatus,
                'keterangan' => 'Pembelian kelas (Transfer Manual)',
                'tipe_pembelian' => DataPayment::PURCHASE_TYPE_CLASS,
                'payment_method' => 'manual',
            ]);

            $invoiceNumber = 'BANKIR-MNL-'.$dataPayment->created_at->format('YmdHis').'-'.$dataPayment->id;
            $dataPayment->update(['no_invoice' => $invoiceNumber]);
            $classPayment->update(['no_invoice' => $invoiceNumber]);

            ClassParticipantModel::updateOrCreate(
                [
                    'payment_id' => $classPayment->id,
                    'user_id' => $user->id,
                ],
                [
                    'class_id' => $class->id,
                    'certificate' => (int) $validated['sertifikat_invoice'],
                    'jumlah' => $participantCount,
                ]
            );

            SertifikatPesertaModel::create([
                'user_id' => $user->id,
                'class_id' => $class->id,
                'payment_class_id' => $classPayment->id,
                'nama' => json_encode($validated['nama']),
                'email' => json_encode($validated['email']),
                'nohp' => json_encode($validated['nomor_handphone']),
            ]);

            return [
                'success' => true,
                'payment' => $dataPayment->fresh(),
            ];
        });

        if (! $result['success']) {
            return $this->errorResponse($result['message'], 422);
        }

        $result['payment']->load(['paymentClass', 'classPayment', 'subMateri']);

        return response()->json([
            'success' => true,
            'message' => $paymentStatus === DataPayment::STATUS_PAID
                ? 'Kelas gratis berhasil diaktifkan.'
                : 'Order kelas berhasil dibuat. Silakan transfer dan upload bukti pembayaran.',
            'data' => [
                'payment' => $this->paymentData($result['payment']),
                'manual_transfer' => $this->manualTransferData(),
            ],
        ], 201);
    }

    public function storeEbook(Request $request): JsonResponse
    {
        return $this->storeMaterial($request, DataPayment::PURCHASE_TYPE_EBOOK);
    }

    public function storeVideo(Request $request): JsonResponse
    {
        return $this->storeMaterial($request, DataPayment::PURCHASE_TYPE_VIDEO);
    }

    public function index(Request $request): JsonResponse
    {
        $userId = (int) $request->user()->id;
        $this->paymentExpiryService->syncForUser($userId);

        $query = DataPayment::query()
            ->with(['paymentClass', 'subMateri', 'riwayatTransaksi'])
            ->where('user_id', $userId)
            ->whereIn('tipe_pembelian', [
                DataPayment::PURCHASE_TYPE_CLASS,
                DataPayment::PURCHASE_TYPE_EBOOK,
                DataPayment::PURCHASE_TYPE_VIDEO,
            ])
            ->latest();

        if ($request->filled('type')) {
            $type = match (strtolower((string) $request->input('type'))) {
                'kelas', 'class' => DataPayment::PURCHASE_TYPE_CLASS,
                'ebook' => DataPayment::PURCHASE_TYPE_EBOOK,
                'video' => DataPayment::PURCHASE_TYPE_VIDEO,
                default => null,
            };

            if ($type === null) {
                return $this->errorResponse('Filter type harus kelas, ebook, atau video.', 422);
            }

            $query->where('tipe_pembelian', $type);
        }

        if ($request->filled('status')) {
            $status = $this->statusValue($request->input('status'));

            if ($status === null) {
                return $this->errorResponse('Status pembayaran tidak valid.', 422);
            }

            $query->where('status', $status);
        }

        $perPage = min(50, max(1, (int) $request->input('per_page', 15)));
        $payments = $query->paginate($perPage)->withQueryString();

        return response()->json([
            'success' => true,
            'data' => [
                'summary' => $this->summary($userId),
                'payments' => collect($payments->items())->map(fn (DataPayment $payment) => $this->paymentData($payment))->values(),
                'pagination' => [
                    'current_page' => $payments->currentPage(),
                    'last_page' => $payments->lastPage(),
                    'per_page' => $payments->perPage(),
                    'total' => $payments->total(),
                ],
            ],
        ]);
    }

    public function show(Request $request, DataPayment $payment): JsonResponse
    {
        abort_unless((int) $payment->user_id === (int) $request->user()->id, 404);

        $this->paymentExpiryService->expireIfNeeded($payment);
        $payment->load(['paymentClass', 'subMateri', 'riwayatTransaksi', 'classPayment']);

        return response()->json([
            'success' => true,
            'data' => [
                'payment' => $this->paymentData($payment->fresh(['paymentClass', 'subMateri', 'riwayatTransaksi', 'classPayment'])),
                'manual_transfer' => $this->manualTransferData(),
            ],
        ]);
    }

    public function uploadProof(Request $request, DataPayment $payment): JsonResponse
    {
        abort_unless((int) $payment->user_id === (int) $request->user()->id, 404);

        $request->validate([
            'link_payment' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $isManual = $payment->payment_method === 'manual'
            || ($payment->payment_method === null && ! filter_var($payment->link_payment, FILTER_VALIDATE_URL));

        if (! $isManual) {
            return $this->errorResponse('Transaksi ini menggunakan pembayaran gateway.', 422);
        }

        if (! in_array((int) $payment->status, [
            DataPayment::STATUS_PENDING,
            DataPayment::STATUS_WAITING_CONFIRMATION,
            DataPayment::STATUS_REJECTED,
        ], true)) {
            return $this->errorResponse('Transaksi tidak dapat menerima bukti transfer.', 422);
        }

        if ($payment->link_payment && ! filter_var($payment->link_payment, FILTER_VALIDATE_URL)
            && Storage::disk('public')->exists($payment->link_payment)) {
            Storage::disk('public')->delete($payment->link_payment);
        }

        $path = $request->file('link_payment')->store('link_payment', 'public');
        $payment->update([
            'link_payment' => $path,
            'status' => DataPayment::STATUS_WAITING_CONFIRMATION,
            'rejection_reason' => null,
        ]);
        $payment->load(['paymentClass', 'subMateri', 'riwayatTransaksi', 'classPayment']);

        return response()->json([
            'success' => true,
            'message' => 'Bukti transfer berhasil diunggah. Menunggu konfirmasi admin.',
            'data' => [
                'payment' => $this->paymentData($payment),
            ],
        ]);
    }

    private function storeMaterial(Request $request, int $purchaseType): JsonResponse
    {
        $request->merge([
            'submateri_id' => $request->input('submateri_id', $request->input('class_id')),
        ]);

        $validated = $request->validate([
            'submateri_id' => ['required', 'integer', 'exists:sub_materi,id'],
        ]);

        $subMateri = SubMateriModel::query()
            ->with('materi')
            ->whereHas('items', function ($query) use ($purchaseType) {
                $query->where('tipe_link_item', $purchaseType === DataPayment::PURCHASE_TYPE_EBOOK ? 1 : 0);
            })
            ->whereKey((int) $validated['submateri_id'])
            ->firstOrFail();
        $user = $request->user();
        $this->paymentExpiryService->syncForUser((int) $user->id);

        $existingPayment = DataPayment::query()
            ->with(['paymentClass', 'subMateri', 'riwayatTransaksi'])
            ->where('user_id', $user->id)
            ->where('submateri_id', $subMateri->id)
            ->where('tipe_pembelian', $purchaseType)
            ->whereIn('status', [
                DataPayment::STATUS_PENDING,
                DataPayment::STATUS_WAITING_CONFIRMATION,
                DataPayment::STATUS_REJECTED,
            ])
            ->latest('id')
            ->first();

        if ($existingPayment) {
            return response()->json([
                'success' => true,
                'message' => 'Order pembayaran yang sama masih tersedia.',
                'data' => [
                    'payment' => $this->paymentData($existingPayment),
                    'manual_transfer' => $this->manualTransferData(),
                ],
            ]);
        }

        $hasAccess = DB::table('history_pelatihan')
            ->where('user_id', $user->id)
            ->where('sub_materi_id', $subMateri->id)
            ->exists();

        if ($hasAccess) {
            return $this->errorResponse('Materi ini sudah dapat diakses oleh akun Anda.', 409);
        }

        $nominal = max(0, (float) ($subMateri->harga_final ?? $subMateri->harga ?? 0));
        $purchase = $purchaseType === DataPayment::PURCHASE_TYPE_EBOOK
            ? DataPayment::PURCHASE_EBOOK
            : DataPayment::PURCHASE_VIDEO;
        $label = $purchaseType === DataPayment::PURCHASE_TYPE_EBOOK ? 'Ebook' : 'Video';
        $paymentStatus = $nominal <= 0 ? DataPayment::STATUS_PAID : DataPayment::STATUS_PENDING;

        $payment = DB::transaction(function () use ($user, $subMateri, $nominal, $purchase, $purchaseType, $label, $paymentStatus) {
            $dataPayment = DataPayment::create([
                'no_invoice' => 'BANKIR-MNL-'.now()->format('YmdHisv').'-'.random_int(1000, 9999),
                'user_id' => $user->id,
                'materi_id' => $subMateri->id_materi,
                'submateri_id' => $subMateri->id,
                'pembelian' => $purchase,
                'expired' => self::PAYMENT_DUE_MINUTES,
                'nominal' => $nominal,
                'qty' => 1,
                'status' => $paymentStatus,
                'keterangan' => $nominal > 0
                    ? 'Pembelian '.$label.' (Transfer Manual)'
                    : 'Klaim '.$label.' Gratis',
                'tipe_pembelian' => $purchaseType,
                'payment_method' => 'manual',
            ]);

            $invoiceNumber = 'BANKIR-MNL-'.$dataPayment->created_at->format('YmdHis').'-'.$dataPayment->id;
            $dataPayment->update(['no_invoice' => $invoiceNumber]);

            if ($nominal > 0) {
                RiwayatTransaksi::create([
                    'user_id' => $user->id,
                    'class_id' => $subMateri->id,
                    'nominal_transaksi' => $nominal,
                    'metode_pembayaran' => 'Transfer Manual BCA',
                    'no_invoice' => $invoiceNumber,
                    'status' => 'PENDING',
                    'manual' => 1,
                    'expired' => now()->addDay(),
                    'keterangan' => 'Pembelian '.$label.' via Transfer Manual.',
                ]);
            } else {
                DB::table('history_pelatihan')->updateOrInsert(
                    ['user_id' => $user->id, 'sub_materi_id' => $subMateri->id],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }

            return $dataPayment->fresh();
        });

        $payment->load(['paymentClass', 'subMateri', 'riwayatTransaksi']);

        return response()->json([
            'success' => true,
            'message' => $paymentStatus === DataPayment::STATUS_PAID
                ? $label.' gratis berhasil diaktifkan.'
                : 'Order '.$label.' berhasil dibuat. Silakan transfer dan upload bukti pembayaran.',
            'data' => [
                'payment' => $this->paymentData($payment),
                'manual_transfer' => $this->manualTransferData(),
            ],
        ], 201);
    }

    private function normalizeParticipants(Request $request): void
    {
        $participants = $request->input('participants');

        if (is_string($participants)) {
            $participants = json_decode($participants, true);
        }

        if (! is_array($participants)) {
            return;
        }

        $request->merge([
            'jml_peserta' => count($participants),
            'nama' => collect($participants)->pluck('name')->all(),
            'email' => collect($participants)->pluck('email')->all(),
            'nomor_handphone' => collect($participants)->map(
                fn ($participant) => is_array($participant)
                    ? ($participant['phone'] ?? $participant['nomor_handphone'] ?? null)
                    : null
            )->all(),
        ]);
    }

    private function certificateTotal(int $classId, float $pricePerParticipant, int $participantCount, bool $hasCertificate): float
    {
        if (! $hasCertificate) {
            return 0;
        }

        $certificateFee = BiayaSertifikatModel::where('class_id', $classId)->first();

        if (! $certificateFee) {
            return 100000 * $participantCount;
        }

        $certificatePerParticipant = $pricePerParticipant <= 0
            ? (float) $certificateFee->nominal
            : ((int) $certificateFee->type > 0
                ? ($pricePerParticipant * ((float) $certificateFee->nominal / 100))
                : (float) $certificateFee->nominal);

        return max(0, $certificatePerParticipant * $participantCount);
    }

    private function paymentData(DataPayment $payment): array
    {
        $type = match ((int) $payment->tipe_pembelian) {
            DataPayment::PURCHASE_TYPE_CLASS => 'kelas',
            DataPayment::PURCHASE_TYPE_EBOOK => 'ebook',
            DataPayment::PURCHASE_TYPE_VIDEO => 'video',
            default => 'lainnya',
        };
        $status = $payment->billingStatus();
        $proofPath = $payment->link_payment && ! filter_var($payment->link_payment, FILTER_VALIDATE_URL)
            ? $payment->link_payment
            : null;
        $product = $type === 'kelas' && $payment->paymentClass
            ? [
                'id' => $payment->paymentClass->id,
                'name' => $payment->paymentClass->title,
                'image' => $payment->paymentClass->image,
                'image_mobile' => $payment->paymentClass->image_mobile,
            ]
            : ($payment->subMateri ? [
                'id' => $payment->subMateri->id,
                'name' => $payment->subMateri->nama,
                'thumbnail' => $payment->subMateri->thumbnail,
                'materi_id' => $payment->subMateri->id_materi,
            ] : null);

        return [
            'id' => $payment->id,
            'invoice_number' => $payment->no_invoice,
            'type' => $type,
            'product' => $product,
            'nominal' => (float) $payment->nominal,
            'quantity' => (float) $payment->qty,
            'status' => $status,
            'status_key' => $this->statusKey($status),
            'status_label' => $this->statusLabel($status),
            'payment_method' => $payment->payment_method,
            'proof_uploaded' => filled($proofPath),
            'proof_url' => $proofPath ? url(Storage::disk('public')->url($proofPath)) : null,
            'rejection_reason' => $payment->rejection_reason,
            'expires_at' => optional($payment->paymentExpiresAt())->toISOString(),
            'can_upload_proof' => $payment->payment_method === 'manual'
                && in_array($status, [
                    DataPayment::STATUS_PENDING,
                    DataPayment::STATUS_WAITING_CONFIRMATION,
                    DataPayment::STATUS_REJECTED,
                ], true),
            'created_at' => optional($payment->created_at)->toISOString(),
            'updated_at' => optional($payment->updated_at)->toISOString(),
        ];
    }

    private function summary(int $userId): array
    {
        $payments = DataPayment::query()
            ->where('user_id', $userId)
            ->whereIn('tipe_pembelian', [
                DataPayment::PURCHASE_TYPE_CLASS,
                DataPayment::PURCHASE_TYPE_EBOOK,
                DataPayment::PURCHASE_TYPE_VIDEO,
            ]);

        return [
            'paid_count' => (clone $payments)->where('status', DataPayment::STATUS_PAID)->count(),
            'pending_count' => (clone $payments)->whereIn('status', [
                DataPayment::STATUS_PENDING,
                DataPayment::STATUS_WAITING_CONFIRMATION,
            ])->count(),
            'failed_count' => (clone $payments)->whereIn('status', [
                DataPayment::STATUS_CANCELED,
                DataPayment::STATUS_REJECTED,
            ])->count(),
        ];
    }

    private function manualTransferData(): array
    {
        return [
            'bank_name' => env('MANUAL_PAYMENT_BANK_NAME', 'BCA'),
            'account_number' => env('MANUAL_PAYMENT_ACCOUNT_NUMBER', '803 555 9091'),
            'account_name' => env('MANUAL_PAYMENT_ACCOUNT_NAME', 'PT Bankir Academy Indonesia'),
        ];
    }

    private function statusValue($status): ?int
    {
        if (is_numeric($status)) {
            $status = (int) $status;

            return in_array($status, [
                DataPayment::STATUS_PAID,
                DataPayment::STATUS_PENDING,
                DataPayment::STATUS_WAITING_CONFIRMATION,
                DataPayment::STATUS_REJECTED,
                DataPayment::STATUS_CANCELED,
            ], true) ? $status : null;
        }

        return match (strtolower((string) $status)) {
            'paid', 'lunas', 'berhasil' => DataPayment::STATUS_PAID,
            'pending', 'menunggu' => DataPayment::STATUS_PENDING,
            'waiting_confirmation', 'menunggu_konfirmasi' => DataPayment::STATUS_WAITING_CONFIRMATION,
            'rejected', 'ditolak' => DataPayment::STATUS_REJECTED,
            'canceled', 'dibatalkan' => DataPayment::STATUS_CANCELED,
            default => null,
        };
    }

    private function statusKey(int $status): string
    {
        return match ($status) {
            DataPayment::STATUS_PAID => 'paid',
            DataPayment::STATUS_PENDING => 'pending',
            DataPayment::STATUS_WAITING_CONFIRMATION => 'waiting_confirmation',
            DataPayment::STATUS_REJECTED => 'rejected',
            DataPayment::STATUS_CANCELED => 'canceled',
            default => 'unknown',
        };
    }

    private function statusLabel(int $status): string
    {
        return match ($status) {
            DataPayment::STATUS_PAID => 'Lunas',
            DataPayment::STATUS_PENDING => 'Menunggu Pembayaran',
            DataPayment::STATUS_WAITING_CONFIRMATION => 'Menunggu Konfirmasi',
            DataPayment::STATUS_REJECTED => 'Bukti Ditolak',
            DataPayment::STATUS_CANCELED => 'Dibatalkan',
            default => 'Tidak Diketahui',
        };
    }

    private function errorResponse(string $message, int $status): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }
}
