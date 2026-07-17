<?php

namespace App\Http\Controllers;

use App\Jobs\SendPasswordViaWhatsApp;
use App\Models\User;
use App\Models\UserActivation;
use App\Services\FonnteService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ActivationController extends Controller
{
    public function show(User $activation): View
    {
        $isExpired = false;
        if ($activation->expires_at->isPast()) {
            $isExpired = true;
        };

        $consumeUrl = URL::temporarySignedRoute(
            name: 'activation.consume',
            expiration: $activation->expires_at,
            parameters: [
                'activation' => $activation->getKey(),
            ],
        );

        return view('activation.show', [
            'activation' => $activation,
            'consumeUrl' => $consumeUrl,
            'isExpired' => $isExpired,
        ]);
    }

    public function consume(User $activation): RedirectResponse
    {
        $mustDispatchWhatsApp = DB::transaction(
            function () use ($activation): bool {
                Log::info("consume", [$activation, $activation->getKey()]);
                $lockedActivation = User::findOrFail($activation->getKey());

                abort_if(
                    $lockedActivation->expires_at->isPast(),
                    410,
                    'Link aktivasi sudah kedaluwarsa.'
                );

                if ($lockedActivation->password_sent_at !== null) {
                    return false;
                }

                if ($lockedActivation->activated_at === null) {
                    $plainPassword = Str::random(8);

                    $lockedActivation->forceFill([
                        'password' => Hash::make($plainPassword),
                        // 'email_verified_at' => now(),
                        // 'is_active' => 1,
                        // 'activated_at' => now(),
                        'password_ciphertext' =>
                        Crypt::encryptString($plainPassword),
                    ])->save();
                }

                return true;
            }
        );

        if ($mustDispatchWhatsApp) {
            SendPasswordViaWhatsApp::dispatch(
                $activation->getKey()
            );
            Log::info("consume", [$activation, $activation->getKey()]);
        }

        return redirect()
            ->route('login')
            ->with(
                'status',
                'Email berhasil dikonfirmasi. Password sedang dikirim melalui WhatsApp.'
            );
    }
}
