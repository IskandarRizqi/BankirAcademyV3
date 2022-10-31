<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ClassesModel;
use App\Models\ClassPaymentModel;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PDF;

class InvoiceController extends Controller
{
    public function getInvoice(Request $r,$id)
	{

		$data['payment'] = ClassPaymentModel::where('id',$id)->where(function ($q)
		{
			$role = Auth::user()->role;
			if ($role == 2) {
				$q->where('user_id',Auth::user()->id);
			}
		})->first();

		if (!$data['payment']) {
			return Redirect::back()->with('error', 'Payment Data Not Found');
		}

		$data['class'] = ClassesModel::where('id',$data['payment']->class_id)->first();
		$data['profile'] = UserProfileModel::where('user_id',$data['payment']->user_id)->first();

		// return $data;
		if ($data['payment']->status == 1) {
			$pdf = PDF::loadView(env('CUSTOM_INVOICE_LUNAS','invoice/invoicelunas'), $data);
		}else{
			$pdf = PDF::loadView(env('CUSTOM_INVOICE_PENDING','invoice/invoicepending'), $data);
		}
		return $pdf->setPaper('a4', 'landscape')->stream('invoice.pdf');
	}
}
