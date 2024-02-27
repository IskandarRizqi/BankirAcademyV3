<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MasterRefferralModel;
use App\Models\RefferralPesertaModelModel;
use App\Models\RefferralModel;
use App\Models\RefferralPesertaModel;
use App\Models\User;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class RefferalController extends Controller
{
    public function dashboard()
    {
        $data = [];
        $data['data'] = User::select('users.*', 'refferral_peserta.code', 'refferral_peserta.url')
            ->leftJoin('refferral_peserta', 'refferral_peserta.user_id', 'users.id')
            ->where('users.role', 2)
            ->get();
        foreach ($data['data'] as $key => $v) {
            $v->aplicator = RefferralModel::select()
                ->where('user_id', $v->id)
                ->get();
        }
        // return $data;
        return view('backend.referral.dashboard', $data);
    }
    public function masterReff()
    {
        $data = [];
        $data['data'] = MasterRefferralModel::get();
        return view('backend.referral.masteradmin', $data);
    }
    public function storeMasterReff(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'nominal' => 'required',
            'potongan_harga' => 'required',
        ]);
        //response error validation
        if ($valid->fails()) {
            return Redirect::back()->withErrors($valid)->withInput($request->all())->with('error', 'Data Tidak Sesuai');
        }
        $mr = MasterRefferralModel::updateOrCreate([
            'id' => $request->id
        ], [
            'nominal' => $request->nominal,
            'potongan_harga' => $request->potongan_harga,
        ]);
        if ($mr) {
            return Redirect::back()->with('success', 'Simpan Data Berhasil');
        }
        return Redirect::back()->with('error', 'Simpan Data Gagal');
    }
    public function delMasterReff($id)
    {
        $mr = MasterRefferralModel::where('id', $id)->delete();
        if ($mr) {
            return Redirect::back()->with('success', 'Hapus Data Berhasil');
        }
        return Redirect::back()->with('error', 'Hapus Data Gagal');
    }
    public function setMasterRefferal(Request $request)
    {
        $up = UserProfileModel::where('user_id', Auth::user()->id)->first();
        if (!$up) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Harap Lengkapi Data Profile Terlebih Dahulu',
                ]);
            }
            return Redirect::back()->with('error', 'Harap Lengkapi Data Profile Terlebih Dahulu');
        }
        $valid = Validator::make($request->all(), [
            'kode' => 'required',
            'url' => 'required',
        ]);
        //response error validation
        if ($valid->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Tidak Sesuai',
                ]);
            }
            return Redirect::back()->withErrors($valid)->withInput($request->all());
        }

        $k = RefferralPesertaModel::where('code', $request->kode)->where('id', '!==', $request->id)->get();
        $u = RefferralPesertaModel::where('url', $request->url)->where('id', '!==', $request->id)->get();
        if (count($k) > 0) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode Refferal Sudah Terpakai',
                ]);
            }
            return Redirect::back()->with('error', 'Kode Sudah Terpakai')->withInput($request->all());
        }
        if (count($u) > 0) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'URL Sudah Terpakai',
                ]);
            }
            return Redirect::back()->with('error', 'URL Sudah Terpakai')->withInput($request->all());
        }

        $m = RefferralPesertaModel::updateOrCreate([
            'id' => $request->id
        ], [
            'user_id' => Auth::user()->id,
            'code' => $request->kode,
            'url' => preg_replace('/[^a-zA-Z0-9_ -]/s', '-', str_replace(' ', '-', $request->url)),
        ]);
        if ($m) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Simpan Data Berhasil',
                ]);
            }
            return Redirect::back()->with('success', 'Simpan Data Berhasil');
        }
        return Redirect::back()->with('error', 'Simpan Data Gagal');
    }

    public function joinRefAjax($id, $kode)
    {
        $k = RefferralPesertaModel::where('code', $kode)->first();
        if (!$k) {
            return response()->json([
                'status' => 400,
                'message' => 'Kode Referral Tidak Ditemukan',
                'response' => 'error',
            ]);
        }
        $auth = Auth::user();
        if (!$auth) {
            return response()->json([
                'status' => 400,
                'message' => 'Anda Belum Login',
                'response' => 'error',
            ]);
        }
        if ($auth->role !== 2) {
            return response()->json([
                'status' => 400,
                'message' => 'Kode Referral Hanya Untuk Member',
                'response' => 'error',
            ]);
        }
        $o = RefferralModel::where('code', $kode)->where('user_aplicator', $auth->id)->first();
        if ($o) {
            return response()->json([
                'status' => 400,
                'message' => 'Kode Referral Sudah Terpakai',
                'response' => 'error',
            ]);
        }
        $s = RefferralPesertaModel::where('code', $kode)->where('user_id', $auth->id)->first();
        if ($s) {
            return response()->json([
                'status' => 400,
                'message' => 'Kode Referral Punya Sendiri',
                'response' => 'error',
            ]);
        }

        $r = RefferralModel::create([
            'user_id' => $k->user_id,
            'user_aplicator' => $auth->id,
            'code' => $kode,
            'url' => null,
        ]);
        if ($r) {
            return response()->json([
                'status' => 200,
                'message' => 'Kode Referral Tersimpan',
                'response' => 'success',
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => 'Kode Referral Gagal Simpan',
            'response' => 'error',
        ]);
    }

    public function joinRef($uri)
    {
        $k = RefferralPesertaModel::where('code', $uri)->first();
        if (!$k) {
            return Redirect::to('/')->with('error', 'Kode Referral Tidak Ditemukan');
        }
        $auth = Auth::user();
        if (!$auth) {
            return Redirect::to('/')->with('error', 'Anda Belum Login');
        }
        if ($auth->role !== 2) {
            return Redirect::to('/')->with('error', 'Kode Referral Hanya Untuk Member');
        }
        $o = RefferralModel::where('code', $uri)->where('user_aplicator', $auth->id)->first();
        if ($o) {
            return Redirect::to('/')->with('error', 'Kode Referral Sudah Terpakai');
        }
        $s = RefferralPesertaModel::where('code', $uri)->where('user_id', $auth->id)->first();
        if ($s) {
            return Redirect::to('/')->with('error', 'Kode Referral Punya Sendiri');
        }

        $r = RefferralModel::create([
            'user_id' => $k->user_id,
            'user_aplicator' => $auth->id,
            'code' => $uri,
            'url' => null,
        ]);
        if ($r) {
            return Redirect::to('/profile')->with('error', 'Kode Referral Tersimpan');
        }
        return Redirect::to('/')->with('error', 'Kode Referral Gagal Simpan');
    }
}
