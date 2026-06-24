<?php

namespace App\Http\Controllers\Beasiswa;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use Illuminate\Http\Request;

class SiswaMateriController extends Controller
{
    /**
     * Menampilkan semua Kategori, Materi, dan list video Sub Materi-nya.
     */
    public function index()
    {
        // Mengambil Kategori -> Materi (urut) -> Sub Materi (urut)
        $data['kategori'] = KategoriModel::with(['materi' => function($query) {
            $query->orderBy('urutan', 'asc');
        }, 'materi.subMateri' => function($query) {
            $query->orderBy('urutan', 'asc');
        }])->get();

        return view('compact.materi-siswa', $data);
    }

    /**
     * Detail per sub materi jika nanti masih dibutuhkan (opsional)
     */
    public function show($id)
    {
        // (Tetap dipertahankan jika Anda ingin mengarah ke halaman play video terpisah)
        return view('compact.detail-materi');
    }
}