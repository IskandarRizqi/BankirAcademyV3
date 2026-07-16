<?php

namespace App\Http\Controllers\MemberNonAnggota;

use App\Http\Controllers\Controller;
use App\Models\ClassPaymentModel;
use App\Models\DataPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function databilling(Request $request)
    {
        $userId = (int) $request->user()->id;
        $this->syncExpiredPayments($userId);

        $billingSummary = $this->getBillingSummary($userId);
        $billingFilters = $this->resolveBillingFilters($request);
        $paymentHistories = $this->getPaymentHistories($userId, $billingFilters);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('membernonkeanggotaan.components.ui.billing-history-items', [
                    'paymentHistories' => $paymentHistories,
                ])->render(),
                'has_more_pages' => $paymentHistories->hasMorePages(),
                'next_page_url' => $paymentHistories->nextPageUrl(),
            ]);
        }

        return view('membernonkeanggotaan.pages.billing.billing', compact('billingSummary', 'billingFilters', 'paymentHistories'));
    }

    public function expirePayment(Request $request, DataPayment $payment)
    {
        abort_unless((int) $payment->user_id === (int) $request->user()->id, 403);

        $this->markPaymentAsExpired($payment);
        $payment->refresh();

        return response()->json([
            'status' => (int) $payment->status,
            'is_canceled' => (int) $payment->status === DataPayment::STATUS_CANCELED,
        ]);
    }

    private function getBillingSummary(int $userId): array
    {
        $now = Carbon::now();
        $dataPayments = DataPayment::query()->where('user_id', $userId);
        $legacyPayments = ClassPaymentModel::query()
            ->where('user_id', $userId)
            ->whereNotIn('no_invoice', DataPayment::query()->where('user_id', $userId)->select('no_invoice'));

        $spentAmount = (clone $dataPayments)->where('status', DataPayment::STATUS_PAID)->sum('nominal')
            + (clone $legacyPayments)->where('status', 1)->sum('price_final');

        return [
            'spent_amount' => $spentAmount,
            'spent_amount_formatted' => 'Rp '.number_format($spentAmount, 0, ',', '.'),
            'paid_count' => (clone $dataPayments)->where('status', DataPayment::STATUS_PAID)->count()
                + (clone $legacyPayments)->where('status', 1)->count(),
            'pending_count' => (clone $dataPayments)->where('status', DataPayment::STATUS_PENDING)->count()
                + (clone $legacyPayments)->where('status', 0)->where(function ($query) use ($now) {
                    $query->whereNull('expired')->orWhere('expired', '>=', $now);
                })->count(),
            'failed_count' => (clone $dataPayments)->where('status', DataPayment::STATUS_CANCELED)->count()
                + (clone $legacyPayments)->where('status', 0)->whereNotNull('expired')->where('expired', '<', $now)->count(),
        ];
    }

    private function resolveBillingFilters(Request $request): array
    {
        $status = $request->query('status', 'semua');
        $allowedStatuses = ['semua', 'berhasil', 'menunggu', 'dibatalkan', 'batal'];

        if (! in_array($status, $allowedStatuses, true)) {
            $status = 'semua';
        }

        return [
            'status' => $status === 'batal' ? 'dibatalkan' : $status,
            'start_date' => $this->normalizeDateFilter($request->query('start_date')),
            'end_date' => $this->normalizeDateFilter($request->query('end_date')),
        ];
    }

    private function normalizeDateFilter(?string $date): ?string
    {
        if (! $date) {
            return null;
        }

        try {
            return Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d');
        } catch (\Throwable $exception) {
            return null;
        }
    }

    private function getPaymentHistories(int $userId, array $filters)
    {
        return DataPayment::query()
            ->with([
                'paymentClass:id,title,image,image_mobile',
                'classPayment:id,no_invoice',
            ])
            ->where('user_id', $userId)
            ->when($filters['status'] === 'berhasil', function ($query) {
                $query->where('status', DataPayment::STATUS_PAID);
            })
            ->when($filters['status'] === 'menunggu', function ($query) {
                $query->where('status', DataPayment::STATUS_PENDING);
            })
            ->when($filters['status'] === 'dibatalkan', function ($query) {
                $query->where('status', DataPayment::STATUS_CANCELED);
            })
            ->when($filters['start_date'], function ($query, $startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($filters['end_date'], function ($query, $endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();
    }

    private function syncExpiredPayments(int $userId): void
    {
        DataPayment::query()
            ->where('user_id', $userId)
            ->where('status', DataPayment::STATUS_PENDING)
            ->get()
            ->each(function (DataPayment $payment) {
                $this->markPaymentAsExpired($payment);
            });
    }

    private function markPaymentAsExpired(DataPayment $payment): bool
    {
        if ((int) $payment->status !== DataPayment::STATUS_PENDING) {
            return false;
        }

        $expiresAt = $payment->created_at?->copy()->addMinutes((int) $payment->expired);

        if (! $expiresAt || $expiresAt->isFuture()) {
            return false;
        }

        return $payment->update([
            'status' => DataPayment::STATUS_CANCELED,
            'keterangan' => trim(($payment->keterangan ? $payment->keterangan.' ' : '').'Pembayaran otomatis dibatalkan karena melewati batas waktu.'),
        ]);
    }
}
