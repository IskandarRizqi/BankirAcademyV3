<?php

namespace App\Http\Controllers\MemberNonAnggota;

use App\Http\Controllers\Controller;
use App\Models\ClassPaymentModel;
use App\Models\DataPayment;
use App\Models\UserProfileModel;
use App\Services\PaymentExpiryService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BillingController extends Controller
{
    public function __construct(private PaymentExpiryService $paymentExpiryService) {}

    public function databilling(Request $request)
    {
        $userId = (int) $request->user()->id;
        $this->paymentExpiryService->syncForUser($userId);

        $paymentReturn = $this->redirectAfterPayment($request, $userId);

        if ($paymentReturn) {
            return $paymentReturn;
        }

        $billingSummary = $this->getBillingSummary($userId);
        $billingFilters = $this->resolveBillingFilters($request);
        $paymentHistories = $this->getPaymentHistories($userId, $billingFilters);
        // return $paymentHistories;
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
    public function uploadBuktiTransfer(Request $request, $id)
    {
        $request->validate([
            'link_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048', // maks 2MB
        ]);

        $payment = DataPayment::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if ($request->hasFile('link_payment')) {
            // Hapus file lama jika ada
            if ($payment->link_payment && Storage::disk('public')->exists($payment->link_payment)) {
                Storage::disk('public')->delete($payment->link_payment);
            }

            // Simpan file baru
            $path = $request->file('link_payment')->store('link_payment', 'public');

            // Update database
            $payment->update([
                'link_payment' => $path,
                'status' => 3
            ]);
        }

        return redirect()->back()->with('success', 'Bukti transfer berhasil diunggah. Menunggu konfirmasi admin.');
    }

    private function redirectAfterPayment(Request $request, int $userId): ?RedirectResponse
    {
        $invoiceNumber = $request->query('invoice_number')
            ?? $request->query('invoiceNumber')
            ?? $request->query('order.invoice_number')
            ?? data_get($request->query('order'), 'invoice_number');

        if (!filled($invoiceNumber)) {
            return null;
        }

        $payment = DataPayment::query()
            ->with([
                'paymentClass:id,title',
                'materi:id,nama',
                'subMateri:id,nama',
            ])
            ->where('user_id', $userId)
            ->where('no_invoice', $invoiceNumber)
            ->first();

        $paymentContext = $payment ? $this->paymentContext($payment) : null;

        if (!$payment || !$paymentContext) {
            return null;
        }

        if ((int) $payment->status === DataPayment::STATUS_PAID) {
            $message = $paymentContext['type'] === 'membership'
                ? 'Pembayaran membership ' . $this->membershipTypeLabel($payment) . ' berhasil. Masa aktif membership Anda telah diperbarui.'
                : $this->confirmedPaymentMessage($paymentContext);

            return redirect('/pembayaran')->with(
                'success',
                $message
            );
        }

        if ((int) $payment->status === DataPayment::STATUS_CANCELED) {
            return redirect('/pembayaran')->with(
                'error',
                'Pembayaran ' . $paymentContext['label'] . ' gagal atau dibatalkan. Silakan buat order baru untuk mencoba lagi.'
            );
        }

        return redirect('/pembayaran')->with(
            'info',
            $this->pendingPaymentMessage($paymentContext)
        );
    }

    private function paymentContext(DataPayment $payment): ?array
    {
        if (
            (int) $payment->tipe_pembelian === DataPayment::PURCHASE_TYPE_MEMBERSHIP
            || strtolower((string) $payment->pembelian) === DataPayment::PURCHASE_MEMBERSHIP
        ) {
            return [
                'type' => 'membership',
                'label' => 'membership',
                'name' => null,
            ];
        }

        return match ((int) $payment->tipe_pembelian) {
            DataPayment::PURCHASE_TYPE_CLASS => [
                'type' => 'kelas',
                'label' => 'kelas',
                'name' => data_get($payment, 'paymentClass.title')
                    ?: data_get($payment, 'materi.nama', 'Kelas'),
            ],
            DataPayment::PURCHASE_TYPE_EBOOK => [
                'type' => 'ebook',
                'label' => 'ebook',
                'name' => data_get($payment, 'subMateri.nama', 'Ebook'),
            ],
            DataPayment::PURCHASE_TYPE_VIDEO => [
                'type' => 'video',
                'label' => 'video',
                'name' => data_get($payment, 'subMateri.nama', 'Video'),
            ],
            default => null,
        };
    }

    private function pendingPaymentMessage(array $paymentContext): string
    {
        if ($paymentContext['type'] === 'membership') {
            return 'Order membership berhasil dibuat dan pembayaran sedang diverifikasi.';
        }

        return sprintf(
            'Pesanan %s "%s" berhasil dibuat. Silakan selesaikan pembayaran untuk mengaktifkan akses ke %s.',
            $paymentContext['label'],
            $paymentContext['name'],
            $paymentContext['label']
        );
    }

    private function confirmedPaymentMessage(array $paymentContext): string
    {
        return match ($paymentContext['type']) {
            'kelas' => sprintf(
                'Pembayaran untuk kelas "%s" berhasil dikonfirmasi. Akses Anda ke kelas telah diaktifkan. Silakan buka menu Pembelajaran Saya Anda untuk mulai belajar.',
                $paymentContext['name']
            ),
            'ebook' => sprintf(
                'Pembayaran untuk Ebook "%s" berhasil dikonfirmasi. Akses Anda ke Ebook telah diaktifkan. Silakan buka menu Pembelajaran Saya untuk mulai belajar.',
                $paymentContext['name']
            ),
            'video' => sprintf(
                'Pembayaran untuk Video "%s" berhasil dikonfirmasi. Akses Anda ke video telah diaktifkan. Silakan buka menu Pembelajaran Saya untuk mulai belajar.',
                $paymentContext['name']
            ),
            default => 'Pembayaran berhasil dikonfirmasi.',
        };
    }

    private function membershipTypeLabel(DataPayment $payment): string
    {
        return (int) $payment->tipe_membership === DataPayment::MEMBERSHIP_TYPE_INDIVIDUAL
            ? 'perorangan'
            : 'perusahaan';
    }

    public function expirePayment(Request $request, DataPayment $payment)
    {
        abort_unless((int) $payment->user_id === (int) $request->user()->id, 403);

        $this->paymentExpiryService->expireIfNeeded($payment);
        $payment->refresh();

        return response()->json([
            'status' => (int) $payment->status,
            'is_canceled' => (int) $payment->status === DataPayment::STATUS_CANCELED,
        ]);
    }

    public function cancelMembership(Request $request)
    {
        $userId = (int) $request->user()->id;

        DB::transaction(function () use ($userId) {
            $pendingMemberships = DataPayment::query()
                ->where('user_id', $userId)
                ->where('tipe_pembelian', DataPayment::PURCHASE_TYPE_MEMBERSHIP)
                ->where('status', DataPayment::STATUS_PENDING)
                ->lockForUpdate()
                ->get();

            $pendingMemberships->each(function (DataPayment $payment) {
                $payment->update([
                    'status' => DataPayment::STATUS_CANCELED,
                    'keterangan' => trim(($payment->keterangan ? $payment->keterangan . ' ' : '') . 'Order membership dibatalkan oleh pengguna.'),
                ]);
            });

            UserProfileModel::query()
                ->where('user_id', $userId)
                ->lockForUpdate()
                ->update(['status_membership' => 0]);
        });

        return back()->with('success', 'Order membership berhasil dibatalkan.');
    }

    public function continueMembershipPayment(Request $request)
    {
        $payment = DataPayment::query()
            ->where('user_id', (int) $request->user()->id)
            ->where('tipe_pembelian', DataPayment::PURCHASE_TYPE_MEMBERSHIP)
            ->where('status', DataPayment::STATUS_PENDING)
            ->whereNotNull('link_payment')
            ->latest('id')
            ->first();

        if (! $payment || blank($payment->link_payment)) {
            return back()->with('error', 'Link pembayaran membership tidak tersedia.');
        }

        return redirect()->away($payment->link_payment);
    }

    private function getBillingSummary(int $userId): array
    {
        $now = Carbon::now();
        $dataPayments = DataPayment::query()->where('user_id', $userId);
        $legacyPayments = ClassPaymentModel::query()
            ->where('user_id', $userId)
            ->whereNotIn('no_invoice', DataPayment::query()->where('user_id', $userId)->select('no_invoice'));

        $spentAmount = (clone $dataPayments)
            ->where('status', DataPayment::STATUS_PAID)
            ->notWaitingForIhtConfirmation()
            ->sum('nominal')
            + (clone $legacyPayments)->where('status', 1)->sum('price_final');

        return [
            'spent_amount' => $spentAmount,
            'spent_amount_formatted' => 'Rp ' . number_format($spentAmount, 0, ',', '.'),
            'paid_count' => (clone $dataPayments)
                ->where('status', DataPayment::STATUS_PAID)
                ->notWaitingForIhtConfirmation()
                ->count()
                + (clone $legacyPayments)->where('status', 1)->count(),
            'pending_count' => (clone $dataPayments)
                ->where(function ($query) {
                    $query->where('status', DataPayment::STATUS_PENDING)
                        ->orWhere(function ($query) {
                            $query->waitingForIhtConfirmation();
                        });
                })
                ->count()
                + (clone $legacyPayments)->where('status', 0)->where(function ($query) use ($now) {
                    $query->whereNull('expired')->orWhere('expired', '>=', $now);
                })->count(),
            'failed_count' => (clone $dataPayments)
                ->where('status', DataPayment::STATUS_CANCELED)
                ->notWaitingForIhtConfirmation()
                ->count()
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
                'materi:id,nama',
                'subMateri:id,nama',
                'classPayment:id,no_invoice',
                'riwayatTransaksi:no_invoice,manual',
            ])
            ->where('user_id', $userId)
            ->when($filters['status'] === 'berhasil', function ($query) {
                $query->where('status', DataPayment::STATUS_PAID)
                    ->notWaitingForIhtConfirmation();
            })
            ->when($filters['status'] === 'menunggu', function ($query) {
                $query->where(function ($query) {
                    $query->where('status', DataPayment::STATUS_PENDING)
                        ->orWhere(function ($query) {
                            $query->waitingForIhtConfirmation();
                        });
                });
            })
            ->when($filters['status'] === 'dibatalkan', function ($query) {
                $query->where('status', DataPayment::STATUS_CANCELED)
                    ->notWaitingForIhtConfirmation();
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
}
