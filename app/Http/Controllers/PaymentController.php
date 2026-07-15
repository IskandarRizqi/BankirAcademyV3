<?php

namespace App\Http\Controllers;

use App\Models\DataPayment;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function paymentmembership(Request $request)
    {
        // return $request->all();
        $nomorinvoice = 'BANKIR-' . date('YmdHis');
        $totalbayar = $request->nominal * $request->qty;
        $datapayment = DataPayment::create([
            'no_invoice' => $nomorinvoice,
            'user_id' => $request->user_id,
            'pembelian' => $request->pembelian,
            'nominal' => $totalbayar,
            'qty' => $request->qty,
            'status' => $request->status_membership,
            'keterangan' => $request->keterangan,
        ]);

        $userprofile = UserProfileModel::where('user_id', $request->user_id)->update([
            'status_membership' => $request->status_membership
        ]);

        $clientId = env('DOKU_CLIENT_ID');
        $secretKey = env('DOKU_SECRET_KEY');
        $timestamp = now()->toIso8601ZuluString(); // Contoh: 2023-01-01T10:00:00Z
        $requestId = Str::uuid()->toString(); // Generate UUID untuk request_id

        $body = [
            'order' => [
                'amount' => $totalbayar,
                'invoice_number' => $nomorinvoice,
                'callback_url' => url('/dash-beranda'),
                'line_items' => [
                    [
                        'name' => $request->pembelian,
                        'price' => $totalbayar,
                        'quantity' => $request->qty,
                    ],
                ],
            ],
            'customer' => [
                'name' => Auth::user()->name,
                // "email" => Auth::user()->email,
            ],
            'payment' => [
                'payment_due_date' => 60, // menit
            ],
            'additional_info' => [
                'user_id' => Auth::user()->id,
                'pembelian_tipe' => $request->pembelian_tipe  // 1 ADALAH MEMBERSHIP
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

        // Eksekusi API SNAP
        $response = Http::withHeaders([
            'Client-Id' => $clientId,
            'Request-Id' => $requestId,
            'Request-Timestamp' => $timestamp,
            'Signature' => 'HMACSHA256=' . $signature,
            'Content-Type' => 'application/json',
        ])->post(env('DOKU_URL') . '/checkout/v1/payment', $body);

        if ($response->successful()) {
            $resData = $response->json();

            // DOKU SNAP biasanya mengembalikan URL di path ini:
            $paymentUrl = $resData['response']['payment']['url'] ?? null;

            if ($paymentUrl) {
                $datapayment->update(['link_payment' => $paymentUrl]);
                // return Redirect();
                return redirect($paymentUrl);
            }
        }
    }
}
