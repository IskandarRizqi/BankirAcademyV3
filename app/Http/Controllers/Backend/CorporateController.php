<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CorporateModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CorporateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $x = [];
        $x['data'] = CorporateModel::get();
        $x['lokasi'] = CorporateModel::select('lokasi')->pluck('lokasi')->toArray();
        return view('backend.corporate.corporate', $x);
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
            'nama' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
            'lokasi' => 'required',
        ]);
        //response error validation
        if ($valid->fails()) {
            return Redirect::back()->withErrors($valid)->withInput($request->all());
        }

        $u = CorporateModel::updateOrCreate([
            'id' => $request->id
        ], [
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'lokasi' => $request->lokasi,
        ]);
        if ($u) {
            return Redirect::back()->with('success', 'Simpan Data Berhasil');
        }
        return Redirect::back()->withErrors($valid)->withInput($request->all())->with('error', 'Simpan Data Gagal');
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
        $u = CorporateModel::where('id', $id)->delete();
        if ($u) {
            return Redirect::back()->with('success', 'Simpan Data Berhasil');
        }
        return Redirect::back()->with('error', 'Simpan Data Gagal');
    }
}
