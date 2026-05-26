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
use App\Models\SertifikatPesertaModel;
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
    // 1. Ambil data payment berdasarkan ID Invoice yang dikirim
    $data['payment'] = ClassPaymentModel::where('id', $id)
        ->where(function ($q) {
            $role = Auth::user()->role;
            if ($role == 2) {
                $q->where('user_id', Auth::user()->id);
            }
        })->first();

    if (!$data['payment']) {
        return Redirect::back()->with('error', 'Payment Data Not Found');
    }

    // 2. Ambil data relasi Kelas dan Profile
    $data['class'] = ClassesModel::where('id', $data['payment']->class_id)->first();
    $data['profile'] = UserProfileModel::where('user_id', $data['payment']->user_id)->first();

    if (!$data['class'] || !$data['class']->pricing) {
        return Redirect::back()->with('error', "Pricing Doesn't Exist");
    }

    if (!$data['profile']) {
        return Redirect::back()->with('error', "Please Fill Your Profile Info");
    }

    // 3. Update jumlah peserta jika ada perubahan dari request
    if ($r->jml_peserta > 0 && $r->jml_peserta != $data['payment']->jumlah) {
        $data['payment']->update([
            'jumlah' => $r->jml_peserta,
        ]);
        // Refresh data setelah update
        $data['payment'] = $data['payment']->fresh();
    }

    // 4. Validasi Sisa Kuota Kelas (Menggunakan class_id dari payment agar aman)
    $part = ClassPaymentModel::where('class_id', $data['payment']->class_id)
        ->where('id', '!=', $data['payment']->id)
        ->sum('jumlah');

    if ($data['class']->participant_limit < ($part + $data['payment']->jumlah)) {
        $return = Redirect::back()->with('error', 'Participant Sudah Penuh');
    }

    // 5. Inisialisasi awal nilai akhir dari 'price_final' yang disimpan di order_class
    $totalAkhir = $data['payment']->price_final;

    // Akses property object promo
    $kode = $data['payment']->promo ?? 0;
    $totalAkhir = $totalAkhir - $kode;

    // 6. Logika Referral Code
    // PERBAIKAN: Gunakan tanda panah (->), jangan kurung siku (['reff']) agar tidak dianggap kolom SQL
    $data['payment']->reff = 0;
    $data['payment']->reff_nominal = 0;
    $additional_discount = [];

    // $reff = RefferralModel::where('user_application', $data['profile']->user_id) // Pastikan nama kolom 'user_aplicator' atau 'user_application' benar
    //     ->whereNull('class_id')
    //     ->first();

    // if ($reff && $reff->available == 0) {
    //     $mr = MasterRefferralModel::first();
    //     if ($mr) {
    //         $data['payment']->reff_nominal = $mr->nominal;
            
    //         // Potongan harga referral dihitung dari harga dasar sebelum sertifikat & unique code
    //         $base_price = $data['payment']->price * $data['payment']->jumlah;
    //         $data['payment']->reff = $base_price * ($mr->potongan_harga / 100);
    //         $komisi = $data['payment']->reff * ($mr->nominal / 100);
            
    //         $totalAkhir = $totalAkhir - $data['payment']->reff;

    //         $additional_discount['reff_nominal'] = $mr->nominal;
    //         $additional_discount['reff'] = $data['payment']->reff;
    //         $additional_discount['komisi'] = $komisi;
    //         $additional_discount['totalAkhir'] = $totalAkhir;

    //         RefferralModel::updateOrCreate([
    //             'user_aplicator' => $data['profile']->user_id,
    //             'class_id' => $data['payment']->class_id
    //         ], [
    //             'user_id' => $reff->user_id,
    //             'user_aplicator' => $reff->user_aplicator,
    //             'code' => $reff->code,
    //             'nominal_class' => $base_price,
    //             'nominal_admin' => $komisi,
    //             'total' => $totalAkhir,
    //             'available' => 0,
    //             'class_id' => $data['payment']->class_id,
    //         ]);
    //     }
    // }

    // 7. Logika Existing User Diskon 30%
    // $data['diskon_existing'] = 0;
    // if ($data['profile']->existing_user == 1) {
    //     $data['diskon_existing'] = 30;
    //     // Diskon diambil dari harga kelas per orang
    //     $de = (30 / 100) * $data['payment']->price;
    //     $totalAkhir = $totalAkhir - ($de * $data['payment']->jumlah);
    // }

    // 8. Tambahkan Unique Code ke Total Akhir
    $totalAkhir += $data['payment']->unique_code;
    $data['payment']->totalAkhir = $totalAkhir;

    // 9. Update data log diskon tambahan ke database
    // $data['payment']->update([
    //     'additional_discount' => json_encode($additional_discount),
    //     'sudah_cetak' => 1,
    // ]);

    // 10. Konversi Terbilang & Generate PDF
    $data['terbilang'] = Terbilang::make($data['payment']->totalAkhir, '', 'Rp. ');

    if ($data['payment']->status == 1) {
        $pdf = PDF::loadView(env('CUSTOM_INVOICE_LUNAS', 'invoice/invoicelunas'), $data);
    } else {
        // Jika statusnya belum lunas, pastikan record SertifikatPesertaModel diperbarui/dibuat jika belum ada
        // SertifikatPesertaModel::updateOrCreate([
        //     'user_id' => Auth::user()->id,
        //     'class_id' => $data['class']->id,
        //     'payment_class_id' => $data['payment']->id,
        // ], [
        //     'nama' => $r->nama ? json_encode($r->nama) : json_encode([]),
        //     'email' => $r->email ? json_encode($r->email) : json_encode([]),
        //     'nohp' => $r->nomor_handphone ? json_encode($r->nomor_handphone) : json_encode([])
        // ]);
		// return $data;
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
				if ($value->gratis == 1) {
					$n = 0;
				}
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
							$value->totalAkhir = $n > 0 ? $n - $value->referral : 0;

							$additional_discount['reff_nominal'] = $mr->nominal;
							$additional_discount['reff'] = $n * ($mr->potongan_harga / 100);
							$additional_discount['komisi'] = $komisi;
							$additional_discount['totalAkhir'] = $n > 0 ? $n - $value->referral : 0;
						}
					}
					$available = 1;
				}
				$cpm = ClassPaymentModel::where('id', $value->payment_id)->update([
					'additional_discount' => json_encode($additional_discount),
				]);

				// Deklarasi variable existing user
				$data['diskon_existing'] = 0;
				if ($data['profile']['existing_user'] == 1) {
					// bila user existing maka dapat diskon 30%
					$data['diskon_existing'] = 30;
					$de = (30 / 100) * $value['price_final'];
					$data['payment']['totalAkhir'] = $n - $de;
				}

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
