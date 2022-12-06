<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MasterRefferralModel;
use App\Models\RefferralModel;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class RefferalController extends Controller
{
    public function setMasterRefferal(Request $request)
    {
        $up = UserProfileModel::where('user_id', Auth::user()->id)->first();
        if (!$up) {
            return Redirect::back()->with('error', 'Harap Lengkapi Data Terlebih Dahulu');
        }
        $valid = Validator::make($request->all(), [
            'kode' => 'required',
            'url' => 'required',
        ]);
        //response error validation
        if ($valid->fails()) {
            return Redirect::back()->withErrors($valid)->withInput($request->all());
        }

        $k = MasterRefferralModel::where('code', $request->kode)->where('id', '!==', $request->id)->get();
        $u = MasterRefferralModel::where('url', $request->url)->where('id', '!==', $request->id)->get();
        if (count($k) > 0) {
            return Redirect::back()->with('error', 'Kode Sudah Terpakai')->withInput($request->all());
        }
        if (count($u) > 0) {
            return Redirect::back()->with('error', 'URL Sudah Terpakai')->withInput($request->all());
        }

        $m = MasterRefferralModel::updateOrCreate([
            'id' => $request->id
        ], [
            'user_id' => Auth::user()->id,
            'code' => $request->kode,
            'url' => preg_replace('/[^a-zA-Z0-9_ -]/s', '-', str_replace(' ', '-', $request->url)),
        ]);
        if ($m) {
            return Redirect::back()->with('success', 'Simpan Data Berhasil');
        }
        return Redirect::back()->with('error', 'Simpan Data Gagal');
    }

    public function joinRef($uri)
    {
        $k = MasterRefferralModel::where('code', $uri)->first();
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
        $s = MasterRefferralModel::where('code', $uri)->where('user_id', $auth->id)->first();
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
