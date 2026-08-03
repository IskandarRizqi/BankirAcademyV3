<?php

namespace App\Http\Middleware;

use App\Models\DataPayment;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMembershipType
{
    public function handle(Request $request, Closure $next, string $type): Response
    {
        $membershipType = match (strtolower($type)) {
            'individual' => DataPayment::MEMBERSHIP_TYPE_INDIVIDUAL,
            'company' => DataPayment::MEMBERSHIP_TYPE_COMPANY,
            default => null,
        };

        abort_unless($membershipType !== null, 500, 'Tipe membership route tidak valid.');

        if ((int) data_get($request->user()->profile, 'tipe_membership') === $membershipType) {
            return $next($request);
        }

        if ((int) $request->user()->role === 2) {
            return redirect()->route('dash-beranda.index');
        }

        abort(403);
    }
}
