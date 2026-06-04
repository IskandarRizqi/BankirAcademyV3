<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MembershipModel;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Terbilang;
use PDF;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['data'] = MembershipModel::get();
        return view('backend.member.member', $data);
    }

    public function cetakinvoicepending($id, Request $request)
    {
        // $data['data'] = MembershipModel::where('id', $id)->first();
        // if (!$data['data']) {
        //     return Redirect::back()->with('info', 'Data Tidak Ditemukan');
        // }
        // $data['terbilang'] = Terbilang::make(3000000, '', 'Rp. ');
        $data['profile'] = UserProfileModel::where('user_id', Auth::user()->id)->first();
        $pdf = PDF::loadView('invoice/membershippending', $data);
        return $pdf->setPaper('a4', 'landscape')->stream('invoice.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'harga' => 'required',
            'nama' => 'required',
            'limit' => 'required',
            'keterangan' => 'required',
            'type' => 'required',
            'nominal' => 'required',
            'lamaran_online' => 'required',
            'lamaran_offline' => 'required',
            'pelatihan_gratis' => 'required',
            'sop_file' => 'nullable|file|mimes:pdf|max:2048', // Batasan opsional maks 2MB
        ]);

        // response error validation
        if ($valid->fails()) {
            return Redirect::back()->withErrors($valid)->withInput($request->all());
        }

        $cvats = 0;
        $cvbankir = 0;
        if ($request->cvats == 1) {
            $cvats = 1;
        }
        if ($request->cvbankir == 1) {
            $cvbankir = 1;
        }

        $inp = [
            'harga' => $request->harga,
            'limit' => $request->limit,
            'nama' => $request->nama,
            'type' => $request->type,
            'nominal' => $request->nominal,
            'cvats' => $cvats,
            'cvbankir' => $cvbankir,
            'lamaran_online' => $request->lamaran_online,
            'lamara_offline' => $request->lamaran_offline,
            'pelatihan_gratis' => $request->pelatihan_gratis,
            'keterangan' => $request->keterangan,
            'is_active' => $request->is_active,
            'urutan' => $request->urutan,
            'video_kursus' => $request->video_kursus,
        ];

        // Handle Picture Upload (Tetap menggunakan File System)
        if ($request->picture) {
            $name = $request->file('picture')->getClientOriginalName();
            $size = $request->file('picture')->getSize();

            if ($size >= 1048576) {
                return Redirect::back()->with('error', 'Ukuran File Gambar Melebihi 1 MB');
            }

            $filename = time() . '-' . $name;
            $file = $request->file('picture');
            $file->move(public_path('Image/Members'), $filename);
            $inp['gambar'] = 'Image/Members/' . $filename;
        }

        // --- FITUR BARU: Konversi File SOP Ke Base64 ---
        if ($request->hasFile('sop_file')) {
            $fileSop = $request->file('sop_file');

            // Membaca file dan encode ke Base64
            $fileData = file_get_contents($fileSop->getRealPath());
            $base64Data = base64_encode($fileData);

            // Membuat format Data URI Scheme agar bisa langsung dibuka di browser
            $inp['sop_file'] = 'data:application/pdf;base64,' . $base64Data;
        }

        $i = MembershipModel::updateOrCreate(['id' => $request->id], $inp);

        if ($i) {
            return Redirect::back()->with('success', 'Sudah Tersimpan');
        }

        return Redirect::back()->with('error', 'Gagal menyimpan data')->withInput($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletes(Request $request)
    {
        $m = MembershipModel::where('id', $request->idmember)->delete();
        if ($m) {
            return Redirect::back()->with('success', 'Data Terhapus');
        }
        return Redirect::back()->with('error', 'Data Tidak Terhapus');
    }
    public function destroy($id)
    {
        //
    }
}
