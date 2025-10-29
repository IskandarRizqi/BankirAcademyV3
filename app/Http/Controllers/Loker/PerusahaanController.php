<?php

namespace App\Http\Controllers\Loker;

use App\Http\Controllers\Controller;
use App\Models\LokerModel;
use App\Models\PerusahaanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['data'] = PerusahaanModel::get();
        $data['provinsi'] = DB::table('provinsi')->orderBy('name')->get();
        // return $data;
        return view('backend.loker.perusahaan', $data);
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
            'loker_alamat' => 'required',
            'loker_email' => 'required',
            'loker_nama' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'filClassesImage' => 'required_if:loker_id,==,null',
        ]);
        //response error validation
        if ($valid->fails()) {
            return Redirect::back()->withErrors($valid)->withInput($request->all())->with('error', 'Data Tidak Sesuai');
        }
        if ($request->provinsi == 'Pilih') {
            return Redirect::back()->withErrors($valid)->withInput($request->all())->with('error', 'Provinsi Wajib Isi');
        }
        if ($request->kabupaten == 'Pilih') {
            return Redirect::back()->withErrors($valid)->withInput($request->all())->with('error', 'Kabupaten Wajib Isi');
        }
        if ($request->kecamatan == 'Pilih') {
            return Redirect::back()->withErrors($valid)->withInput($request->all())->with('error', 'Kecamatan Wajib Isi');
        }
        if ($request->kelurahan == 'Pilih') {
            return Redirect::back()->withErrors($valid)->withInput($request->all())->with('error', 'Kelurahan Wajib Isi');
        }
        $data = [
            'alamat' => $request->loker_alamat,
            'email' => $request->loker_email,
            'nama' => $request->loker_nama,
            'title' => $request->loker_title,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
        ];
        if ($request->filClassesImage) {
            $namemeta_image = $request->file('filClassesImage')->getClientOriginalName();
            $sizemeta_image = $request->file('filClassesImage')->getSize();
            if ($sizemeta_image >= 1048576) {
                return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB');
            }
            $filename2 = time() . '-' . $namemeta_image;
            $file = $request->file('filClassesImage');
            $file->move(public_path('image/loker'), $filename2);
            $data['image'] = json_encode([
                'url' => $filename2,
                'size' => $sizemeta_image
            ]);
        }

        $p = PerusahaanModel::updateOrCreate(['id' => $request->loker_id], $data);
        if ($p) {
            return Redirect::back()->with('success', 'Data Tersimpan');
        }
        return Redirect::back()->with('info', 'Data Gagal Tersimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return PerusahaanModel::where('id', $id)->first();
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
    public function destroy($id)
    {
        if (!$this->checkAuth()) {
            return Redirect::back()->with('info', 'Silahkan Login Dahulu');
        }
        $l = PerusahaanModel::where('id', $id)->delete();
        if ($l) {
            return Redirect::back()->with('success', 'Data Terhapus');
        }
        return Redirect::back()->with('info', 'Data Gagal Terhapus');
    }
}
