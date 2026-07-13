<?php

namespace App\Support;

use App\Models\User;
use App\Providers\RouteServiceProvider;

class AuthRedirector
{
	public static function pathFor(?User $user): string
	{
		if (!$user) {
			return '/';
		}

		if ($user->email === 'cb@bankir.academy') {
			return RouteServiceProvider::HOME;
		}

		return (int) $user->role === 2 ? '/' : RouteServiceProvider::HOME;
	}
}
