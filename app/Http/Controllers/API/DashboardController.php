<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DataPayment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();
        $payments = DataPayment::query()
            ->where('user_id', $user->id)
            ->get();
        $paidPayments = $payments->where('status', DataPayment::STATUS_PAID);

        return response()->json([
            'success' => true,
            'message' => 'Ringkasan dashboard berhasil diambil.',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role_id' => (int) $user->role,
                ],
                'purchases' => [
                    'classes' => $paidPayments->filter(fn ($payment) =>
                        (int) $payment->tipe_pembelian === DataPayment::PURCHASE_TYPE_CLASS
                        || strtolower((string) $payment->pembelian) === DataPayment::PURCHASE_CLASS
                    )->count(),
                    'ebooks' => $paidPayments->filter(fn ($payment) =>
                        (int) $payment->tipe_pembelian === DataPayment::PURCHASE_TYPE_EBOOK
                        || strtolower((string) $payment->pembelian) === DataPayment::PURCHASE_EBOOK
                    )->count(),
                    'videos' => $paidPayments->filter(fn ($payment) =>
                        (int) $payment->tipe_pembelian === DataPayment::PURCHASE_TYPE_VIDEO
                        || strtolower((string) $payment->pembelian) === DataPayment::PURCHASE_VIDEO
                    )->count(),
                ],
                'payments' => [
                    'paid' => $paidPayments->count(),
                    'pending' => $payments->where('status', DataPayment::STATUS_PENDING)->count(),
                    'waiting_confirmation' => $payments->where('status', DataPayment::STATUS_WAITING_CONFIRMATION)->count(),
                    'canceled' => $payments->whereIn('status', [
                        DataPayment::STATUS_CANCELED,
                        DataPayment::STATUS_REJECTED,
                    ])->count(),
                ],
                'recent_payments' => $payments->sortByDesc('created_at')->take(5)->values(),
            ],
        ]);
    }
}
