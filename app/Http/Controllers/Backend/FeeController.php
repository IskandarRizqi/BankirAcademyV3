<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ClassesModel;
use App\Models\FeeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FeeController extends Controller
{
    public function index()
    {
        $data = [];
        $data['kelas'] = ClassesModel::select('title')->get();
        $data['fee'] = FeeModel::get();
        return view('backend.fee.fee', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // return $request->all();
        if (!$request->id && !$request->class_id) {
            $fe = FeeModel::where('class_id', 'null')->get();
            if (count($fe) > 0) {
                return Redirect::back()->with('message', 'Data Sudah Tersedia');
            }
        }
        $f = FeeModel::updateOrCreate([
            'id' => $request->id
        ], [
            'class_id' => json_encode($request->kelas),
            'nominal' => $request->nominal
        ]);
        if ($f) {
            return Redirect::back()->with('success', 'Simpan Data Berhasil');
        }
        return Redirect::back()->with('error', 'Simpan Data Gagal');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id, Request $request)
    {
        if ($request->id_fee) {
            $f = FeeModel::where('id', $request->id_fee)->delete();
            if ($f) {
                return Redirect::back()->with('success', 'Hapus Data Berhasil');
            }
            return Redirect::back()->with('error', 'Hapus Data Gagal');
        }
        return Redirect::back()->with('error', 'Hapus Data Gagal');
    }
}
