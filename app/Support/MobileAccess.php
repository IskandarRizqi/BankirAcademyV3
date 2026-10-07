<?php

namespace App\Support;

use App\Models\User;

final class MobileAccess
{
    private const WEBSITE_ONLY_EMAIL = 'cb@bankir.academy';

    public static function isBlocked(?User $user): bool
    {
        return $user !== null
            && ((int) $user->role === 0 || self::isBlockedEmail((string) $user->email));
    }

    public static function isBlockedEmail(string $email): bool
    {
        return strtolower(trim($email)) === self::WEBSITE_ONLY_EMAIL;
    }
}
