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
    // 1. Cek terlebih dahulu nama kompetensi dari id_materi
    $materiParent = MateriModel::find($request->id_materi);
    $isUmum = $materiParent && strtolower(trim($materiParent->nama)) == 'umum';

    // 2. Susun Aturan Validasi
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

    // Jika Kompetensi "Umum", validasi file thumbnail
    if ($isUmum) {
        // Jika mode simpan baru (bukan edit), thumbnail wajib diisi
        $rules['thumbnail'] = $request->id ? 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048' : 'required|image|mimes:jpeg,png,jpg,webp|max:2048';
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

    // 3. Proses Upload Thumbnail Jika Kompetensi "Umum"
    if ($isUmum && $request->hasFile('thumbnail')) {
        // Hapus thumbnail lama jika ada (Mode Edit)
        if ($request->id) {
            $oldData = SubMateriModel::find($request->id);
            if ($oldData && $oldData->thumbnail && file_exists(public_path($oldData->thumbnail))) {
                @unlink(public_path($oldData->thumbnail));
            }
        }

        $file = $request->file('thumbnail');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Simpan file ke folder 'uploads/thumbnails' di directory public
        $file->move(public_path('uploads/thumbnails'), $filename);
        $i['thumbnail'] = 'uploads/thumbnails/' . $filename;
    }

    // Simpan / Update SubMateri
    $m = SubMateriModel::updateOrCreate(['id' => $request->id], $i);

    if (!$m) {
        Log::critical('gagal simpan materi', [$m]);
        return redirect()->back()->with('info', 'data tidak tersimpan')->withInput($request->all());
    }

    // PROSES MULTI-ITEM VIDEO / PDF
    SubMateriItemModel::where('id_sub_materi', $m->id)->delete();

    foreach ($request->judul_item as $key => $judul) {
        SubMateriItemModel::create([
            'id_sub_materi' => $m->id,
            'judul_item'    => $judul,
            'link_item'     => $request->link_item[$key],
            'tipe_link_item'=> $request->tipe_link_item[$key],
        ]);
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
