<?php

namespace App\Http\Controllers\Beasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriModel;
use App\Models\MateriModel;
use App\Models\SubMateriModel;
use App\Models\PrepotesUserModel; // Model progress/test user
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SiswaMateriController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Cari tahu apakah user ini sudah pernah mengambil/mengunci 1 modul tertentu
        $modulTerkunci = PrepotesUserModel::where('user_id', $userId)->first();

        $kategori = KategoriModel::with(['materi' => function($query) {
            $query->orderBy('urutan', 'asc');
        }, 'materi.subMateri'])->get();

        return view('compact.materi-siswa', compact('kategori', 'modulTerkunci'));
    }

    public function belajar(Request $request, $materi_id, $sub_materi_id = null)
    {
        $userId = Auth::id();

        // RULE 1: Setiap siswa hanya boleh mengakses 1 modul pelatihan
        $cekModulLain = PrepotesUserModel::where('user_id', $userId)
            ->where('class_id', '!=', $materi_id)
            ->exists();

        if ($cekModulLain) {
            $modulAktif = PrepotesUserModel::where('user_id', $userId)->first();
            return redirect()->route('siswa.materi.belajar', [$modulAktif->class_id])
                ->with('error', 'Anda hanya diperbolehkan mengikuti 1 modul pelatihan!');
        }

        // Ambil data materi
        $materiAktif = MateriModel::with(['subMateri' => function($query) {
            $query->orderBy('urutan', 'asc');
        }, 'kategori', 'preposttest'])->findOrFail($materi_id);

        $preTest = $materiAktif->preposttest->where('tipe_prepost', 0)->first();
        $postTest = $materiAktif->preposttest->where('tipe_prepost', 1)->first();

        // Cek status test user di database
        $userProgress = PrepotesUserModel::where('class_id', $materi_id)
            ->where('user_id', $userId)
            ->first();

        $contentType = $request->query('type', 'materi');
        $subMateriAktif = null;
        $embedUrl = null;
        $quizAktif = null;

        // RULE 2: Wajib Pre-test jika ada
        $sudahPreTest = $userProgress && !is_null($userProgress->nilai_awal);
        if ($preTest && !$sudahPreTest) {
            // Paksa content type jadi 'pre' jika belum pretest
            $contentType = 'pre';
        }

        if ($contentType === 'pre' && $preTest) {
            $quizAktif = $preTest;
            if (is_string($quizAktif->soal)) {
                $quizAktif->soal = json_decode($quizAktif->soal, true);
            }
        } elseif ($contentType === 'post' && $postTest) {
            // RULE 3 Tambahan: Tidak bisa post test sebelum semua materi beres (opsional tapi ideal)
            $quizAktif = $postTest;
            if (is_string($quizAktif->soal)) {
                $quizAktif->soal = json_decode($quizAktif->soal, true);
            }
        } else {
            $contentType = 'materi';
            
            // Ambil daftar ID sub materi untuk validasi urutan
            $listSubMateri = $materiAktif->subMateri;
            
            if ($sub_materi_id) {
                $subMateriAktif = SubMateriModel::findOrFail($sub_materi_id);
            } else {
                $subMateriAktif = $listSubMateri->first();
            }

            // RULE 3: Materi berurutan tidak bisa loncat bab
            // Kita cek materi-materi yang urutannya lebih kecil dari materi aktif saat ini
            if ($subMateriAktif) {
                $materiSebelumnya = $listSubMateri->where('urutan', '<', $subMateriAktif->urutan);
                
                // Asumsi: Kita simpan progress sub_materi yang sudah dibaca ke dalam session/array database.
                // Sebagai alternatif paling mudah tanpa buat tabel baru, kita validasi via Session dulu untuk progress bacanya.
                $openedLessons = session()->get("materi_progress_{$materi_id}", []);
                
                // Selalu buka materi pertama
                if ($listSubMateri->first() && $subMateriAktif->id !== $listSubMateri->first()->id) {
                    foreach ($materiSebelumnya as $prev) {
                        if (!in_array($prev->id, $openedLessons)) {
                            // Jika ada bab sebelumnya yang belum pernah dibuka, lempar ke materi pertama yang belum diselesaikan
                            return redirect()->route('siswa.materi.belajar', [$materi_id, $prev->id])
                                ->with('info', 'Anda harus mempelajari materi ini secara berurutan.');
                        }
                    }
                }

                // Masukkan materi saat ini ke dalam history progress bahwa sudah diakses
                if (!in_array($subMateriAktif->id, $openedLessons)) {
                    $openedLessons[] = $subMateriAktif->id;
                    session()->put("materi_progress_{$materi_id}", $openedLessons);
                }
            }

            if ($subMateriAktif && $subMateriAktif->tipe_link == 0) {
                $embedUrl = $this->parseYoutubeCode($subMateriAktif->link);
            }
        }

        return view('compact.belajar', compact(
            'materiAktif', 
            'subMateriAktif', 
            'embedUrl', 
            'preTest', 
            'postTest', 
            'contentType', 
            'quizAktif',
            'userProgress'
        ));
    }

public function savejawaban(Request $request, $materi_id, $quiz_id)
{
    $userId = Auth::user()->id;

    // 1. Ambil data kuis/test dari database berdasarkan id
    $quiz = DB::table('preposttest')->where('id', $quiz_id)->first();
    if (!$quiz) {
        return redirect()->back()->with('error', 'Data ujian tidak ditemukan.');
    }

    // 2. Cek riwayat pengerjaan user sebelumnya
    $pr = PrepotesUserModel::where('class_id', $materi_id)->where('user_id', $userId)->first();
    
    if ($pr) {
        if ($quiz->tipe_prepost == 0) {
            // JIKA PRE-TEST: Cek apakah nilai_awal sudah pernah diisi (tidak boleh diisi ulang sama sekali!)
            if (!is_null($pr->nilai_awal)) {
                return redirect()->route('siswa.materi.belajar', [$materi_id])
                    ->with('error', 'Anda sudah mengikuti Pre-test sebelumnya. Pre-test hanya dapat diikuti 1 kali.');
            }
        } else {
            // JIKA POST-TEST: Cek apakah sudah lulus (nilai_akhir >= 70)
            if (!is_null($pr->nilai_akhir) && $pr->nilai_akhir >= 70) {
                return redirect()->route('siswa.materi.belajar', [$materi_id])
                    ->with('error', 'Anda sudah lulus Post-test ini dengan nilai ' . $pr->nilai_akhir . '. Tidak dapat mengisi kembali.');
            }
        }
    }

    // 3. Pastikan data soal didecode sampai menjadi ARRAY murni
    $daftarSoal = $quiz->soal;
    while (is_string($daftarSoal)) {
        $daftarSoal = json_decode($daftarSoal, true);
    }

    // Validasi akhir: jika gagal jadi array, hentikan proses agar tidak error
    if (!is_array($daftarSoal)) {
        return redirect()->back()->with('error', 'Gagal memproses format soal di database.');
    }

    $jawabanBenarCount = 0;
    $totalSoal = count($daftarSoal);

    // Ambil input jawaban dari request user
    $jawabanUserArray = $request->input('jawaban', []);

    if ($totalSoal > 0 && !empty($jawabanUserArray)) {
        // Paksa array menjadi sekuensial murni (0, 1, 2...) untuk menjamin ketepatan index
        $jawabanUserTerurut = array_values($jawabanUserArray); 

        foreach ($daftarSoal as $index => $soal) {
            $kunciBenar = $soal['jawaban'] ?? null;
            $jawabanUser = $jawabanUserTerurut[$index] ?? null;

            if (!is_null($jawabanUser) && !is_null($kunciBenar)) {
                if (strtoupper(trim($jawabanUser)) === strtoupper(trim($kunciBenar))) {
                    $jawabanBenarCount++;
                }
            }
        }
        // Hitung nilai final skala 100
        $nilai_final = ($jawabanBenarCount / $totalSoal) * 100;
    } else {
        $nilai_final = 0;
    }

    // 4. Siapkan data update atau create
    // Simpan jawaban baru. Jika post-test, Anda bisa menggabungkan history atau menimpanya sesuai kebutuhan bisnis Anda.
    $data = [
        'jawaban' => json_encode(array_values($jawabanUserArray)), 
        'jml_jawaban' => $pr ? ($pr->jml_jawaban + 1) : 1,
    ];

    // Tentukan kolom nilai & alur redirect berdasarkan tipe test
    if ($quiz->tipe_prepost == 0) {
        $data['nilai_awal'] = $nilai_final;
        
        // Simpan/Update (Akan mengisi field nilai_awal tanpa merusak kolom nilai_akhir)
        PrepotesUserModel::updateOrCreate([
            'class_id' => $materi_id,
            'user_id' => $userId,
        ], $data);

        // Pre-test TIDAK ADA REMEDIAL, berapapun nilainya langsung arahkan ke materi pelajaran pertama
        return redirect()->route('siswa.materi.belajar', [$materi_id])
            ->with('success', 'Pre-test selesai! Nilai Anda: ' . $nilai_final . '. Silakan lanjutkan ke materi pelajaran.');
            
    } else {
        $data['nilai_akhir'] = $nilai_final;

        // Simpan/Update (Akan mengisi field nilai_akhir tanpa merusak kolom nilai_awal)
        PrepotesUserModel::updateOrCreate([
            'class_id' => $materi_id,
            'user_id' => $userId,
        ], $data);

        // Post-test ADA REMEDIAL jika di bawah 70
        if ($nilai_final < 70) {
            return redirect()->route('siswa.materi.belajar', [$materi_id])
                ->with('warning', 'Nilai Post-test Anda: ' . $nilai_final . '. Anda belum mencapai batas kelulusan (70). Silakan coba remedi.');
        }

        return redirect()->route('siswa.materi.belajar', [$materi_id])
            ->with('success', 'Selamat! Anda lulus Post-test dengan nilai: ' . $nilai_final);
    }
}
    private function parseYoutubeCode($url)
    {
        $shortUrlRegex = "/(?:https?:\\/\\/)?(?:www\\.)?(?:youtu\\.be\\/|v\\/|u\\/\\w\\/|embed\\/|watch\\?v=|&v=)([^#\\&\\?]*).*/";
        preg_match($shortUrlRegex, $url, $matches);
        if (isset($matches[1]) && strlen($matches[1]) == 11) {
            return "https://www.youtube.com/embed/" . $matches[1] . "?modestbranding=1&rel=0&showinfo=0";
        }
        return $url;
    }
}