<?php

namespace App\Support;

use App\Models\User;
use App\Providers\RouteServiceProvider;

class AuthRedirector
{
    public static function safePath(?string $path): ?string
    {
        if (! is_string($path) || $path === '' || $path[0] !== '/' || str_starts_with($path, '//')) {
            return null;
        }

        return $path;
    }

    public static function pathFor(?User $user): string
    {
        // \Log::info($user);
        if (! $user) {
            return '/';
        }

        if (AdminPanel::canAccess($user)) {
            return RouteServiceProvider::HOME;
        }

        return (int) $user->role === 2 ? '/dash-beranda' : RouteServiceProvider::HOME;
    }
}
