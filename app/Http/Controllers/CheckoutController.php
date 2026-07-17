<?php

namespace App\Http\Controllers;

use App\Models\BiayaSertifikatModel;
use App\Models\ClassesModel;
use App\Models\ClassParticipantModel;
use App\Models\ClassPaymentModel;
use App\Models\ClassPricingModel;
use App\Models\CorporateRegistration;
use App\Models\DataPayment;
use App\Models\DepositUsed;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\SertifikatPesertaModel;
use App\Models\UserProfileModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;


class CheckoutController extends Controller
{
    public function handleDokuTransactionNotification(Request $request)
    {
        $invoiceNumber = $this->extractDokuInvoiceNumber($request);

        if (!$invoiceNumber) {
            return response()->json(['message' => 'Invalid webhook payload'], 400);
        }

        if (strtok($invoiceNumber, '-') !== 'BANKIR') {
            return response()->json(['message' => 'Notification ignored'], 200);
        }

        $notification = $this->resolveDokuNotificationData($request, $invoiceNumber);

        if (!$notification) {
            return response()->json(['message' => 'Unable to verify payment status'], 500);
        }

        if (!$notification['payment_status']) {
            return response()->json(['message' => 'Invalid webhook payload'], 400);
        }

        $payment = DataPayment::where('no_invoice', $invoiceNumber)->first();
        $payloadPurchaseType = data_get($request->all(), 'additional_info.pembelian_tipe')
            ?? data_get($notification['data'], 'additional_info.pembelian_tipe');
        $purchaseType = (int) ($payment->tipe_pembelian ?? $payloadPurchaseType);
        $purchaseName = strtolower((string) ($payment->pembelian ?? ''));

        if ($purchaseType === DataPayment::PURCHASE_TYPE_MEMBERSHIP || $purchaseName === DataPayment::PURCHASE_MEMBERSHIP) {
            $result = $this->processMembershipPayment(
                $invoiceNumber,
                $notification['payment_status'],
                $notification['amount']
            );
        } elseif (
            $purchaseType === DataPayment::PURCHASE_TYPE_CLASS
            || $purchaseName === DataPayment::PURCHASE_CLASS
            || ClassPaymentModel::where('no_invoice', $invoiceNumber)->exists()
        ) {
            $result = $this->processClassPayment(
                $invoiceNumber,
                $notification['payment_status'],
                $notification['amount']
            );
        } else {
            Log::warning('DOKU notification purchase type unknown', [
                'invoice' => $invoiceNumber,
                'tipe_pembelian' => $payment->tipe_pembelian ?? null,
                'pembelian' => $payment->pembelian ?? null,
                'payload_purchase_type' => $payloadPurchaseType,
            ]);

            return response()->json(['message' => 'Invalid purchase type'], 422);
        }

        return response()->json(['message' => $result['message']], $result['status']);
    }

    public function handleNotificationmembership(Request $request)
    {
        $invoiceNumber = $this->extractDokuInvoiceNumber($request);

        if (!$invoiceNumber) {
            return response()->json(['message' => 'Invalid webhook payload'], 400);
        }

        $notification = $this->resolveDokuNotificationData($request, $invoiceNumber);

        if (!$notification) {
            return response()->json(['message' => 'Unable to verify payment status'], 500);
        }

        if (!$notification['payment_status']) {
            return response()->json(['message' => 'Invalid webhook payload'], 400);
        }

        $result = $this->processMembershipPayment(
            $invoiceNumber,
            $notification['payment_status'],
            $notification['amount']
        );

        return response()->json(['message' => $result['message']], $result['status']);
    }

    private function resolveDokuNotificationData(Request $request, string $invoiceNumber): ?array
    {
        $data = $request->all();
        $paymentStatus = $this->extractDokuPaymentStatusFromData($data);
        $amount = $this->extractDokuAmountFromData($data);

        if ($this->isValidDokuSignature($request)) {
            return [
                'payment_status' => $paymentStatus,
                'amount' => $amount,
                'data' => $data,
            ];
        }

        Log::warning('DOKU webhook signature invalid or missing, verifying by check status', [
            'invoice' => $invoiceNumber,
            'has_signature_headers' => $this->hasDokuSignatureHeaders($request),
            'request_id' => $request->header('Request-Id'),
        ]);

        $statusResponse = $this->getDokuOrderStatus($invoiceNumber);

        if (!$statusResponse) {
            return null;
        }

        if ($this->extractDokuInvoiceNumberFromData($statusResponse) !== $invoiceNumber) {
            Log::warning('DOKU check status invoice mismatch', [
                'invoice' => $invoiceNumber,
                'response_invoice' => $this->extractDokuInvoiceNumberFromData($statusResponse),
            ]);

            return null;
        }

        return [
            'payment_status' => $this->extractDokuPaymentStatusFromData($statusResponse),
            'amount' => $this->extractDokuAmountFromData($statusResponse),
            'data' => $statusResponse,
        ];
    }

    private function processMembershipPayment(string $invoiceNumber, string $paymentStatus, ?float $amount): array
    {
        return DB::transaction(function () use ($invoiceNumber, $paymentStatus, $amount) {
            $payment = DataPayment::where('no_invoice', $invoiceNumber)->lockForUpdate()->first();

            if (!$payment) {
                return ['status' => 404, 'message' => 'Payment not found'];
            }

            if (
                (int) $payment->tipe_pembelian !== DataPayment::PURCHASE_TYPE_MEMBERSHIP
                && strtolower((string) $payment->pembelian) !== DataPayment::PURCHASE_MEMBERSHIP
            ) {
                Log::warning('DOKU invalid purchase type for membership processor', [
                    'invoice' => $invoiceNumber,
                    'tipe_pembelian' => $payment->tipe_pembelian,
                    'pembelian' => $payment->pembelian,
                ]);

                return ['status' => 422, 'message' => 'Invalid purchase type'];
            }

            if ($amount !== null && abs((float) $payment->nominal - $amount) > 0.01) {
                Log::warning('DOKU membership amount mismatch', [
                    'invoice' => $invoiceNumber,
                    'expected' => $payment->nominal,
                    'received' => $amount,
                ]);

                return ['status' => 422, 'message' => 'Invalid payment amount'];
            }

            if ((int) $payment->status === DataPayment::STATUS_PAID) {
                return ['status' => 200, 'message' => 'Payment already processed'];
            }

            if (!$this->isSuccessfulDokuStatus($paymentStatus)) {
                if ($this->isFailedDokuStatus($paymentStatus) && (int) $payment->status === DataPayment::STATUS_PENDING) {
                    $payment->update([
                        'status' => DataPayment::STATUS_CANCELED,
                        'keterangan' => 'Pembayaran tidak berhasil: ' . $paymentStatus,
                    ]);
                }

                return ['status' => 200, 'message' => 'Payment status ignored'];
            }

            $profile = UserProfileModel::where('user_id', $payment->user_id)->lockForUpdate()->first();

            if (!$profile) {
                return ['status' => 404, 'message' => 'User profile not found'];
            }

            try {
                $activeUntil = $profile->masa_aktif_membership ? Carbon::parse($profile->masa_aktif_membership) : null;
            } catch (\Throwable $exception) {
                $activeUntil = null;
            }

            $now = Carbon::now();
            $baseDate = $activeUntil && $activeUntil->greaterThan($now) ? $activeUntil : $now;
            $profileData = [
                'status_membership' => DataPayment::STATUS_PAID,
                'masa_aktif_membership' => $baseDate->copy()->addYear()->format('Y-m-d'),
            ];

            if (!$profile->tanggal_bergabung_membership) {
                $profileData['tanggal_bergabung_membership'] = $now->format('Y-m-d');
            }

            $profile->update($profileData);
            $payment->update(['status' => DataPayment::STATUS_PAID]);

            return ['status' => 200, 'message' => 'Membership payment processed'];
        });
    }

    private function processClassPayment(string $invoiceNumber, string $paymentStatus, ?float $amount): array
    {
        return DB::transaction(function () use ($invoiceNumber, $paymentStatus, $amount) {
            $order = ClassPaymentModel::where('no_invoice', $invoiceNumber)->lockForUpdate()->first();

            if (!$order) {
                return ['status' => 404, 'message' => 'Class payment not found'];
            }

            if ($amount !== null && abs((float) $order->price_final - $amount) > 0.01) {
                Log::warning('DOKU class payment amount mismatch', [
                    'invoice' => $invoiceNumber,
                    'expected' => $order->price_final,
                    'received' => $amount,
                ]);

                return ['status' => 422, 'message' => 'Invalid payment amount'];
            }

            $dataPayment = DataPayment::where('no_invoice', $invoiceNumber)->lockForUpdate()->first();

            if ((int) $order->status === 1) {
                if ($dataPayment && (int) $dataPayment->status !== DataPayment::STATUS_PAID) {
                    $dataPayment->update(['status' => DataPayment::STATUS_PAID]);
                }

                return ['status' => 200, 'message' => 'Payment already processed'];
            }

            if (!$this->isSuccessfulDokuStatus($paymentStatus)) {
                return ['status' => 200, 'message' => 'Payment status ignored'];
            }

            $class = ClassesModel::select('id', 'participant_limit')->whereKey($order->class_id)->lockForUpdate()->first();

            if (!$class) {
                return ['status' => 404, 'message' => 'Class not found'];
            }

            $participant = ClassParticipantModel::where('payment_id', $order->id)
                ->where('user_id', $order->user_id)
                ->lockForUpdate()
                ->first();

            if (!$participant) {
                $remainingQuota = ClassParticipantModel::remainingQuotaForClass($order->class_id, (int) $class->participant_limit);

                if ($remainingQuota !== null && (int) $order->jumlah > $remainingQuota) {
                    Log::warning('DOKU class payment rejected because quota is full', [
                        'invoice' => $invoiceNumber,
                        'class_id' => $order->class_id,
                        'requested' => $order->jumlah,
                        'remaining_quota' => $remainingQuota,
                    ]);

                    return ['status' => 409, 'message' => 'Class quota is full'];
                }

                ClassParticipantModel::create([
                    'class_id' => $order->class_id,
                    'user_id' => $order->user_id,
                    'payment_id' => $order->id,
                    'certificate' => (float) $order->biaya_sertifikat > 0 ? 1 : 0,
                    'jumlah' => $order->jumlah,
                ]);
            } else {
                $participant->update([
                    'class_id' => $order->class_id,
                    'certificate' => (float) $order->biaya_sertifikat > 0 ? 1 : (int) $participant->certificate,
                    'jumlah' => $order->jumlah,
                ]);
            }

            $order->update([
                'status' => 1,
            ]);

            if ($dataPayment) {
                $dataPayment->update(['status' => DataPayment::STATUS_PAID]);
            }

            return ['status' => 200, 'message' => 'Class payment processed'];
        });
    }

    private function hasDokuSignatureHeaders(Request $request): bool
    {
        return $request->headers->has('Client-Id')
            || $request->headers->has('Request-Id')
            || $request->headers->has('Request-Timestamp')
            || $request->headers->has('Signature');
    }

    private function isValidDokuSignature(Request $request): bool
    {
        $clientId = env('DOKU_CLIENT_ID');
        $secretKey = env('DOKU_SECRET_KEY');
        $headerClientId = $request->header('Client-Id');
        $requestId = $request->header('Request-Id');
        $timestamp = $request->header('Request-Timestamp');
        $signature = $request->header('Signature');

        if (!$clientId || !$secretKey || !$headerClientId || !$requestId || !$timestamp || !$signature) {
            return false;
        }

        if (!hash_equals((string) $clientId, (string) $headerClientId)) {
            return false;
        }

        $requestTarget = parse_url($request->getRequestUri(), PHP_URL_PATH) ?: '/api/doku/membership/notification';
        $digest = base64_encode(hash('sha256', $request->getContent(), true));
        $rawSignature = 'Client-Id:' . $headerClientId . "\n" .
            'Request-Id:' . $requestId . "\n" .
            'Request-Timestamp:' . $timestamp . "\n" .
            'Request-Target:' . $requestTarget . "\n" .
            'Digest:' . $digest;

        $expectedSignature = 'HMACSHA256=' . base64_encode(hash_hmac('sha256', $rawSignature, $secretKey, true));

        return hash_equals($expectedSignature, (string) $signature);
    }

    private function getDokuOrderStatus(string $invoiceNumber): ?array
    {
        $clientId = env('DOKU_CLIENT_ID');
        $secretKey = env('DOKU_SECRET_KEY');
        $dokuUrl = rtrim((string) env('DOKU_URL'), '/');

        if (!$clientId || !$secretKey || !$dokuUrl) {
            return null;
        }

        $requestId = Str::uuid()->toString();
        $timestamp = now()->toIso8601ZuluString();
        $requestTarget = '/orders/v1/status/' . rawurlencode($invoiceNumber);
        $rawSignature = 'Client-Id:' . $clientId . "\n" .
            'Request-Id:' . $requestId . "\n" .
            'Request-Timestamp:' . $timestamp . "\n" .
            'Request-Target:' . $requestTarget;
        $signature = 'HMACSHA256=' . base64_encode(hash_hmac('sha256', $rawSignature, $secretKey, true));

        try {
            $response = Http::timeout(15)->withHeaders([
                'Client-Id' => $clientId,
                'Request-Id' => $requestId,
                'Request-Timestamp' => $timestamp,
                'Signature' => $signature,
                'Content-Type' => 'application/json',
            ])->get($dokuUrl . $requestTarget);
        } catch (\Throwable $exception) {
            Log::error('Gagal check status DOKU', [
                'invoice' => $invoiceNumber,
                'error' => $exception->getMessage(),
            ]);

            return null;
        }

        if (!$response->successful()) {
            Log::warning('Check status DOKU gagal', [
                'invoice' => $invoiceNumber,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        }

        $data = $response->json();

        return is_array($data) ? $data : null;
    }

    private function extractDokuInvoiceNumber(Request $request): ?string
    {
        return $this->extractDokuInvoiceNumberFromData($request->all());
    }

    private function extractDokuInvoiceNumberFromData(array $data): ?string
    {
        return data_get($data, 'invoice_number')
            ?? data_get($data, 'order.invoice_number')
            ?? data_get($data, 'order.invoiceNumber');
    }

    private function extractDokuPaymentStatus(Request $request): ?string
    {
        return $this->extractDokuPaymentStatusFromData($request->all());
    }

    private function extractDokuPaymentStatusFromData(array $data): ?string
    {
        $status = data_get($data, 'transaction.status')
            ?? data_get($data, 'transaction_status')
            ?? data_get($data, 'payment.status')
            ?? data_get($data, 'status');

        return $status ? strtoupper((string) $status) : null;
    }

    private function extractDokuAmount(Request $request): ?float
    {
        return $this->extractDokuAmountFromData($request->all());
    }

    private function extractDokuAmountFromData(array $data): ?float
    {
        $amount = data_get($data, 'order.amount') ?? data_get($data, 'amount');

        return is_numeric($amount) ? (float) $amount : null;
    }

    private function isSuccessfulDokuStatus(string $status): bool
    {
        return in_array($status, ['SUCCESS', 'PAID', 'SETTLEMENT', 'CAPTURE', 'COMPLETED'], true);
    }

    private function isFailedDokuStatus(string $status): bool
    {
        return in_array($status, ['FAILED', 'CANCEL', 'CANCELED', 'CANCELLED', 'EXPIRED', 'DENIED'], true);
    }
    // public function uploadProof(Request $request)
    // {
    //     $request->validate([
    //         'uniqe_id' => 'required|integer',
    //         'proof'    => 'required|file|mimes:jpeg,png,jpg,pdf|max:5048', // max ~5MB
    //     ]);

    //     $file = $request->file('proof');
    //     $base64 = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file));

    //     Order::where('uniqe_id', $request->uniqe_id)->update([
    //         'bukti_pembayaran' => $base64,
    //         'payment_status'   => 'waiting_confirmation',
    //         'paid_at' => now()
    //     ]);
    //     $apiUrl = env('MAIN_API_BASE_URL');
    //     try {
    //         $response = Http::timeout(15)->post("{$apiUrl}/api/v1/sync-proof", [
    //             'unique_id'         => $request->uniqe_id,
    //             'bukti_pembayaran' => $base64,
    //             'payment_status'   => 'waiting_confirmation',
    //         ]);

    //         if ($response->failed()) {
    //             Log::warning('Gagal sync bukti pembayaran ke root system', [
    //                 'unique_id' => $request->uniqe_id,
    //                 'response' => $response->body(),
    //                 'status'   => $response->status(),
    //             ]);
    //         }
    //         $token = env('FONNTE_API_TOKEN');
    //         $baseUrl = env('FONNTE_BASE_URL');
    //         $targetUser = preg_replace('/^0/', '62', 2476435498);
    //         $userMsg = "✅ *Konfirmasi Pengajuan*\n" .
    //             "--------------------------\n" .
    //             "Halo * Admin Cutiin *,\n" .
    //             "Ada Pembayaran Layanan Baru  Silahkan melakukan verifikasi.\n\n" .
    //             "Terima kasih.\n" .
    //             "--------------------------\n" .
    //             "© " . date('Y') . " cutiin.com";

    //         Http::withHeaders(['Authorization' => $token])->post($baseUrl, [
    //             'target'  => $targetUser,
    //             'message' => $userMsg,
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::error('Exception saat sync bukti pembayaran', [
    //             'unique_id' => $request->uniqe_id,
    //             'error'    => $e->getMessage()
    //         ]);
    //     }

    //     return back()->with('success', 'Bukti pembayaran berhasil diupload! Kami akan segera memverifikasi.');
    // }
    public function handleNotification(Request $request)
    {
        $invoiceNumber = $this->extractDokuInvoiceNumber($request);

        Log::info('NOTIFIKASI MASUK DI DOMAIN B', ['invoice' => $invoiceNumber]);

        if (!$invoiceNumber) {
            return response()->json(['message' => 'Invalid data'], 400);
        }

        $notification = $this->resolveDokuNotificationData($request, $invoiceNumber);

        if (!$notification) {
            return response()->json(['message' => 'Unable to verify payment status'], 500);
        }

        if (!$notification['payment_status']) {
            return response()->json(['message' => 'Invalid webhook payload'], 400);
        }

        $result = $this->processClassPayment(
            $invoiceNumber,
            $notification['payment_status'],
            $notification['amount']
        );

        return response()->json(['message' => $result['message']], $result['status']);
    }
}
