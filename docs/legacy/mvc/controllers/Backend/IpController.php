<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AllowIpAksesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class IpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['data'] = AllowIpAksesModel::get();
        return view('backend.ipakses.index', $data);
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
            'nama' => 'required',
            'ipaddress' => 'required',
        ]);
        //response error validation
        if ($valid->fails()) {
            return Redirect::back()->withErrors($valid)->withInput($request->all())->with('error', 'Data Tidak Tersimpan');;
        }

        $a = AllowIpAksesModel::updateOrCreate(['id' => $request->id], [
            'nama' => $request->nama,
            'ip' => $request->ipaddress
        ]);
        if ($a) {
            return Redirect::back()->with('success', 'Data Tersimpan');
        }
        return Redirect::back()->withErrors($valid)->withInput($request->all())->with('error', 'Data Tidak Tersimpan');
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
    public function destroy($id, Request $r)
    {
        $a = AllowIpAksesModel::where('id', $r->id_ip)->delete();
        if ($a) {
            return Redirect::back()->with('success', 'Data Terhapus');
        }
        return Redirect::back()->with('error', 'Data Tidak Terhapus');
    }
}
