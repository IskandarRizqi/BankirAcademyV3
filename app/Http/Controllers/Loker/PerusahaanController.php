<?php

namespace App\Http\Controllers\Loker;

use App\Http\Controllers\Controller;
use App\Models\LokerModel;
use App\Models\PerusahaanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['data'] = PerusahaanModel::get();
        $data['provinsi'] = DB::table('provinsi')->orderBy('name')->get();
        // return $data;
        return view('backend.loker.perusahaan', $data);
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
        $isUpdate = $request->filled('loker_id');

        $valid = Validator::make($request->all(), [
            'loker_alamat'    => 'required',
            'loker_email'     => 'required|email',
            'loker_nama'      => 'required',
            'provinsi'        => 'required',
            'kabupaten'       => 'required',
            'kecamatan'       => 'required',
            'kelurahan'       => 'required',
            // Jika buat baru (loker_id kosong), gambar wajib diisi. Jika edit, gambar opsional.
            'filClassesImage' => $isUpdate ? 'nullable|image|mimes:jpeg,png,jpg' : 'required|image|mimes:jpeg,png,jpg',
        ], [
            'required' => ':attribute wajib diisi.',
            'filClassesImage.required' => 'Gambar wajib diunggah untuk data baru.'
        ]);

        if ($valid->fails()) {
            return redirect()->back()
                ->withErrors($valid)
                ->withInput()
                ->with('error', 'Data Tidak Sesuai');
        }

        $data = [
            'alamat'    => $request->loker_alamat,
            'email'     => $request->loker_email,
            'nama'      => $request->loker_nama,
            'title'     => $request->loker_title ?? null,
            'provinsi'  => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
        ];

        if ($request->hasFile('filClassesImage')) {
            $file = $request->file('filClassesImage');

            // 1. Ambil ukuran file SEBELUM dipindahkan dari temp
            $fileSize = $file->getSize();

            // 2. Buat nama file baru
            $filename = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

            // 3. Pindahkan file ke folder tujuan
            $file->move(public_path('image/loker'), $filename);

            // 4. Simpan metadata ke array
            $data['image'] = json_encode([
                'url'  => $filename,
                'size' => $fileSize
            ]);
        }
        $p = PerusahaanModel::updateOrCreate(['id' => $request->loker_id], $data);

        if ($p) {
            return redirect()->back()->with('success', 'Data Tersimpan');
        }

        return redirect()->back()->with('error', 'Data Gagal Tersimpan');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return PerusahaanModel::where('id', $id)->first();
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
        // if (!$this->checkAuth()) {
        //     return Redirect::back()->with('info', 'Silahkan Login Dahulu');
        // }
        $l = PerusahaanModel::where('id', $id)->delete();
        if ($l) {
            return Redirect::back()->with('success', 'Data Terhapus');
        }
        return Redirect::back()->with('info', 'Data Gagal Terhapus');
    }
}
