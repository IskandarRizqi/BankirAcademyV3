<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\LokerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class LokerController extends Controller
{
    public function index(Request $request)
    {
    }

    public function store(Request $request)
    {
        // return $request->all();
        $c = json_decode(Auth::user()->corporate);
        if (!$c) {
            return Redirect::back()->withInput($request->all())->with('error', 'Data Corporate Tidak Sesuai');
        }
        $valid = Validator::make($request->all(), [
            'loker_title' => 'required',
            'loker_gaji_min' => 'required',
            'loker_deskripsi' => 'required',
            'loker_jobdesk' => 'required',
            'loker_tanggal_awal' => 'required',
            'loker_tanggal_akhir' => 'required',
            'loker_skill' => 'required',
            'loker_type' => 'required',
        ]);
        //response error validation
        if ($valid->fails()) {
            return Redirect::back()->withErrors($valid)->withInput($request->all())->with('error', 'Data Tidak Sesuai');
        }
        $data = [
            'user_id' => Auth::user()->id,
            'title' => $request->loker_title,
            'perusahaan_user' => json_decode(Auth::user()->corporate)->id_corporate,
            'gaji_min' => $request->loker_gaji_min,
            'gaji_max' => 0,
            'deskripsi' => $request->loker_deskripsi,
            'jobdesk' => $request->loker_jobdesk,
            'tanggal_awal' => $request->loker_tanggal_awal,
            'tanggal_akhir' => $request->loker_tanggal_akhir,
            'skill' => json_encode($request->loker_skill),
            'type' => json_encode($request->loker_type),
        ];

        $l = LokerModel::updateOrCreate([
            'id' => $request->loker_id,
        ], $data);
        if ($l) {
            return Redirect::back()->with('success', 'Data Tersimpan');
        }
        return Redirect::back()->with('info', 'Data Gagal Tersimpan');
    }
}
