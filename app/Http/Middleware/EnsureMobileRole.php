<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMobileRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user() || ! in_array((string) $request->user()->role, $roles, true)) {
            return response()->json([
                'success' => false,
                'code' => 'mobile_role_forbidden',
                'message' => 'Role akun tidak memiliki akses ke fitur ini.',
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
