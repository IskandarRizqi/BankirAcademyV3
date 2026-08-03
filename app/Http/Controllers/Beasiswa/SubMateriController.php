<?php

namespace App\Http\Controllers\Beasiswa;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use App\Models\MateriModel;
use App\Models\SubMateriItemModel;
use App\Models\SubMateriModel;
use Illuminate\Support\Facades\Storage;
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
        // Mengambil data sub_materi beserta items-nya
        $x['data'] = SubMateriModel::with(['materi', 'items'])
            ->orderBy('urutan')
            ->get();

        return view('compact.sub_materi', $x);
    }

   public function store(Request $request)
{
    $materiParent = MateriModel::find($request->id_materi);
    $isUmum = $materiParent && strtolower(trim($materiParent->nama)) == 'umum';

    $rules = [
        'nama' => 'required',
        'keterangan' => 'nullable',
        'id_materi' => 'required',
        'urutan' => 'required',
        'upcoming'=> 'required',
        'tipe_beasiswa' => 'required',
        'masa_aktif' => 'required',
        'harga' => 'required',
        'diskon' => 'required',
        'judul_item' => 'required|array|min:1',
        'judul_item.*' => 'required|string',
        'link_item' => 'required|array|min:1',
        'link_item.*' => 'required|string',
        'tipe_link_item' => 'required|array|min:1',
        'tipe_link_item.*' => 'required|in:0,1',
    ];

    if ($isUmum) {
        $rules['thumbnail'] = 'required|string';
    }

    $valid = Validator::make($request->all(), $rules);

    if ($valid->fails()) {
        return redirect()->back()->with('info', 'Data tidak sesuai, harap cek kembali')->withInput($request->all());
    }

    $i = [
        'nama' => $request->nama,
        'keterangan' => $request->keterangan,
        'id_materi' => $request->id_materi,
        'urutan' => $request->urutan,
        'tipe_beasiswa' => $request->tipe_beasiswa,
        'masa_aktif' => $request->masa_aktif,
        'upcoming'=> $request->upcoming,
        'harga' => $request->harga,
        'diskon' => $request->diskon,
        'harga_final' => $request->harga,
    ];

    if ($request->harga > 0 && $request->diskon > 0) {
        $i['harga_final'] = $request->harga - ($request->harga * ($request->diskon / 100));
    }

    // Assign path gambar jika umum
    if ($isUmum && $request->thumbnail) {
        $i['thumbnail'] = $request->thumbnail;
    }

    $m = SubMateriModel::updateOrCreate(['id' => $request->id], $i);

    // Sync Item Video/PDF
    SubMateriItemModel::where('id_sub_materi', $m->id)->delete();
    foreach ($request->judul_item as $key => $judul) {
        SubMateriItemModel::create([
            'id_sub_materi' => $m->id,
            'judul_item'    => $judul,
            'link_item'     => $request->link_item[$key],
            'tipe_link_item'=> $request->tipe_link_item[$key],
        ]);
    }

    return redirect()->back()->with('info', 'Data berhasil tersimpan');
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
    $subMateri = SubMateriModel::find($id);

    if (!$subMateri) {
        return redirect()->back()->with('info', 'Data tidak ditemukan');
    }

    // Hapus file thumbnail jika ada
    if ($subMateri->thumbnail && file_exists(public_path($subMateri->thumbnail))) {
        @unlink(public_path($subMateri->thumbnail));
    }

    SubMateriItemModel::where('id_sub_materi', $id)->delete();
    $subMateri->delete();

    return redirect()->back()->with('info', 'Data berhasil dihapus');
}

}
