<?php

namespace App\Services;

use App\Models\ContactMapping;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ContactFieldResolver
{
    /**
     * @return array{email: string, whatsapp: string}
     */
    public function resolve(User $user, string $scope = 'default'): array
    {
        // $mapping = ContactMapping::query()
        //     ->where('scope', $scope)
        //     ->firstOrFail();
        $emailkey = 'email';
        $wakey = 'phone';

        $allowedEmailKeys = config('activation.allowed_email_keys', []);
        $allowedWhatsappKeys = config('activation.allowed_whatsapp_keys', []);

        if (! in_array($emailkey, $allowedEmailKeys, true)) {
            throw ValidationException::withMessages([
                'email_key' => 'Mapping kolom email tidak diizinkan.',
            ]);
        }

        if (! in_array($wakey, $allowedWhatsappKeys, true)) {
            throw ValidationException::withMessages([
                'whatsapp_key' => 'Mapping kolom WhatsApp tidak diizinkan.',
            ]);
        }

        $wa = null;

        if ($user->profile) {
            $wa = str_replace('+', '', $user->profile->phone_region) . $user->profile->phone;
        }

        $email = trim((string) $user->email);

        Validator::make(
            [
                'email' => $email,
                'whatsapp' => $wa,
            ],
            [
                'email' => ['required', 'email'],
                'whatsapp' => [
                    'required',
                    'regex:/^\+?[1-9][0-9]{7,14}$/',
                ],
            ],
        )->validate();

        return [
            'email' => $email,
            'whatsapp' => $wa,
        ];
    }
}
