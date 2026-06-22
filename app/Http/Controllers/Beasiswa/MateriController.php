<?php

namespace App\Http\Controllers\Beasiswa;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use App\Models\MateriModel;
use App\Models\SubMateriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $x['kategori'] = KategoriModel::get();
        $x['data'] = MateriModel::select()
            ->with('kategori')
            ->get();
        // return $x['data'];
        return view('compact.materi', $x);
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
            'id_kategori' => 'required',
            'urutan' => 'required',
            'nama' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->with('info', 'data tidak sesuai, harap cek kembali')->withInput($request->all());
        }

        $m = MateriModel::updateOrCreate(['id' => $request->id], [
            'id_kategori' => $request->id_kategori,
            'urutan' => $request->urutan,
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
        ]);

        if (!$m) {
            Log::critical('gagal simpan materi', [$m]);
            return redirect()->back()->with('info', 'data tidak tersimpan')->withInput($request->all());
        }
        return redirect()->back()->with('info', 'data tersimpan');
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
        if ($id) {
            $m = SubMateriModel::where('id_materi', $id)->first();
            if ($m) {
                return redirect()->back()->withInput()->with('info', 'data materi masih digunakan oleh sub materi: ' . $m->nama);
            }
            $i = MateriModel::where('id', $id)->delete();
            if (!$i) {
                Log::critical('tidak bisa hapus materi', [$i]);
                return redirect()->back()->withInput()->with('info', 'data tidak terhapus');
            }
            return redirect()->back()->withInput()->with('success', 'data terhapus');
        }
    }
}
