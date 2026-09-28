<?php

namespace App\Http\Controllers\MemberNonAnggota;

use App\Http\Controllers\Controller;
use App\Http\Requests\MembershipProfileRequest;
use App\Models\UserProfileModel;
use App\Services\FonnteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;

class MembershipProfileController extends Controller
{
    private const OTP_TTL_MINUTES = 10;

    public function __construct(private FonnteService $fonnteService) {}

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

        $profile = UserProfileModel::where('user_id', $request->user()->id)->first();
        $phone = UserProfileModel::normalizePhone($validated['phone']);
        $phoneChanged = UserProfileModel::normalizePhone($profile?->phone) !== $phone;
        $validated['phone'] = $phone;

        if ($phoneChanged) {
            $validated['status_nomor'] = false;
            $validated['otp'] = null;
            $validated['otp_expires_at'] = null;
        }

        $profile = UserProfileModel::updateOrCreate(
            ['user_id' => $request->user()->id],
            $validated + ['user_id' => $request->user()->id]
        );

        $requiresVerification = $phoneChanged || ! $profile->isPhoneVerified();

        if ($requiresVerification) {
            return $this->sendVerificationOtp($profile, $membershipType);
        }

        $redirect = redirect()
            ->route('dash-beranda.index')
            ->with('success', $membershipType
                ? 'Profile berhasil disimpan. Silakan pilih metode pembayaran.'
                : 'Profile berhasil diperbarui.');

        return $membershipType
            ? $redirect->with('open_membership_type', $membershipType)
            : $redirect;
    }

    public function resendOtp(Request $request): RedirectResponse
    {
        $profile = UserProfileModel::where('user_id', $request->user()->id)->first();

        if (! $profile || ! filled($profile->phone)) {
            return redirect()
                ->route('dash-beranda.index')
                ->with('error', 'Simpan nomor handphone terlebih dahulu.');
        }

        return $this->sendVerificationOtp($profile, $request->integer('membership_tipe'));
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'otp' => ['required', 'digits:6'],
            'membership_tipe' => ['nullable', 'integer', 'in:1,2'],
        ]);
        $profile = UserProfileModel::where('user_id', $request->user()->id)->first();

        if (
            ! $profile
            || ! filled($profile->otp)
            || ! $profile->otp_expires_at
            || $profile->otp_expires_at->isPast()
            || ! Hash::check($validated['otp'], $profile->otp)
        ) {
            return redirect()
                ->route('dash-beranda.index')
                ->withInput()
                ->with('open_phone_verification', true)
                ->with('phone_verification_membership_type', $validated['membership_tipe'] ?? null)
                ->with('error', 'Kode OTP tidak valid atau sudah kedaluwarsa.');
        }

        $profile->forceFill([
            'status_nomor' => true,
            'otp' => null,
            'otp_expires_at' => null,
        ])->save();

        $redirect = redirect()
            ->route('dash-beranda.index')
            ->with('success', 'Nomor handphone berhasil diverifikasi.');

        return ! empty($validated['membership_tipe'])
            ? $redirect->with('open_membership_type', (int) $validated['membership_tipe'])
            : $redirect;
    }

    private function sendVerificationOtp(UserProfileModel $profile, ?int $membershipType): RedirectResponse
    {
        $otp = (string) random_int(100000, 999999);
        $phone = UserProfileModel::normalizePhone($profile->phone);

        try {
            $response = $this->fonnteService->sendMessage(
                $phone,
                implode("\n", [
                    'Kode verifikasi nomor handphone Bankir Academy:',
                    $otp,
                    '',
                    'Kode berlaku selama '.self::OTP_TTL_MINUTES.' menit. Jangan berikan kode ini kepada siapa pun.',
                ])
            );

            $providerStatus = $response->json('status');
            if (! $response->successful() || ! in_array($providerStatus, [true, 1, 'true', '1'], true)) {
                throw new \RuntimeException('Fonnte menolak pengiriman OTP.');
            }

            $profile->forceFill([
                'otp' => Hash::make($otp),
                'status_nomor' => false,
                'otp_expires_at' => now()->addMinutes(self::OTP_TTL_MINUTES),
            ])->save();
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('dash-beranda.index')
                ->with('open_phone_verification', true)
                ->with('phone_verification_membership_type', $membershipType)
                ->with('error', 'OTP gagal dikirim ke WhatsApp. Periksa nomor handphone dan coba lagi.');
        }

        return redirect()
            ->route('dash-beranda.index')
            ->with('open_phone_verification', true)
            ->with('phone_verification_membership_type', $membershipType)
            ->with('success', 'OTP telah dikirim ke WhatsApp Anda.');
    }
}
