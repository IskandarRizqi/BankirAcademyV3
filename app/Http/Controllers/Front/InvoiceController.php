<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ClassesModel;
use App\Models\ClassParticipantModel;
use App\Models\ClassPaymentModel;
use App\Models\KodePromoModel;
use App\Models\MasterRefferralModel;
use App\Models\RefferralModel;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Terbilang;
use PDF;

class InvoiceController extends Controller
{
	public function getInvoice(Request $r, $id)
	{

		$data['payment'] = ClassPaymentModel::where('id', $id)->where(function ($q) {
			$role = Auth::user()->role;
			if ($role == 2) {
				$q->where('user_id', Auth::user()->id);
			}
		})->first();

		if (!$data['payment']) {
			return Redirect::back()->with('error', 'Payment Data Not Found');
		}

		$data['class'] = ClassesModel::where('id', $data['payment']->class_id)->first();
		$data['profile'] = UserProfileModel::where('user_id', $data['payment']->user_id)->first();

		if (!$data['class']->pricing) {
			return Redirect::back()->with('error', "Pricing Doesn't Exist");
		}

		if (!$data['profile']) {
			return Redirect::back()->with('error', "Please Fill Your Profile Info");
		}

		// Deklarasi variable kode promo
		$kode = 0;
		if ($data['payment']['promo']) {
			// Cek kode promo Tersedia
			$kode = $data['payment']['promo'];
		}
		// Deklarasi referral
		$data['payment']['reff'] = 0;
		$data['payment']['reff_nominal'] = 0;
		$data['payment']['totalAkhir'] = 0;
		// Cek referral Tersedia
		$n = ($data['payment']['price_final'] * $data['payment']['jumlah']) - $kode;
		$reff = RefferralModel::where('user_aplicator', $data['profile']['user_id'])->first();
		if ($reff) {
			// Bila referral status 0 maka belum terpakai
			if ($reff->status == 0) {
				// Ambil Master Referral Yang Dibuat Admin
				$mr = MasterRefferralModel::first();
				if ($mr) {
					$data['payment']['reff_nominal'] = $mr->nominal;
					$data['payment']['reff'] = $n * ($mr->nominal / 100);
					$data['payment']['totalAkhir'] = $n - $data['payment']['reff'];
				}
			}
		}

		$data['payment']->qty = ClassParticipantModel::where('class_id', $data['payment']->class_id)->sum('jumlah');
		$data['terbilang'] = Terbilang::make($data['payment']['totalAkhir'], '', 'Rp. ');
		// return $data;
		if ($data['payment']->status == 1) {
			$pdf = PDF::loadView(env('CUSTOM_INVOICE_LUNAS', 'invoice/invoicelunas'), $data);
		} else {
			$pdf = PDF::loadView(env('CUSTOM_INVOICE_PENDING', 'invoice/invoicepending'), $data);
		}
		return $pdf->setPaper('a4', 'landscape')->stream('invoice.pdf');
	}
}
