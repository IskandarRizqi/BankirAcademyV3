<?php

namespace App\Http\Controllers\MemberNonAnggota;

use App\Http\Controllers\Controller;
use App\Http\Requests\MembershipProfileRequest;
use App\Models\UserProfileModel;
use Illuminate\Http\RedirectResponse;

class MembershipProfileController extends Controller
{
    public function edit(): RedirectResponse
    {
        return redirect()
            ->route('dash-beranda.index')
            ->with('open_membership_profile', true);
    }

    public function update(MembershipProfileRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $membershipType = isset($validated['membership_tipe']) && $validated['membership_tipe'] !== null
            ? (int) $validated['membership_tipe']
            : null;
        unset($validated['membership_tipe']);
        $validated['description'] = $validated['alamat'];

        UserProfileModel::updateOrCreate(
            ['user_id' => $request->user()->id],
            $validated + ['user_id' => $request->user()->id]
        );

        $redirect = redirect()
            ->route('dash-beranda.index')
            ->with('success', $membershipType
                ? 'Profile berhasil disimpan. Silakan pilih metode pembayaran.'
                : 'Profile berhasil diperbarui.');

        return $membershipType
            ? $redirect->with('open_membership_type', $membershipType)
            : $redirect;
    }
}
