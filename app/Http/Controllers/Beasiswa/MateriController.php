<?php

namespace App\Http\Controllers\Beasiswa;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use App\Models\MateriModel;
use App\Models\Photo;
use App\Models\SubMateriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MateriController extends Controller
{
    public function index()
    {
        $x['kategori'] = KategoriModel::get();
        $x['photos']   = Photo::latest()->get();
        $x['data']     = MateriModel::select()
            ->with('kategori')
            ->get();

        return view('compact.materi', $x);
    }

    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'id_kategori'    => 'required',
            'urutan'         => 'required',
            'nama'           => 'required',
            'harga'          => 'required|numeric|min:0',
            'jumlah_peserta' => 'nullable|integer|min:0',
            'icon'           => 'nullable|string',
            'photo_id'       => 'nullable|exists:photos,id',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->with('info', 'Data tidak sesuai, harap cek kembali')->withInput($request->all());
        }

        $materiLama = MateriModel::find($request->id);
        $namaFileBanner = $materiLama ? $materiLama->banner : null;

        // Ambil path dari tabel Photo jika ada pilihan photo_id
        if ($request->photo_id) {
            $photo = Photo::find($request->photo_id);
            if ($photo) {
                $namaFileBanner = $photo->path;
            }
        }

        $m = MateriModel::updateOrCreate(['id' => $request->id], [
            'id_kategori'    => $request->id_kategori,
            'urutan'         => $request->urutan,
            'nama'           => $request->nama,
            'keterangan'     => $request->keterangan,
            'harga'          => $request->harga,
            'icon'           => $request->icon ?? 'fas fa-graduation-cap',
            'jumlah_peserta' => $request->jumlah_peserta ?? 0,
            'banner'         => $namaFileBanner,
        ]);

        if (!$m) {
            Log::critical('Gagal simpan materi', [$m]);
            return redirect()->back()->with('info', 'Data tidak tersimpan')->withInput($request->all());
        }

        return redirect()->back()->with('info', 'Data tersimpan');
    }

    /**
     * AJAX Endpoint untuk upload cepat ke Album Galeri (Tabel Photo)
     */
    public function uploadQuickPhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $path = $file->store('banner', 'public'); // Simpan ke storage/app/public/banner

            $photo = Photo::create([
                'title'     => pathinfo($originalName, PATHINFO_FILENAME),
                'path'      => $path,
                'file_size' => $file->getSize(),
            ]);

            return response()->json([
                'status'  => 'success',
                'data'    => [
                    'id'    => $photo->id,
                    'title' => $photo->title,
                    'path'  => $photo->path,
                    'url'   => $photo->url,
                ]
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Upload gagal'], 400);
    }
    public function uploadQuickPhotoEbook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $path = $file->store('photos', 'public'); // Simpan ke storage/app/public/banner

            $photo = Photo::create([
                'title'     => pathinfo($originalName, PATHINFO_FILENAME),
                'path'      => $path,
                'file_size' => $file->getSize(),
            ]);

            return response()->json([
                'status'  => 'success',
                'data'    => [
                    'id'    => $photo->id,
                    'title' => $photo->title,
                    'path'  => $photo->path,
                    'url'   => $photo->url,
                ]
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Upload gagal'], 400);
    }
    public function getPhotosList(Request $request)
{
    try {
        // Query ambil data foto diurutkan dari yang terbaru
        $query = Photo::query()->latest();

        // Fitur pencarian server-side (opsional jika dikirim parameter search)
        if ($request->has('q') && !empty($request->q)) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        $photos = $query->get();

        return response()->json([
            'status'  => 'success',
            'data'    => $photos
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Gagal mengambil data foto: ' . $e->getMessage()
        ], 500);
    }
}

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