<?php

namespace App\Http\Controllers\Beasiswa;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use App\Models\MateriModel;
use App\Models\SubMateriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SubMateriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $x['materi'] = MateriModel::get();
        $x['data'] = SubMateriModel::select()
            ->with('materi')
            ->orderBy('urutan')
            ->get();
        // return $x['data'];
        return view('compact.sub_materi', $x);
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
            'link' => 'required',
            'keterangan' => 'nullable',
            'id_materi' => 'required',
            'urutan' => 'required',
            'tipe_link' => 'required',
            'tipe_beasiswa' => 'required',
            'masa_aktif' => 'required',
            'harga' => 'required',
            'diskon' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->with('info', 'data tidak sesuai, harap cek kembali')->withInput($request->all());
        }

        $i = [
            'nama' => $request->nama,
            'link' => $request->link,
            'keterangan' => $request->keterangan,
            'id_materi' => $request->id_materi,
            'urutan' => $request->urutan,
            'tipe_link' => $request->tipe_link,
            'tipe_beasiswa' => $request->tipe_beasiswa,
            'masa_aktif' => $request->masa_aktif,
            'harga' => $request->harga,
            'diskon' => $request->diskon,
            'harga_final' => $request->harga,
        ];

        if ($request->harga > 0 && $request->diskon > 0) {
            $i['harga_final'] = $request->harga - ($request->harga * ($request->diskon / 100));
        }

        $m = SubMateriModel::updateOrCreate(['id' => $request->id], $i);

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
        $x['kategori'] = KategoriModel::select()
            ->with([
                'materi.subMateri' => function ($q) {
                    // $q->where('tipe_beasiswa', 0)->orWhere('tipe_beasiswa', 1);
                    // $q->where('tipe_beasiswa', 0)->orWhere('tipe_beasiswa', 2);
                }
            ])
            ->get();

        return $x;
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
        //
    }
}
