<?php

namespace App\Http\Middleware;

use App\Support\MobileAccess;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMobileAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (MobileAccess::isBlocked($request->user())) {
            return response()->json([
                'success' => false,
                'code' => 'website_only_account',
                'message' => 'Akun ini hanya dapat digunakan melalui website.',
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
