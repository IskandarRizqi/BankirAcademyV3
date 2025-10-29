<?php

namespace App\Http\Controllers\Front;

use App\Helper\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Models\BannerModel;
use App\Models\ClassesModel;
use App\Models\ClassParticipantModel;
use App\Models\ClassPaymentModel;
use App\Models\ClassPricingModel;
use App\Models\KodePromoModel;
use App\Models\MasterRefferralModel;
use App\Models\RefferralModel;
use App\Models\UserProfileModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        // $auth = Auth::user()->id;
        // $data['pfl'] = UserProfileModel::where('user_id', Auth::user()->id)->first();
        // $data['payment'] = ClassPaymentModel::where('user_id', $auth)->get();
        // $data['class_id'] = ClassPaymentModel::where('user_id', $auth)->pluck('class_id')->toArray();
        // $data['class'] = ClassesModel::whereIn('id', $data['class_id'])->get();
        // return view('front.profile.profile', $data);
    }

    public function multibayar(Request $request)
    {
        // return $request->all();
        if (!$request->dataInvoiceMulti) {
            return Redirect::back()->with('error', 'Data Tidak Ditemukan');
        }
        if (!$request->imageBuktiMulti) {
            return Redirect::back()->with('error', 'Gambar Tidak Ditemukan');
        }

        $payment_id = [];
        $inv_lama = '';
        $inv_kini = '';
        foreach (json_decode($request->dataInvoiceMulti) as $key => $value) {
            if ($key == 0) {
                $inv_lama = $value->no_invoice;
            }

            if ($key > 0) {
                $inv_kini = $value->no_invoice;
                if ($inv_kini !== $inv_lama) {
                    return Redirect::back()->with('error', 'Cek Invoice Terlebih Dahulu');
                }
            }
            array_push($payment_id, $value->id);
        }

        $size = $request->file('imageBuktiMulti')->getSize();
        if (($size / 1024) > 100) {
            return Redirect::back()->with('error', 'Size Maximum 100kb');
        }

        $data['payment'] = ClassPaymentModel::select('class_payment.*', 'class_payment.id as payment_id', 'class_payment.created_at as tanggal', 'class_pricing.*', 'classes.title')
            ->join('class_pricing', 'class_pricing.class_id', 'class_payment.class_id')
            ->join('classes', 'classes.id', 'class_payment.class_id')
            ->whereIn('class_payment.id', $payment_id)
            ->orderBy('class_payment.price_final', 'DESC')
            ->get();
        // return $data;
        $available = 0;
        foreach ($data['payment'] as $key => $v) {
            $data['profile'] = UserProfileModel::where('user_id', $v->user_id)->first();
            $kode = 0;
            if ($v->promo == 1) {
                // Cek kode promo Tersedia
                $kode = $v->promo_price;
            }
            // Deklarasi referral
            $v->reff = 0;
            $v->reff_nominal = 0;
            $n = ($v->price_final * $v->jumlah) - $kode;
            $v->totalAkhir = $n;
            // Cek referral Tersedia
            $reff = RefferralModel::where('user_aplicator', $data['profile']->user_id)->first();
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
                        $v->reff_nominal = $mr->nominal;
                        $v->reff = $n * ($mr->potongan_harga / 100);
                        $komisi = $v->reff * ($mr->nominal / 100);
                        $v->totalAkhir = $n - $v->reff;

                        $additional_discount['reff_nominal'] = $mr->nominal;
                        $additional_discount['reff'] = $n * ($mr->potongan_harga / 100);
                        $additional_discount['komisi'] = $v->reff * ($mr->nominal / 100);
                        $additional_discount['totalAkhir'] = $n - $v->reff;

                        // RefferralModel::where('user_aplicator', $data['profile']->user_id)->update([
                        //     'available' => 1
                        // ]);
                    }
                }
            }
            $available = 1;

            $gambar = $request->file('imageBuktiMulti')->store('order/' . Auth::user()->email . '/' . time());
            ClassPaymentModel::where('id', $v->payment_id)->update([
                'file' => $gambar,
                'additional_discount' => json_encode($additional_discount)
            ]);
        }

        return Redirect::back()->with('success', 'Upload Bukti Berhasil');
    }
    public function bayarv2(Request $request)
    {
        $insert = [];
        $validator = Validator::make($request->all(), [
            'class_id' => 'required',
            'payment_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Data Tidak Sesuai', 'data' => $validator]);
        }

        // Input Jumlah Peserta
        $part = ClassPaymentModel::where('class_id', $request->class_id)->where('id', '!=', $request->payment_id)->sum('jumlah');
        if ($request->limit < ($part + $request->jumlah)) {
            return response()->json(['status' => false, 'message' => 'Participant Sudah Penuh', 'data' => $request->limit]);
        }
        $cpm = ClassPaymentModel::where('id', $request->payment_id)->update([
            'jumlah' => $request->jumlah,
        ]);
        if (!$cpm) {
            return response()->json(['status' => false, 'message' => 'Peserta Tidak Tersimpan']);
        }

        // Cek File Size
        // foreach ($request->input2 as $key => $value) {
        //     $size = $request->file('input2')[$key]->getSize();
        //     if (($size / 1024) > 100) {
        //         return response()->json(['status' => false, 'message' => 'Size Maximum 100kb']);
        //     }
        //     $gambar = $value->store('order/' . Auth::user()->email . '/' . time());
        // }
        if ($request->gambar && $request->gambar != 'undefined') {
            $name = $request->file('gambar')->getClientOriginalName(); // Name File
            $size = $request->file('gambar')->getSize(); // Size File

            if ($size >= 1048576) {
                return response()->json(['status' => false, 'message' => 'Size Maximum 1Mb']);
            }

            $filename = time() . '-' . $name;
            $file = $request->file('gambar');
            $insert['file'] = $file->store('order/' . Auth::user()->email . '/' . time());
        }

        // Promo dari Banner
        $bp = BannerModel::where('jenis', 2)->where('kode', $request->kode)->where('mulai', '<', Carbon::now())->where('selesai', '>=', Carbon::now())->get();
        $kp = KodePromoModel::where('kode', $request->kode)->where('class_title', 'like', '%"' . urldecode($request->class_title) . '"%')->where('tgl_selesai', '>=', Carbon::now())->get();
        // $kp = KodePromoModel::where('kode', $kode_promo)->where('class_title', 'like', '%"' . $title_kelas . '"%')->where('tgl_selesai', '>=', Carbon::now())->get();
        if (count($kp) > 0) {
            $cpm = ClassPaymentModel::where('id', $request->payment_id)->update([
                'kode_promo' => $request->kode,
            ]);
            if (!$cpm) {
                return response()->json(['message' => 'Update Promo Banner Gagal', 'status' => false]);
            }
        }
        if (count($bp) > 0) {
            $cpm = ClassPaymentModel::where('id', $request->payment_id)->update([
                'kode_promo' => $request->kode,
            ]);
            if (!$cpm) {
                return response()->json(['message' => 'Update Kode Promo Gagal', 'status' => false]);
            }
        }

        $data['payment'] = ClassPaymentModel::where('id', $request->payment_id)->first();
        $data['profile'] = UserProfileModel::where('user_id', $data['payment']->user_id)->first();
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
        $reff = RefferralModel::where('user_aplicator', $data['profile']['user_id'])
            ->whereNull('class_id')
            ->first();
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

                    RefferralModel::updateOrCreate([
                        'user_aplicator' => $data['profile']['user_id'],
                        'class_id' => $request->class_id
                    ], [
                        'user_id' => $reff->user_id,
                        'user_aplicator' => $reff->user_aplicator,
                        'code' => $reff->code,
                        'nominal_class' => $n,
                        'nominal_admin' => $additional_discount['komisi'],
                        'total' => $additional_discount['totalAkhir'],
                        'available' => 0,
                        'class_id' => $request->class_id,
                    ]);
                }
            }
        }

        $insert['additional_discount'] = json_encode($additional_discount);
        if ($request->kode) {
            $insert['kode_promo'] = $request->kode;
        }
        $update = ClassPaymentModel::where('id', $request->payment_id)->update($insert);
        if ($update) {
            return response()->json(['message' => 'Upload Bukti Berhasil', 'status' => true, 'data' => $insert]);
        }
        if ($cpm) {
            return response()->json(['status' => true, 'message' => 'Data Tersimpan']);
        }
        return response()->json(['message' => 'Upload Bukti Gagal', 'status' => false, 'data' => $update]);
    }
    public function bayar(Request $request)
    {
        if ($request->ajax()) {
            $part = ClassPaymentModel::where('class_id', $request->classid)->where('id', '!=', $request->payment_id)->sum('jumlah');
            if ($request->limit < ($part + $request->jumlah)) {
                return response()->json(['status' => false, 'message' => 'Participant Sudah Penuh']);
            }
            ClassPaymentModel::where('id', $request->payment_id)->update([
                'jumlah' => $request->jumlah,
            ]);
            return response()->json(['status' => true, 'message' => 'Input Participant Berhasil']);
        }
        $validator = Validator::make($request->all(), [
            'input2' => 'required',
            'class_id' => 'required',
            'payment_id' => 'required',
            // 'jml_peserta' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        }
        foreach ($request->input2 as $key => $value) {
            $size = $request->file('input2')[$key]->getSize();
            if (($size / 1024) > 100) {
                return Redirect::back()->with('error', 'Size Maximum 100kb');
            }
            $gambar = $value->store('order/' . Auth::user()->email . '/' . time());
        }

        $data['payment'] = ClassPaymentModel::where('id', $request->payment_id)->first();
        $data['profile'] = UserProfileModel::where('user_id', $data['payment']->user_id)->first();
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
        $reff = RefferralModel::where('user_aplicator', $data['profile']['user_id'])
            ->whereNull('class_id')
            ->first();
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

                    RefferralModel::updateOrCreate([
                        'user_aplicator' => $data['profile']['user_id'],
                        'class_id' => $request->class_id
                    ], [
                        'user_id' => $reff->user_id,
                        'user_aplicator' => $reff->user_aplicator,
                        'code' => $reff->code,
                        'nominal_class' => $n,
                        'nominal_admin' => $additional_discount['komisi'],
                        'total' => $additional_discount['totalAkhir'],
                        'available' => 0,
                        'class_id' => $request->class_id,
                    ]);
                }
            }
        }

        $data = [
            'file' => $gambar,
            'additional_discount' => json_encode($additional_discount)
        ];
        $update = ClassPaymentModel::where('id', $request->payment_id)->update($data);
        if ($update) {
            return Redirect::back()->with('success', 'Upload Bukti Berhasil');
        }
        return Redirect::back()->with('error', 'Upload Bukti Gagal');
    }
    public function order_class(Request $request)
    {
        // return $request->all();
        // $next = GlobalHelper::getaksesmembership();
        // if (!$next) {
        //     return Redirect::back()->with('akses', 'member');
        // }
        $auth = Auth::user()->id;
        if (!$request->class_id) {
            Redirect::back()->with('error', 'Kelas Ditemukan');
        }
        $kelas = ClassesModel::where('id', $request->class_id)->where('is_open', 1)->exists();
        if (!$kelas) {
            Redirect::back()->with('error', 'Kelas Sudah Penuh');
        }
        if (!$auth) {
            Redirect::back()->with('error', 'Belum Login');
        }
        if (Auth::user()->role != 2) {
            Redirect::back()->with('error', 'Silahkan Pakai Akun Member');
        }
        if ($auth && Auth::user()->corporate != null) {
            return Redirect::to('profile')->with('error', 'Lengkapi Data Profile Terlebih Dahulu');
        }
        $cpm = ClassPaymentModel::where('user_id', $auth)->where('class_id', $request->class_id)->where('expired', '>=', now())->get();
        if (count($cpm) > 0) {
            $data['data'] = ClassPaymentModel::where('user_id', $request->class_id)->get();
            return Redirect::to('profile')->with('success', 'Kelas Sudah Terdaftar');
        }

        // Unique Code
        $number = ClassPaymentModel::select('unique_code')->where('expired', '<', now())->pluck('unique_code')->toArray();
        do {
            $randomNumber = rand(0, 999);
        } while (in_array($randomNumber, $number));
        // No Invoice
        $numbers = ClassPaymentModel::select('no_invoice')->pluck('no_invoice')->toArray();
        do {
            $no_invoice = uniqid();
        } while (in_array($no_invoice, $numbers));

        $price = 0;
        $price_final = 0;
        $cp = ClassPricingModel::where('class_id', $request->class_id)->first();
        if ($cp) {
            $price = $cp->price;
            $price_final = $price + $randomNumber;
            if ($cp->promo == 1) {
                $price = $cp->price - $cp->promo_price;
                $price_final = $price + $randomNumber;
            }
        }
        // return $price_final;
        ClassPaymentModel::create([
            'status' => 0,
            'user_id' => $auth,
            'class_id' => $request->class_id,
            'unique_code' => $randomNumber,
            'price' => $price,
            'price_final' => $price_final,
            'expired' => date('Y-m-d') . ' 23:59:59',
            'no_invoice' => $no_invoice,
        ]);
        return Redirect::to('profile')->with('success', 'Order Berhasil');
    }
}
