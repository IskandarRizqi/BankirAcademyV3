<?php

namespace App\Services;

use App\Models\DataPayment;
use App\Models\UserProfileModel;
use Carbon\Carbon;

class MembershipPaymentService
{
    public function activate(DataPayment $payment): void
    {
        $profile = UserProfileModel::query()
            ->where('user_id', (int) $payment->user_id)
            ->lockForUpdate()
            ->firstOrFail();

        try {
            $activeUntil = $profile->masa_aktif_membership
                ? Carbon::parse($profile->masa_aktif_membership)
                : null;
        } catch (\Throwable $exception) {
            $activeUntil = null;
        }

        $now = Carbon::now();
        $baseDate = $activeUntil && $activeUntil->greaterThan($now) ? $activeUntil : $now;
        $membershipType = (int) $payment->tipe_membership;
        if (! in_array($membershipType, DataPayment::MEMBERSHIP_TYPES, true)) {
            $membershipType = str_contains(strtolower((string) $payment->keterangan), 'perorangan')
                ? DataPayment::MEMBERSHIP_TYPE_INDIVIDUAL
                : DataPayment::MEMBERSHIP_TYPE_COMPANY;
        }
        $profileData = [
            'status_membership' => DataPayment::STATUS_PAID,
            'masa_aktif_membership' => $baseDate->copy()->addYear()->format('Y-m-d'),
            'tipe_membership' => $membershipType,
        ];

        if (! $profile->tanggal_bergabung_membership) {
            $profileData['tanggal_bergabung_membership'] = $now->format('Y-m-d');
        }

        $profile->update($profileData);
        $payment->update([
            'status' => DataPayment::STATUS_PAID,
            'rejection_reason' => null,
        ]);
    }
}
