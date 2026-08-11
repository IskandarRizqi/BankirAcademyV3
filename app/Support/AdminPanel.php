<?php

namespace App\Support;

use App\Models\User;

final class AdminPanel
{
    public static function isLegacyRoot(?User $user): bool
    {
        return $user !== null && (int) $user->role === 0;
    }

    public static function isCbRoot(?User $user): bool
    {
        return $user !== null
            && (int) $user->role === 4 || (int) $user->role === 0
            && $user->email === 'cb@bankir.academy';
    }

    public static function canAccess(?User $user): bool
    {
        return self::isLegacyRoot($user) || self::isCbRoot($user);
    }
}
