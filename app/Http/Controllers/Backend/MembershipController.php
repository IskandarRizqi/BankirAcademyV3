<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MembershipModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

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
            'lamaran_online' => 'required',
            'lamaran_offline' => 'required',
            'pelatihan_gratis' => 'required',
        ]);
        //response error validation
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
        if ($request->picture) {
            $name = $request->file('picture')->getClientOriginalName(); // Name File
            $size = $request->file('picture')->getSize(); // Size File

            if ($size >= 1048576) {
                return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB');
            }

            $filename = time() . '-' . $name;
            $file = $request->file('picture');
            $file->move(public_path('Image/Members'), $filename);
            $inp['gambar'] = 'Image/Members/' . $filename;
        }
        $i = MembershipModel::updateOrCreate(['id' => $request->id], $inp);
        if ($i) {
            return Redirect::back()->with('success', 'Sudah Tersimpan');
        }
        return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB')->withInput($request->all());
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
