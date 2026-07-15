<?php

namespace App\Http\Controllers;

use App\Models\BiayaSertifikatModel;
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
    public function store(Request $request)
    {
        $auth = Auth::user()->id;
        $number = ClassPaymentModel::select('unique_code')->where('expired', '<', now())->pluck('unique_code')->toArray();
        do {
            $randomNumber = rand(0, 999);
        } while (in_array($randomNumber, $number));

        $numbers = ClassPaymentModel::select('no_invoice')->pluck('no_invoice')->toArray();
        do {
            $no_invoice = "BANKIR-" . uniqid();
        } while (in_array($no_invoice, $numbers));

        $price = 0;
        $price_final = 0;
        $cp = ClassPricingModel::where('class_id', $request->class_id)->first();
        $jmlpeserta = 1;
        if ($request->jml_peserta != null || $request->jml_peserta > 1) {
            $jmlpeserta = $request->jml_peserta;
        }


        if ($cp) {
            $price = $cp->price;
            $price_final = $price * $jmlpeserta;
            if ($cp->promo == 1) {
                $price = $cp->price - $cp->promo_price;
                $price_final = $price * $jmlpeserta;
            }
        }
        $data['payment']['sertifikat'] = 0;
        if ($request->sertifikat_invoice > 0) {
            $s = BiayaSertifikatModel::where('class_id', $request->class_id)->first();
            if ($s) {
                $data['payment']['sertifikat'] = $s->nominal;
                if ($s->type > 0) {
                    $data['payment']['sertifikat'] = ($price_final * ($s->nominal / 100));
                }
            } else {
                $data['payment']['sertifikat'] = 100000;
            }
        }
        if ($cp->gratis == 1) {
            $price_final = 0;
        }
        // return $data['payment']['sertifikat'];
        if ($cp->gratis == 1 && $data['payment']['sertifikat'] === 0) {
            $order = ClassPaymentModel::create([
                'status' => 1,
                'user_id' => $auth,
                'class_id' => $request->class_id,
                'unique_code' => $randomNumber,
                'price' => $price,
                'biaya_sertifikat' => $data['payment']['sertifikat'] * $jmlpeserta,
                'price_final' => $price_final + $data['payment']['sertifikat'],
                'expired' => date('Y-m-d') . ' 23:59:59',
                'no_invoice' => $no_invoice,
            ]);
            $order->refresh();
            SertifikatPesertaModel::create([
                'user_id' => Auth::user()->id,
                'class_id' => $request->class_id,
                'payment_class_id' => $order->id,
                'nama' => json_encode($request->nama),
                'email' => json_encode($request->email),
                'nohp' => json_encode($request->nomor_handphone)
            ]);
            return redirect('profile')->with('success_payment', 'Pendaftaran kelas berhasil! Kelas Anda telah aktif.');
        } else {
            $order = ClassPaymentModel::create([
                'status' => 0,
                'user_id' => $auth,
                'class_id' => $request->class_id,
                'unique_code' => $randomNumber,
                'price' => $price,
                'biaya_sertifikat' => $data['payment']['sertifikat'] * $jmlpeserta,
                'price_final' => $price_final + ($data['payment']['sertifikat'] * $jmlpeserta),
                'expired' => date('Y-m-d') . ' 23:59:59',
                'no_invoice' => $no_invoice,
            ]);
            $order->refresh();
            SertifikatPesertaModel::create([
                'user_id' => Auth::user()->id,
                'class_id' => $request->class_id,
                'payment_class_id' => $order->id,
                'nama' => json_encode($request->nama),
                'email' => json_encode($request->email),
                'nohp' => json_encode($request->nomor_handphone)
            ]);

            $order->refresh();
            $clientId = env('DOKU_CLIENT_ID');
            $secretKey = env('DOKU_SECRET_KEY');
            $timestamp = now()->toIso8601ZuluString();
            $requestId = (string) Str::uuid();
            $body = [
                "order" => [
                    "amount" => $price_final + ($data['payment']['sertifikat'] * $jmlpeserta),
                    "invoice_number" => $no_invoice,
                    "callback_url" => url('/profile'),
                    "line_items" => [
                        [
                            "name" => "Pembayaran Kelas ",
                            "price" => $price_final + ($data['payment']['sertifikat'] * $jmlpeserta),
                            "quantity" => 1
                        ]
                    ]
                ],
                "customer" => [
                    "name" => Auth::user()->name,
                    "email" => Auth::user()->email,
                ],
                "payment" => [
                    "payment_due_date" => 60
                ],
                "additional_info" => [
                    "user_id" => $auth,
                    "pembelian_tipe" => 2,
                    "override_notification_url" => env('DOKU_NOTIFICATION_URL', url('/api/c4/notifikasi')),
                ]
            ];
            $jsonBody = json_encode($body);
            $digest = base64_encode(hash('sha256', $jsonBody, true));
            $rawSignature = "Client-Id:" . $clientId . "\n" .
                "Request-Id:" . $requestId . "\n" .
                "Request-Timestamp:" . $timestamp . "\n" .
                "Request-Target:/checkout/v1/payment\n" .
                "Digest:" . $digest;

            $signature = base64_encode(hash_hmac('sha256', $rawSignature, $secretKey, true));

            $response = Http::withHeaders([
                'Client-Id' => $clientId,
                'Request-Id' => $requestId,
                'Request-Timestamp' => $timestamp,
                'Signature' => "HMACSHA256=" . $signature,
                'Content-Type' => 'application/json',
            ])->post(env('DOKU_URL') . '/checkout/v1/payment', $body);

            if ($response->successful()) {
                $resData = $response->json();
                $paymentUrl = $resData['response']['payment']['url'] ?? null;

                if ($paymentUrl) {
                    $order->update(['file' => $paymentUrl]);
                    return redirect()->away($paymentUrl);
                }
            }

            return response()->json([
                'rc' => '05',
                'msg' => 'Gagal menghubungi server pembayaran',
                'error' => $response->body()
            ], 500);
        }
    }

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

        $purchaseType = data_get($request->all(), 'additional_info.pembelian_tipe')
            ?? data_get($notification['data'], 'additional_info.pembelian_tipe');

        if ((int) $purchaseType === 1 || DataPayment::where('no_invoice', $invoiceNumber)->exists()) {
            $result = $this->processMembershipPayment(
                $invoiceNumber,
                $notification['payment_status'],
                $notification['amount']
            );
        } else {
            $result = $this->processClassPayment(
                $invoiceNumber,
                $notification['payment_status'],
                $notification['amount']
            );
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

            if (strtolower((string) $payment->pembelian) !== DataPayment::PURCHASE_MEMBERSHIP) {
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

            if ((int) $order->status === 1) {
                return ['status' => 200, 'message' => 'Payment already processed'];
            }

            if (!$this->isSuccessfulDokuStatus($paymentStatus)) {
                return ['status' => 200, 'message' => 'Payment status ignored'];
            }

            $order->update([
                'status' => 1,
            ]);

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
