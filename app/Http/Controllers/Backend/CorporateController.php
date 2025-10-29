<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Imports\CorporateImport;
use App\Models\CorporateModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

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
        $lokasi = CorporateModel::select('lokasi')->pluck('lokasi')->toArray();
        // $tags = ClassesModel::select('tags')->distinct('tags')->pluck('tags')->toArray();
        $x['lokasi'] = [];
        foreach ($lokasi as $key => $value) {
            if (!in_array($value, $x['lokasi'])) {
                array_push($x['lokasi'], $value);
            }
        }
        // return $x;
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
            'jenis_corporate' => 'required',
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
            'jenis' => $request->jenis_corporate,
        ]);
        if ($u) {
            return Redirect::back()->with('success', 'Simpan Data Berhasil');
        }
        return Redirect::back()->withErrors($valid)->withInput($request->all())->with('error', 'Simpan Data Gagal');
    }

    public function download()
    {
        //PDF file is stored under project/public/download/info.pdf
        $file = public_path() . "/download/importcorporate.xlsx";

        $headers = array(
            'Content-Type: application/pdf',
        );

        return response()->download($file, 'template-corporate.xlsx', $headers);
    }

    public function importcorporate(Request $request)
    {
        // return $request->all();
        if ($request->excel) {
            Excel::import(new CorporateImport, $request->excel);
            return Redirect::back()->with('success', 'Import Berhasil');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($id) {
            return CorporateModel::where('jenis', $id)->get();
        }
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
