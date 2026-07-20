<?php

namespace App\Jobs;

use App\Contracts\WhatsAppGateway;
use App\Models\User;
use App\Models\UserActivation;
use App\Services\FonnteService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class SendPasswordViaWhatsApp implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 5;

    public int $uniqueFor = 3600;

    public function __construct(
        public readonly string $activationId,
    ) {
        $this->onQueue('whatsapp');
    }

    public function uniqueId(): string
    {
        return $this->activationId;
    }

    public function backoff(): array
    {
        return [60, 180, 600, 1800];
    }

    public function middleware(): array
    {
        return [
            (new WithoutOverlapping(
                "activation-whatsapp:{$this->activationId}"
            ))->expireAfter(180),
        ];
    }

    public function handle(FonnteService $ft): void
    {
        $activation = User::with('siswa')->findOrFail($this->activationId);
        Log::info('sendwa', [$activation]);

        // if ($activation->password_sent_at !== null) {
        //     return;
        // }

        if (! $activation->password_ciphertext) {
            return;
        }

        $plainPassword = Crypt::decryptString(
            $activation->password_ciphertext
        );

        $message = implode("\n", [
            "Halo {$activation->name},",
            '',
            'Email Anda berhasil dikonfirmasi.',
            "Password: {$plainPassword}",
            '',
            'Silakan login dan segera ganti password Anda.',
            'Jangan memberikan password ini kepada siapa pun.',
        ]);

        $providerMessageId = $ft->sendMessage(
            $activation->siswa?->no_telp,
            $message,
        );

        Log::info('sendwa providermessageid', [$providerMessageId]);

        $activation->forceFill([
            // 'provider_message_id' => $providerMessageId,
            // 'password_sent_at' => now(),

            // Password mentah tidak diperlukan lagi.
            'password_ciphertext' => null,

            'last_error' => null,
        ])->save();
    }

    public function failed(Throwable $exception): void
    {
        User::whereId($this->activationId)
            ->update([
                'last_error' => Str::limit(
                    $exception->getMessage(),
                    1000
                ),
            ]);
    }
}
