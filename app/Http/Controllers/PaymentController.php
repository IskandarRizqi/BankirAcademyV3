<?php

namespace App\Http\Controllers;

use App\Models\DataPayment;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
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
                'callback_url' => url('/dash-beranda'),
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
}
