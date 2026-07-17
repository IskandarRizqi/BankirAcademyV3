<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class FonnteService
{
    public function sendMessage(
        string $target,
        string $message
    ): Response {
        return Http::asForm()
            ->withHeaders([
                'Authorization' => config('services.fonnte.token'),
            ])
            ->timeout(30)
            ->retry(3, 1000)
            ->post(
                config('services.fonnte.url') . '/send',
                [
                    'target' => $target,
                    'message' => $message,
                    'countryCode' => '62',
                ]
            );
    }
}
