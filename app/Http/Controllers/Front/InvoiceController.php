<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BiayaSertifikatModel;
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
		// return $r->all();
		$data['payment'] = ClassPaymentModel::where('id', $r->payment_invoice)->where(function ($q) {
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
		$n = ($data['payment']['price_final'] * $data['payment']['jumlah']) - $kode;
		$data['payment']['totalAkhir'] = $n;
		// Cek referral Tersedia
		$available = 0;
		$reff = RefferralModel::where('user_aplicator', $data['profile']['user_id'])->first();
		$additional_discount = [];
		if ($reff) {
			if ($reff->available == 1) {
				$available = 1;
			}
			// Bila referral status 0 maka belum terpakai
			if ($available == 0) {
				// Ambil Master Referral Yang Dibuat Admin
				$mr = MasterRefferralModel::first();
				if ($mr) {
					$data['payment']['reff_nominal'] = $mr->nominal;
					$data['payment']['reff'] = $n * ($mr->potongan_harga / 100);
					$komisi = $data['payment']['reff'] * ($mr->nominal / 100);
					$data['payment']['totalAkhir'] = $n - $data['payment']['reff'];

					$additional_discount['reff_nominal'] = $mr->nominal;
					$additional_discount['reff'] = $n * ($mr->potongan_harga / 100);
					$additional_discount['komisi'] = $data['payment']['reff'] * ($mr->nominal / 100);
					$additional_discount['totalAkhir'] = $n - $data['payment']['reff'];
				}
			}
		}

		// Deklarasi vaiable sertifikat
		$data['payment']['sertifikat'] = 0;
		if ($r->sertifikat_invoice > 0) {
			$s = BiayaSertifikatModel::where('class_id', $data['payment']->class_id)->first();
			if ($s) {
				$data['payment']['sertifikat'] = $s->nominal;
				if ($s->type > 0) {
					$data['payment']['sertifikat'] = $n * ($s->nominal / 100);
				}
			}
		}

		$data['payment']['totalAkhir'] += $data['payment']['sertifikat'];
		$reff = ClassPaymentModel::where('id', $r->payment_invoice)->update([
			'additional_discount' => json_encode($additional_discount),
			'biaya_sertifikat' => $data['payment']['sertifikat'],
		]);

		// $data['payment']->qty = ClassParticipantModel::where('class_id', $data['payment']->class_id)->sum('jumlah');
		$data['terbilang'] = Terbilang::make($data['payment']['totalAkhir'], '', 'Rp. ');
		// return $data;
		if ($data['payment']->status == 1) {
			$pdf = PDF::loadView(env('CUSTOM_INVOICE_LUNAS', 'invoice/invoicelunas'), $data);
		} else {
			$pdf = PDF::loadView(env('CUSTOM_INVOICE_PENDING', 'invoice/invoicepending'), $data);
		}
		return $pdf->setPaper('a4', 'landscape')->stream('invoice.pdf');
	}

	public function multiInvoice(Request $request)
	{
		// return $request->all();
		$id = [];
		$class_id = [];
		if ($request->dataInvoice) {
			foreach (json_decode($request->dataInvoice) as $key => $value) {
				if ($value) {
					// return response()->json([
					// 	'status' => false,
					// 	'message' => 'kosong',
					// ]);
					array_push($id, $value->id);
					array_push($class_id, $value->class_id);
				}
			}

			$numbers = ClassPaymentModel::select('no_invoice')->pluck('no_invoice')->toArray();
			do {
				$no_invoice = uniqid();
			} while (in_array($no_invoice, $numbers));
			if (count($id) <= 0) {
				return Redirect::back()->with('error', 'Data Tidak Ditemukan');
			}

			$data['payment'] = ClassPaymentModel::select('class_payment.*', 'class_payment.id as payment_id', 'class_payment.created_at as tanggal', 'class_pricing.*', 'classes.title')
				->join('class_pricing', 'class_pricing.class_id', 'class_payment.class_id')
				->join('classes', 'classes.id', 'class_payment.class_id')
				->whereIn('class_payment.id', $id)
				->orderBy('class_payment.price_final', 'DESC')
				->get();
			// return $data;
			$data['profile'] = UserProfileModel::where('user_id', $data['payment'][0]['user_id'])->first();
			$data['total'] = 0;
			$available = 0;
			foreach ($data['payment'] as $key => $value) {
				// update nomor invoice
				ClassPaymentModel::where('id', $value->payment_id)->update([
					'no_invoice' => $no_invoice
				]);
				// Deklarasi variable kode promo
				$kode = 0;
				if ($value['promo']) {
					// Cek kode promo Tersedia
					$kode = $value['promo'];
				}
				// Deklarasi referral
				$value->referral = 0;
				$value->reff_nominal = 0;
				$n = ($value['price_final'] * $value['jumlah']) - $kode;
				$value->totalAkhir = $n;
				// Cek referral Tersedia
				$reff = RefferralModel::where('user_aplicator', $data['profile']['user_id'])->first();
				$additional_discount = [];
				if ($reff) {
					if ($reff->available == 1) {
						$available = 1;
					}
					// Bila referral status 0 maka belum terpakai
					if ($available == 0) {
						// Ambil Master Referral Yang Dibuat Admin
						$mr = MasterRefferralModel::first();
						if ($mr) {
							$value->reff_nominal = $mr->nominal;
							$value->referral = $n * ($mr->potongan_harga / 100);
							$komisi = $value->reff_nominal * ($mr->nominal / 100);
							$value->totalAkhir = $n - $value->referral;

							$additional_discount['reff_nominal'] = $mr->nominal;
							$additional_discount['reff'] = $n * ($mr->potongan_harga / 100);
							$additional_discount['komisi'] = $komisi;
							$additional_discount['totalAkhir'] = $n - $value->referral;
						}
					}
					$available = 1;
				}
				$cpm = ClassPaymentModel::where('id', $value->payment_id)->update([
					'additional_discount' => json_encode($additional_discount),
				]);
				$data['total'] += $value->totalAkhir;
			}
			$data['no_invoice'] = $no_invoice;
			$data['terbilang'] = Terbilang::make($data['total'], '', 'Rp. ');
			// return $data;
			$pdf = PDF::loadView(env('CUSTOM_INVOICE_LUNAS', 'invoice/multiinvoice'), $data);
			return $pdf->setPaper('a4', 'landscape')->stream('invoice.pdf');
		} else {
			return Redirect::back()->with('error', 'Data Tidak Ditemukan');
		}
	}
}
