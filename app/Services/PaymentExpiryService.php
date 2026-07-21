<?php

namespace App\Services;

use App\Models\DataPayment;
use App\Models\UserProfileModel;
use Illuminate\Support\Facades\DB;

class PaymentExpiryService
{
    public function syncForUser(int $userId): void
    {
        DataPayment::query()
            ->where('user_id', $userId)
            ->where('status', DataPayment::STATUS_PENDING)
            ->get()
            ->each(fn (DataPayment $payment) => $this->expireIfNeeded($payment));
    }

    public function expireIfNeeded(DataPayment $payment): bool
    {
        return DB::transaction(function () use ($payment): bool {
            $lockedPayment = DataPayment::query()
                ->whereKey($payment->id)
                ->lockForUpdate()
                ->first();

            if (! $lockedPayment || (int) $lockedPayment->status !== DataPayment::STATUS_PENDING) {
                return false;
            }

            if ($lockedPayment->isIhtWithoutExpiry()) {
                return false;
            }

            if ((int) $lockedPayment->is_iht === 1
                && (int) $lockedPayment->is_konfirmasi === 1
                && ! $lockedPayment->link_payment) {
                return false;
            }

            $expiresAt = $lockedPayment->paymentExpiresAt();

            if (! $expiresAt || $expiresAt->isFuture()) {
                return false;
            }

            $wasCanceled = $lockedPayment->update([
                'status' => DataPayment::STATUS_CANCELED,
                'keterangan' => trim(($lockedPayment->keterangan ? $lockedPayment->keterangan . ' ' : '') . 'Pembayaran otomatis dibatalkan karena melewati batas waktu.'),
            ]);

            $isMembershipPayment = (int) $lockedPayment->tipe_pembelian === DataPayment::PURCHASE_TYPE_MEMBERSHIP
                || strtolower((string) $lockedPayment->pembelian) === DataPayment::PURCHASE_MEMBERSHIP;

            if ($wasCanceled && $isMembershipPayment) {
                UserProfileModel::query()
                    ->where('user_id', (int) $lockedPayment->user_id)
                    ->where('status_membership', DataPayment::STATUS_PENDING)
                    ->update(['status_membership' => 0]);
            }

            return $wasCanceled;
        });
    }
}
