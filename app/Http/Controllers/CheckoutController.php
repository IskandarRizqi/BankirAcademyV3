<?php

namespace App\Http\Controllers;

use App\Models\ClassPaymentModel;
use App\Models\ClassPricingModel;
use App\Models\CorporateRegistration;
use App\Models\DepositUsed;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;


class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $auth = Auth::user()->id;

        // Logika pembuatan nomor invoice & unik (Tetap sama)
        $number = ClassPaymentModel::select('unique_code')->where('expired', '<', now())->pluck('unique_code')->toArray();
        do {
            $randomNumber = rand(0, 999);
        } while (in_array($randomNumber, $number));

        $numbers = ClassPaymentModel::select('no_invoice')->pluck('no_invoice')->toArray();
        do {
            $no_invoice = uniqid();
        } while (in_array($no_invoice, $numbers));

        $price = 0;
        $price_final = 0;
        $cp = ClassPricingModel::where('class_id', $request->class_id)->first();
        if ($cp) {
            $price = $cp->price;
            $price_final = $price + $randomNumber;
            if ($cp->promo == 1) {
                $price = $cp->price - $cp->promo_price;
                $price_final = $price + $randomNumber;
            }
        }

        $order = ClassPaymentModel::create([
            'status' => 0,
            'user_id' => $auth,
            'class_id' => $request->class_id,
            'unique_code' => $randomNumber,
            'price' => $price,
            'price_final' => $price_final,
            'expired' => date('Y-m-d') . ' 23:59:59',
            'no_invoice' => $no_invoice,
        ]);

        $order->refresh();

        // --- MULAI KONFIGURASI DOKU SNAP ---
        $clientId = env('DOKU_CLIENT_ID');
        $secretKey = env('DOKU_SECRET_KEY');
        $timestamp = now()->toIso8601ZuluString(); // Contoh: 2023-01-01T10:00:00Z
        $requestId = (string) Str::uuid();

        // Struktur Body DOKU SNAP
        $body = [
            "order" => [
                "amount" => $price_final,
                "invoice_number" => $no_invoice,
                "callback_url" => url('/profile'),
                "line_items" => [
                    [
                        "name" => "Pembayaran Kelas " . $request->class_id,
                        "price" => $price_final,
                        "quantity" => 1
                    ]
                ]
            ],
            "customer" => [
                "name" => Auth::user()->name,
                "email" => Auth::user()->email,
            ],
            "payment" => [
                "payment_due_date" => 60 // menit
            ]
        ];

        // Pembuatan Signature SNAP (Standar ASPI)
        $jsonBody = json_encode($body);
        $digest = base64_encode(hash('sha256', $jsonBody, true));

        // Perhatikan Request-Target untuk SNAP biasanya diawali /checkout/v1/payment atau sesuai dokumentasi SNAP DOKU terbaru
        $rawSignature = "Client-Id:" . $clientId . "\n" .
            "Request-Id:" . $requestId . "\n" .
            "Request-Timestamp:" . $timestamp . "\n" .
            "Request-Target:/checkout/v1/payment\n" .
            "Digest:" . $digest;

        $signature = base64_encode(hash_hmac('sha256', $rawSignature, $secretKey, true));

        // Eksekusi API SNAP
        $response = Http::withHeaders([
            'Client-Id' => $clientId,
            'Request-Id' => $requestId,
            'Request-Timestamp' => $timestamp,
            'Signature' => "HMACSHA256=" . $signature,
            'Content-Type' => 'application/json',
        ])->post(env('DOKU_URL') . '/checkout/v1/payment', $body);

        if ($response->successful()) {
            $resData = $response->json();

            // DOKU SNAP biasanya mengembalikan URL di path ini:
            $paymentUrl = $resData['response']['payment']['url'] ?? null;

            if ($paymentUrl) {
                $order->update(['file' => $paymentUrl]);
                return response()->json(['url' => $paymentUrl, 'rc' => '00']);
            }
        }

        return response()->json([
            'rc' => '05',
            'msg' => 'Gagal menghubungi server pembayaran',
            'error' => $response->body()
        ], 500);
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
        // 1. Ambil data dari DOKU
        $invoiceNumber = $request->input('invoice_number');

        // Log yang aman (menggunakan array sebagai argumen kedua)
        Log::info('NOTIFIKASI MASUK DI DOMAIN B', ['invoice' => $invoiceNumber]);

        if (!$invoiceNumber) {
            return response()->json(['message' => 'Invalid data'], 400);
        }

        $order = ClassPaymentModel::where('no_invoice', $invoiceNumber)->first();

        if ($order) {
            $order->update([
                'status' => 1,
                'is_active' => true,
            ]);
        }

        return response()->json(['message' => 'Notification Received'], 200);
    }
}
