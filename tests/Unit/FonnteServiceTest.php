<?php

namespace Tests\Unit;

use App\Services\FonnteService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FonnteServiceTest extends TestCase
{
    public function test_message_is_sent_as_json_to_connecthub(): void
    {
        config([
            'services.fonnte.url' => 'https://connecthub.ehr.co.id/api/v1/messages',
            'services.fonnte.token' => 'Bearer test-token',
        ]);

        Http::fake([
            'https://connecthub.ehr.co.id/api/v1/messages' => Http::response([
                'status' => true,
            ], 200),
        ]);

        app(FonnteService::class)->sendMessage('628123456789', 'Kode OTP: 123456');

        Http::assertSent(function (Request $request): bool {
            return $request->url() === 'https://connecthub.ehr.co.id/api/v1/messages'
                && $request->header('Authorization') === ['Bearer test-token']
                && $request->header('Content-Type') === ['application/json']
                && $request->data()['to'] === '628123456789'
                && $request->data()['body'] === 'Kode OTP: 123456'
                && isset($request->data()['external_id']);
        });
    }
}
