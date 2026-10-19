<?php

namespace App\Services;

use App\Models\ClassPaymentModel;
use App\Models\DataPayment;
use App\Models\UserProfileModel;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FonnteService
{
    public function sendMessage(
        string $target,
        string $message
    ): Response {
        $url = rtrim((string) config('services.fonnte.url'), '/');

        return Http::asJson()
            ->withHeaders([
                'Authorization' => config('services.fonnte.token'),
            ])
            ->timeout(30)
            ->retry(3, 1000)
            ->post(
                $url,
                [
                    'to' => $target,
                    'body' => $message,
                    'external_id' => (string) Str::uuid(),
                ]
            );
    }

    public function sendPaidClassInvoice(int $paymentId): void
    {
        $payment = DataPayment::with(['user.userProfile', 'paymentClass'])
            ->find($paymentId);

        if (
            ! $payment
            || ! $payment->class_id
            || (int) $payment->status !== DataPayment::STATUS_PAID
        ) {
            return;
        }

        $phone = $payment->user?->userProfile?->phone ?: $payment->customer_phone;

        if (filled($phone)) {
            $phone = UserProfileModel::normalizePhone($phone);
        }

        if (! filled($phone)) {
            Log::warning('Invoice lunas tidak dikirim karena nomor WhatsApp kosong', [
                'payment_id' => $payment->id,
                'invoice' => $payment->no_invoice,
            ]);

            return;
        }

        $classPayment = ClassPaymentModel::where('no_invoice', $payment->no_invoice)->first();
        $classTitle = $payment->paymentClass?->title ?: 'Kelas Bankir Academy';
        $amount = number_format((float) $payment->nominal, 0, ',', '.');
        $message = implode("\n", [
            'Halo '.($payment->user?->name ?: $payment->customer_name ?: 'Peserta').',',
            '',
            'Pembayaran kelas Anda telah LUNAS.',
            "Kelas: {$classTitle}",
            "No. invoice: {$payment->no_invoice}",
            "Nominal: Rp {$amount}",
            'Jumlah peserta: '.max(1, (int) ($classPayment?->jumlah ?: $payment->qty)),
            '',
            'Simpan pesan ini sebagai bukti pembayaran Anda.',
            'Terima kasih telah memilih Bankir Academy.',
        ]);

        try {
            $response = $this->sendMessage(
                $phone,
                $message,
            );

            if (! $response->successful() || data_get($response->json(), 'status') === false) {
                Log::error('Fonnte gagal mengirim invoice lunas', [
                    'payment_id' => $payment->id,
                    'invoice' => $payment->no_invoice,
                    'response' => $response->body(),
                ]);
            }
        } catch (\Throwable $exception) {
            Log::error('Pengiriman invoice lunas WhatsApp gagal', [
                'payment_id' => $payment->id,
                'invoice' => $payment->no_invoice,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
