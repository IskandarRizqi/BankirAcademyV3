<?php

namespace App\Jobs;

use App\Mail\UserActivationMail;
use App\Models\User;
use App\Models\UserActivation;
use App\Services\ContactFieldResolver;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Throwable;

class SendUserActivationEmail implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public function __construct(
        public readonly string $activationId,
        public readonly int $userId,
        public readonly string $scope = 'default',
    ) {
        $this->onQueue('activation-mails');
    }

    public function backoff(): array
    {
        return [60, 300, 900];
    }

    public function handle(ContactFieldResolver $resolver): void
    {
        if ($this->batch()?->cancelled()) {
            return;
        }

        $activation = User::find($this->userId);

        // Apabila email_sent_at terisi maka return
        // if ($activation?->email_sent_at !== null) {
        //     return;
        // }
        $user = User::select(
            'users.*',
            'user_profile.phone_region',
            'user_profile.phone',
        )
            ->leftJoin('user_profile', 'user_profile.user_id', 'users.id')
            ->where('users.id', $this->userId)
            ->first();

        $expires_at = now()->addMinutes(config('activation.expiration_minutes', 60));
        if (! $activation) {
            $contact = $resolver->resolve($user, $this->scope);

            $activation = User::where('id', $this->userId)->update([
                'user_id' => $user->getKey(),
                'email_destination' => $contact['email'],
                'whatsapp_destination' => $contact['whatsapp'],
                'expires_at' => $expires_at,
            ]);
        }

        $activationUrl = URL::temporarySignedRoute(
            name: 'activation.show',
            expiration: $expires_at,
            parameters: [
                'activation' => $activation->getKey(),
            ],
        );

        Mail::to($activation->email)->send(
            new UserActivationMail(
                userName: $user->name ?? 'Pengguna',
                activationUrl: $activationUrl,
                expiredAt: $expires_at,
            ),
        );

        $activation->forceFill([
            'email_sent_at' => now(),
            'expires_at' => $expires_at,
            'last_error' => null,
        ])->save();
    }

    public function failed(Throwable $exception): void
    {
        User::query()
            ->whereId($this->userId)
            ->update([
                'last_error' => Str::limit(
                    $exception->getMessage(),
                    1000
                ),
            ]);
    }
}
