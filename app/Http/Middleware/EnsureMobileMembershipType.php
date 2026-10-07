<?php

namespace App\Http\Middleware;

use App\Models\UserProfileModel;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMobileMembershipType
{
    public function handle(Request $request, Closure $next, string $type): Response
    {
        if ($type === 'individual' && (int) $request->user()?->role === 6) {
            return $next($request);
        }

        $expected = $type === 'company' ? 1 : 2;
        $profile = UserProfileModel::query()
            ->where('user_id', $request->user()?->id)
            ->first();

        if (! $profile || (int) $profile->tipe_membership !== $expected) {
            return response()->json([
                'success' => false,
                'code' => 'membership_type_forbidden',
                'message' => 'Fitur ini tidak tersedia untuk tipe membership akun Anda.',
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
