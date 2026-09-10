<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DataPayment;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

/**
 * Compatibility endpoint for member invoice PDFs.
 */
class MembershipController extends Controller
{
    public function cetakinvoicepending($id, Request $request)
    {
        return $this->renderMembershipInvoice($id, false);
    }

    public function cetakinvoice($id, Request $request)
    {
        return $this->renderMembershipInvoice($id, true);
    }

    private function renderMembershipInvoice($id, bool $allowPaidView)
    {
        $payment = DataPayment::query()
            ->whereKey($id)
            ->where('user_id', Auth::id())
            ->where('tipe_pembelian', DataPayment::PURCHASE_TYPE_MEMBERSHIP)
            ->firstOrFail();

        $data['payment'] = $payment;
        $data['profile'] = UserProfileModel::where('user_id', Auth::id())->first();
        $data['isPaidInvoice'] = $allowPaidView && (int) $payment->status === DataPayment::STATUS_PAID;
        $pdf = PDF::loadView('invoice/membershippending', $data);

        return $pdf->setPaper('a4', 'landscape')->stream('invoice_'.$payment->no_invoice.'.pdf');
    }
}
