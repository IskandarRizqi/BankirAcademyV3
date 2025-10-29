<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ClassesModel;
use App\Models\KodePromoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['promo'] = KodePromoModel::get();
        $data['kelas'] = ClassesModel::select('title')->get();
        return view('backend.promo.promo', $data);
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
        // return $request->all();
        $valid = Validator::make($request->all(), [
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
            'kode' => 'required',
            'nominal' => 'required',
            'kelas' => 'required',
        ]);
        //response error validation
        if ($valid->fails()) {
            return Redirect::back()->withErrors($valid)->withInput($request->all());
        }

        $kode = KodePromoModel::where('kode', $request->kode)->where('id', '!=', $request->id)->first();
        if ($kode) {
            return Redirect::back()->withInput($request->all())->with('error', 'Kode Sudah Tersedia');
        }

        $data = [
            'kode' => $request->kode,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'nominal' => $request->nominal,
            'class_title' => json_encode($request->kelas),
        ];

        // Data
        if ($request->image) {
            $nameimage = $request->file('image')->getClientOriginalName();
            $sizeimage = $request->file('image')->getSize();
            if ($sizeimage >= 1048576) {
                return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB');
            }
            $filename1 = time() . '-' . $nameimage;
            $file = $request->file('image');
            $file->move(public_path('image/promo/image'), $filename1);
            $data['image'] = json_encode(['url' => $filename1, 'size' => $sizeimage]);
        }

        // return json_decode($data['image']);
        $p = KodePromoModel::updateOrCreate([
            'id' => $request->id
        ], $data);
        if ($p) {
            return Redirect::back()->with('success', 'Data Berhasil Tersimpan');
        }
        return Redirect::back()->with('error', 'Data Gagal Tersimpan');
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
    public function destroy($id)
    {
        $p = KodePromoModel::where('id', $id)->delete();
        if ($p) {
            return Redirect::back()->with('success', 'Data Berhasil Tersimpan');
        }
        return Redirect::back()->with('error', 'Data Gagal Tersimpan');
    }
}
