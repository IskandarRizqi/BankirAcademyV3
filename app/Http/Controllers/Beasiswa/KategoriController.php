<?php

namespace App\Http\Controllers\Beasiswa;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use App\Models\MateriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $x['data'] = KategoriModel::get();
        return view('compact.kategori', $x);
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
        $v = Validator::make($request->all(), [
            'nama' => 'required'
        ]);

        if ($v->fails()) {
            return redirect()->back()->withInput()->with('error', 'data tidak sesuai');
        }

        $i = KategoriModel::updateOrCreate(['id' => $request->id], ['nama' => $request->nama]);

        if (!$i) {
            Log::critical('tidak bisa simpan kategori', [$i]);
            return redirect()->back()->withInput()->with('error', 'data tidak tersimpan');
        }

        // log activity
        return redirect()->back()->withInput()->with('error', 'data tersimpan');
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
            $m = MateriModel::where('id_kategori', $id)->first();
            if ($m) {
                return redirect()->back()->withInput()->with('info', 'data kategori masih digunakan oleh materi: ' . $m->nama);
            }
            $i = KategoriModel::where('id', $id)->delete();
            if (!$i) {
                Log::critical('tidak bisa hapus kategori', [$i]);
                return redirect()->back()->withInput()->with('info', 'data tidak terhapus');
            }
            return redirect()->back()->withInput()->with('success', 'data terhapus');
        }
    }
}
