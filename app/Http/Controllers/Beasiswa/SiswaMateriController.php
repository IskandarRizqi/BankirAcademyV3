<?php

namespace App\Http\Controllers\Beasiswa;

use App\Http\Controllers\Controller;
use App\Models\CertificateTemplate;
use Illuminate\Http\Request;
use App\Models\KategoriModel;
use App\Models\MateriModel;
use App\Models\PreposttestModel;
use App\Models\SubMateriModel;
use App\Models\PrepotesUserModel; // Model progress/test user
use App\Models\RiwayatTransaksi;
use App\Models\SiswaModulAktif;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SiswaMateriController extends Controller
{
public function index(Request $request) // Tambahkan parameter Request
{
    $userId = Auth::id();
    $user = Auth::user();
    
    $user->load('bank.membership');
    $bankProfile = $user->bank;
    
    $isMemberAktif = false;
    $limitVideo = 0; 

    if ($bankProfile) {
        if ($bankProfile->masa_aktif_member) {
            $isMemberAktif = \Carbon\Carbon::parse($bankProfile->masa_aktif_member)->isFuture();
        }
        if ($bankProfile->membership) {
            $limitVideo = (int) $bankProfile->membership->limit_video;
        }
    }

    $siswaProfile = $user->siswa; 
    $statusBeasiswa = $siswaProfile ? $siswaProfile->beasiswa : 0; 
    $allowedTipeSubMateri = ($statusBeasiswa == 1) ? [0, 1] : [0, 2];
    
    $modulDiikutiIds = DB::table('siswa_modul_aktif')
        ->where('user_id', $userId)
        ->pluck('class_id')
        ->toArray();

    // 💡 AMBIL DATA UNTUK COMPONENT FILTER DRUOPDOWN
    $listKategori = KategoriModel::select('id', 'nama')->orderBy('nama', 'asc')->get();

    if (!$isMemberAktif) {
        $kategori = collect(); 
        $hasPrepostData = false;
    } else {
        // 💡 AMBIL INPUT DARI FILTER & SEARCH
        $search = $request->input('search');
        $filterKategoriId = $request->input('kategori_id');

        $kategoriQuery = KategoriModel::query();

        // Jika user memilih kategori spesifik
        if ($filterKategoriId) {
            $kategoriQuery->where('id', $filterKategoriId);
        }

        $kategori = $kategoriQuery->with([
            'materi' => function($query) use ($limitVideo, $search) {
                $query->orderBy('urutan', 'asc')->where('nama', '!=', 'Umum');
                
                if ($limitVideo > 0) {
                    $query->where('urutan', '<=', $limitVideo);
                }

                // 💡 LOGIK PENCARIAN BERDASARKAN NAMA MATERI
                if ($search) {
                    $query->where('nama', 'like', '%' . $search . '%');
                }
            }, 
           'materi.subMateri' => function($query) use ($allowedTipeSubMateri) {
    $query->whereIn('tipe_beasiswa', $allowedTipeSubMateri)
          ->with('items') // 🌟 Tambahkan load items di sini
          ->orderBy('urutan', 'asc');
}
        ])->get();

        $kategori->each(function($kat) {
            $kat->setRelation('materi', $kat->materi->filter(function($mat) {
                return $mat->subMateri->count() > 0;
            }));
        });

        $kategori = $kategori->filter(function($kat) {
            return $kat->materi->count() > 0;
        });

        $hasPrepostData = PrepotesUserModel::where('user_id', $userId)->exists();
    }

    // Kirim $listKategori ke view agar bisa dipasang di <select>
    return view('compact.materi-siswa', compact('kategori', 'modulDiikutiIds', 'hasPrepostData', 'isMemberAktif', 'listKategori'));
}

public function belajar(Request $request, $materi_id, $sub_materi_id = null)
{
    $userId = Auth::id();

    // 1. Ambil profil siswa dan status beasiswanya
    $siswaProfile = auth()->user()->siswa; 
    $statusBeasiswaSiswa = $siswaProfile ? $siswaProfile->beasiswa : 0;

    // Tentukan sub-materi apa saja yang boleh dilewati berdasarkan tipe siswa
    $allowedTipeSubMateri = ($statusBeasiswaSiswa == 1) ? [0, 1] : [0, 2];

    // Cek apakah siswa sudah terdaftar/membeli modul ini
    $sudahTerkunci = DB::table('siswa_modul_aktif')
        ->where('user_id', $userId)
        ->where('class_id', $materi_id)
        ->exists();

    // 2. AMBIL DATA MATERI
    $materiAktif = MateriModel::with(['subMateri' => function($query) use ($allowedTipeSubMateri) {
        $query->whereIn('tipe_beasiswa', $allowedTipeSubMateri)
              ->with('items') 
              ->orderBy('urutan', 'asc');
    }, 'kategori', 'preposttest'])->findOrFail($materi_id);

    $preTest = $materiAktif->preposttest->where('tipe_prepost', 0)->first();
    $postTest = $materiAktif->preposttest->where('tipe_prepost', 1)->first();

    $userProgress = PrepotesUserModel::where('class_id', $materi_id)
        ->where('user_id', $userId)
        ->first();

    $contentType = $request->query('type', 'materi');
    $itemIdAktif = $request->query('item_id'); 
    
    $subMateriAktif = null;
    $itemAktif = null; 
    $embedUrl = null;
    $quizAktif = null;
    
    // 💡 SKEMA BARU: Ambil ID Sub Materi & Items yang sudah sukses diselesaikan dari DB
    $subMateriSelesaiIds = \App\Models\UserSubMateriProgress::where('user_id', $userId)
        ->where('is_completed', true)
        ->pluck('id_sub_materi')
        ->toArray();

    $itemSelesaiIds = \App\Models\UserSubMateriItemProgress::where('user_id', $userId)
        ->where('is_completed', true)
        ->pluck('id_sub_materi_item')
        ->toArray();

    $totalSubMateri = $materiAktif->subMateri->count();
    $semuaMateriSelesai = count(array_intersect($materiAktif->subMateri->pluck('id')->toArray(), $subMateriSelesaiIds)) >= $totalSubMateri;

    // Proteksi Test
    if (!$sudahTerkunci && ($contentType === 'pre' || $contentType === 'post')) {
        return redirect()->route('siswa.materi.belajar', [$materi_id])
            ->with('warning', 'Silakan lakukan pendaftaran/pembayaran kelas terlebih dahulu.');
    }

    if ($statusBeasiswaSiswa == 1 && $sudahTerkunci) { 
        $sudahPreTest = $userProgress && !is_null($userProgress->nilai_awal);
        if ($preTest && !$sudahPreTest) {
            $contentType = 'pre';
        }
    }
    
    if ($contentType === 'post' && !$semuaMateriSelesai) {
        return redirect()->route('siswa.materi.belajar', [$materi_id])
            ->with('warning', 'Anda harus menyelesaikan seluruh materi pelajaran terlebih dahulu sebelum mengikuti Post-Test.');
    }

    if (($contentType === 'pre' || $contentType === 'post') && $statusBeasiswaSiswa == 0) {
        return redirect()->route('siswa.materi.belajar', [$materi_id])
            ->with('error', 'Siswa non-beasiswa tidak diperkenankan mengakses Pre-Test maupun Post-Test.');
    }

    // 3. LOGIKA SELEKSI KONTEN
    if ($contentType === 'pre' && $preTest) {
        $quizAktif = $preTest;
        if (is_string($quizAktif->soal)) {
            $quizAktif->soal = json_decode($quizAktif->soal, true);
        }
    } elseif ($contentType === 'post' && $postTest) {
        $quizAktif = $postTest;
        if (is_string($quizAktif->soal)) {
            $quizAktif->soal = json_decode($quizAktif->soal, true);
        }
    } else {
        $contentType = 'materi';
        $listSubMateri = $materiAktif->subMateri; 
        
        if ($sub_materi_id) {
            $subMateriAktif = SubMateriModel::whereIn('tipe_beasiswa', $allowedTipeSubMateri)
                ->with('items')
                ->findOrFail($sub_materi_id);
        } else {
            $subMateriAktif = $listSubMateri->first();
        }

        if ($subMateriAktif) {
            if (!in_array($subMateriAktif->tipe_beasiswa, $allowedTipeSubMateri)) {
                return redirect()->route('siswa.materi.belajar', [$materi_id])
                    ->with('error', 'Anda tidak memiliki hak akses untuk mempelajari bab materi ini.');
            }

            // 💡 PERBAIKAN URUTAN BAB: Bandingkan berdasarkan status penyelesaian di DB
            if ($sudahTerkunci && $listSubMateri->first() && $subMateriAktif->id !== $listSubMateri->first()->id) {
                $materiSebelumnya = $listSubMateri->where('urutan', '<', $subMateriAktif->urutan);
                
                foreach ($materiSebelumnya as $prev) {
                    if (!in_array($prev->id, $subMateriSelesaiIds)) {
                        return redirect()->route('siswa.materi.belajar', [$materi_id, $prev->id])
                            ->with('info', 'Anda harus mempelajari materi ini secara berurutan.');
                    }
                }
            }

            // ---- PILIH ITEM MEDIA ----
           if ($subMateriAktif->items->count() > 0) {
                // Urutkan item berdasarkan urutan id atau kolom urutan jika ada (asumsi default urutan pembuatan/ID)
                $listItems = $subMateriAktif->items->sortBy('id'); 

                if ($itemIdAktif) {
                    $itemAktif = $listItems->where('id', $itemIdAktif)->first();
                }
                if (!$itemAktif) {
                    $itemAktif = $listItems->first();
                }

                if ($itemAktif) {
                    // 💡 PROTEKSI ITEM INTERN: Siswa tidak boleh melompati item di dalam bab ini
                    if ($sudahTerkunci && $itemAktif->id !== $listItems->first()->id) {
                        // Ambil semua item sebelum item aktif saat ini
                        $itemsSebelumnya = $listItems->where('id', '<', $itemAktif->id);
                        
                        foreach ($itemsSebelumnya as $prevItem) {
                            if (!in_array($prevItem->id, $itemSelesaiIds)) {
                                // Redirect ke item sebelumnya yang belum selesai
                                return redirect()->route('siswa.materi.belajar', [$materi_id, $subMateriAktif->id])
                                    ->with('item_id', $prevItem->id) // bawa item_id target lewat flash session atau query jika route mendukung
                                    ->with('info', 'Anda harus menyelesaikan media pembelajaran ini secara berurutan.');
                            }
                        }
                    }

                    // Tentukan Embed URL
                    if ($itemAktif->tipe_link_item == 0) {
                        $embedUrl = $this->parseYoutubeCode($itemAktif->link_item);
                    } else if ($itemAktif->tipe_link_item == 1) {
                        $embedUrl = $this->parseGoogleDriveLink($itemAktif->link_item);
                    }

                    // 💡 SIMPAN PROGRESS ITEM & BAB KE DATABASE
                    if ($sudahTerkunci) {
                        \App\Models\UserSubMateriItemProgress::updateOrCreate(
                            ['user_id' => $userId, 'id_sub_materi_item' => $itemAktif->id],
                            ['is_completed' => true, 'completed_at' => now()]
                        );
                        if (!in_array($itemAktif->id, $itemSelesaiIds)) {
                            $itemSelesaiIds[] = $itemAktif->id;
                        }

                        // Evaluasi Bab selesai
                        $semuaItemBabIniSelesai = $subMateriAktif->items->every(function($item) use ($itemSelesaiIds) {
                            return in_array($item->id, $itemSelesaiIds);
                        });

                        if ($semuaItemBabIniSelesai) {
                            \App\Models\UserSubMateriProgress::updateOrCreate(
                                ['user_id' => $userId, 'id_sub_materi' => $subMateriAktif->id],
                                ['is_completed' => true, 'completed_at' => now()]
                            );
                            if (!in_array($subMateriAktif->id, $subMateriSelesaiIds)) {
                                $subMateriSelesaiIds[] = $subMateriAktif->id;
                            }
                        }
                    }
                }
            }
        }
    }
    
    return view('compact.belajar', compact(
        'materiAktif', 
        'subMateriAktif', 
        'itemAktif', 
        'embedUrl', 
        'preTest', 
        'postTest', 
        'contentType', 
        'quizAktif',
        'userProgress',
        'statusBeasiswaSiswa',
        'sudahTerkunci',
        'subMateriSelesaiIds', // Dioper ke view
        'itemSelesaiIds'        // Dioper ke view
    ));
}

public function ikutiKelas(Request $request, $id)
{
    $userId = Auth::id();
    $user = auth()->user();
    $siswaProfile = $user->siswa; 
    $statusBeasiswaSiswa = $siswaProfile ? $siswaProfile->beasiswa : 0;

    $materi = MateriModel::findOrFail($id);

    // 💡 HAPUS VALIDASI $modulLain DI SINI AGAR BISA BELI LEBIH DARI 1 MODUL

    // Cek apakah sudah terdaftar sebelumnya di modul spesifik ini
    $sudahTerkunci = DB::table('siswa_modul_aktif')
        ->where('user_id', $userId)
        ->where('class_id', $id)
        ->exists();

    if ($sudahTerkunci) {
        return redirect()->route('siswa.materi.belajar', [$id]);
    }

    return view('compact.pembayaran', compact('materi', 'user', 'siswaProfile', 'statusBeasiswaSiswa'));
}

/**
 * Route/Method baru khusus untuk memproses saldo beasiswa saat tombol diklik di halaman pembayaran
 */
public function prosesBayarBeasiswa(Request $request, $id)
{
    $userId = Auth::id();
    $siswaProfile = auth()->user()->siswa;
    $materi = MateriModel::findOrFail($id);
    $hargaMateri = $materi->harga ?? 0;

    if (!$siswaProfile || $siswaProfile->beasiswa != 1) {
        return redirect()->back()->with('error', 'Akses ditolak. Anda bukan siswa penerima beasiswa.');
    }

    // [VALIDASI TAMBAHAN] Cek apakah siswa sudah memiliki modul ini agar tidak beli 2 kali
    $sudahPunyaModul = DB::table('siswa_modul_aktif')
        ->where('user_id', $userId)
        ->where('class_id', $id)
        ->exists();

    if ($sudahPunyaModul) {
        return redirect()->route('siswa.materi.belajar', [$id])
            ->with('info', 'Anda sudah terdaftar di kelas ini.');
    }

    // Validasi kecukupan saldo
    if ($siswaProfile->saldo < $hargaMateri) {
        return redirect()->back()->with('error', 'Transaksi gagal. Saldo beasiswa Anda tidak mencukupi.');
    }

    DB::beginTransaction();
    try {
        // 1. Potong Saldo
        $siswaProfile->saldo -= $hargaMateri;
        $siswaProfile->save();

        // 2. Masukkan ke Modul Aktif menggunakan insertOrIgnore untuk menghindari crash constraint
        DB::table('siswa_modul_aktif')->insertOrIgnore([
            'user_id'    => $userId,
            'class_id'   => $id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 3. Catat Riwayat Transaksi Baru
        RiwayatTransaksi::create([
            'user_id'           => $userId,
            'class_id'          => $id,
            'nominal_transaksi' => $hargaMateri,
            'metode_pembayaran' => 'Saldo Beasiswa',
            'status'            => 'SUCCESS',
            'keterangan'        => 'Pembelian materi pelatihan melalui pemotongan saldo beasiswa.'
        ]);

        DB::commit();
        return redirect()->route('siswa.materi.belajar', [$id])
            ->with('success', 'Selamat! Saldo berhasil dipotong dan akses kelas telah dibuka.');

    } catch (\Exception $e) {
        DB::rollBack();
        
        // Log error asli untuk mempermudah debugging di file laravel.log jika ada masalah lain
        \Log::error('Gagal memproses bayar beasiswa: ' . $e->getMessage());

        // Kembalikan ke halaman sebelumnya (jangan langsung ke halaman belajar karena transaksi GAGAL)
        return redirect()->back()->with('error', 'Terjadi kesalahan sistem saat memproses transaksi.');
    }
}
    private function parseGoogleDriveLink($url)
{
    // Jika bukan link google drive, kembalikan url aslinya
    if (strpos($url, 'drive.google.com') === false) {
        return $url;
    }

    // Pola untuk mengambil ID file Google Drive
    preg_match('/\/d\/([a-zA-Z0-9-_]+)/', $url, $matches);
    
    if (isset($matches[1])) {
        $fileId = $matches[1];
        // Format link khusus untuk Google Docs Viewer (paling aman dari error "butuh akses")
        return "https://docs.google.com/viewer?url=" . urlencode("https://drive.google.com/uc?id=" . $fileId . "&export=download") . "&embedded=true";
    }

    return $url;
}

public function savejawaban(Request $request, $materi_id, $quiz_id)
{
    $userId = Auth::user()->id;

    // 1. Ambil data kuis/test dari database berdasarkan id
    $quiz = DB::table('preposttest')->where('id', $quiz_id)->first();
    if (!$quiz) {
        return redirect()->back()->with('error', 'Data ujian tidak ditemukan.');
    }

    // 2. Cek riwayat pengerjaan user secara SPESIFIK & ketat (Ingat: Sekarang data selalu buat baru)
    if ($quiz->tipe_prepost == 0) {
        // Cek apakah user PERNAH mengisi Pre-test di materi ini
        $pr = PrepotesUserModel::where('class_id', $materi_id)
            ->where('user_id', $userId)
            ->where('nilai_awal', '>', 0) // atau mengecek entri dengan nilai_awal yang sudah terisi
            ->first();
            
        if ($pr) {
            return redirect()->route('siswa.materi.belajar', [$materi_id])
                ->with('error', 'Anda sudah mengikuti Pre-test sebelumnya. Pre-test hanya dapat diikuti 1 kali.');
        }
    } else {
        // Cek apakah user sudah mengisi Post-test DAN nilainya lulus (>= 70)
        $pr = PrepotesUserModel::where('class_id', $materi_id)
            ->where('user_id', $userId)
            ->where('nilai_akhir', '>=', 70)
            ->first();

        if ($pr) {
            return redirect()->route('siswa.materi.belajar', [$materi_id])
                ->with('error', 'Anda sudah lulus Post-test ini dengan nilai ' . $pr->nilai_akhir . '. Tidak dapat mengisi kembali.');
        }
    }

    // 3. Pastikan data soal didecode sampai menjadi ARRAY murni
    $daftarSoal = $quiz->soal;
    while (is_string($daftarSoal)) {
        $daftarSoal = json_decode($daftarSoal, true);
    }

    if (!is_array($daftarSoal)) {
        return redirect()->back()->with('error', 'Gagal memproses format soal di database.');
    }

    $jawabanBenarCount = 0;
    $totalSoal = count($daftarSoal);
    $jawabanUserArray = $request->input('jawaban', []);

    if ($totalSoal > 0 && !empty($jawabanUserArray)) {
        foreach ($daftarSoal as $index => $soal) {
            $kunciBenar = $soal['jawaban'] ?? $soal['Jawaban'] ?? null;
            $jawabanUser = $jawabanUserArray[$index] ?? null;

            if (!is_null($jawabanUser) && !is_null($kunciBenar)) {
                if (strtoupper(trim($jawabanUser)) === strtoupper(trim($kunciBenar))) {
                    $jawabanBenarCount++;
                }
            }
        }
        $nilai_final = ($jawabanBenarCount / $totalSoal) * 100;
    } else {
        $nilai_final = 0;
    }

    // Ambil total percobaan pengerjaan sebelumnya di kelas ini untuk hitung total jml_jawaban global
    $totalPercobaanSebelumnya = PrepotesUserModel::where('class_id', $materi_id)
        ->where('user_id', $userId)
        ->count();

    $data = [
        'class_id' => $materi_id,
        'user_id' => $userId,
        'jawaban' => json_encode($jawabanUserArray), 
        'jml_jawaban' => $totalPercobaanSebelumnya + 1,
    ];

    // 4. ALUR SIMPAN: Selalu create() entri baru, tidak ada update()
    if ($quiz->tipe_prepost == 0) {
        $data['nilai_awal'] = $nilai_final;
        $data['nilai_akhir'] = 0; 

        // Buat entri baru khusus Pre-test
        $newPreTest = PrepotesUserModel::create($data);

        // Alihkan ke report khusus Pre-test agar bisa melihat detail jawabannya langsung
        return redirect()->route('siswa.materi.report', [$materi_id, $newPreTest->id])
            ->with('success', 'Pre-test selesai! Nilai Anda: ' . $nilai_final . '. Silakan lanjutkan ke materi pelajaran.');
            
    } else {
        $data['nilai_akhir'] = $nilai_final;
        $data['nilai_awal'] = 0; 

        // Buat entri baru khusus Post-test
        $newPostTest = PrepotesUserModel::create($data);

        if ($nilai_final < 70) {
            // Jika gagal post test, arahkan ke report pengerjaan gagal ini agar bisa mengevaluasi salahnya di mana
            return redirect()->route('siswa.materi.report', [$materi_id, $newPostTest->id])
                ->with('warning', 'Nilai Post-test Anda: ' . $nilai_final . '. Anda belum mencapai batas kelulusan (70). Silakan pelajari kembali materi dan coba remedi.');
        }

        // KELULUSAN POST-TEST
        return redirect()->route('siswa.materi.report', [$materi_id, $newPostTest->id])
            ->with('success', 'Selamat! Anda lulus Post-test dengan nilai: ' . $nilai_final);
    }
}

// Modifikasi tipis pada fungsi utama agar user_id dinamis (default: user login saat ini)
public function report($materi_id, $id, $userId = null)
{
    // Cek siapa yang sedang login saat ini
    $authCurrentUser = auth()->user();
    
    if (!$userId) {
        $userId = $authCurrentUser->id;
    }
    
    $isManajemen = in_array($authCurrentUser->role, [0, 4]);
    
    $materiAktif = MateriModel::with('kategori')->findOrFail($materi_id);
    
    $progressAktif = PrepotesUserModel::where('id', $id)
        ->where('user_id', $userId)
        ->where('class_id', $materi_id)
        ->firstOrFail();

    $tipeQuiz = ($progressAktif->nilai_awal > 0 && $progressAktif->nilai_akhir == 0) ? 0 : 1;

    $preTestRecord = PrepotesUserModel::where('class_id', $materi_id)
        ->where('user_id', $userId)
        ->where('nilai_awal', '>', 0)
        ->first();

    $postTestRecord = PrepotesUserModel::where('class_id', $materi_id)
        ->where('user_id', $userId)
        ->where('nilai_akhir', '>', 0)
        ->orderBy('id', 'desc')
        ->first();

    $quizData = PreposttestModel::where('id_materi', $materi_id)
        ->where('tipe_prepost', $tipeQuiz)
        ->first();

    if (!$quizData) {
        abort(404, 'Data Kuis Referensi Tidak Ditemukan.');
    }

    $daftarSoal = is_array($quizData->soal) ? $quizData->soal : json_decode($quizData->soal, true);
    $jawabanUser = is_array($progressAktif->jawaban) ? $progressAktif->jawaban : json_decode($progressAktif->jawaban, true);
    
    if (is_string($daftarSoal)) { $daftarSoal = json_decode($daftarSoal, true); }
    if (is_string($jawabanUser)) { $jawabanUser = json_decode($jawabanUser, true); }

    $isLulus = ($progressAktif->nilai_akhir >= 70);

    // Ambil info user pengikut kelas untuk nama di sertifikat
    $siswaUser = \App\Models\User::find($userId); 

    // AMBIL DATA SERTIFIKAT ASLI DARI DATABASE
    // Sesuaikan 'SertifikatModel', 'materi_id', dan nama kolom file gambar ('file_sertifikat') dengan tabel Anda
    $sertifikatMateri = CertificateTemplate::where('materi_id', $materi_id)->first();

    return view('compact.report-kelulusan', compact(
        'progressAktif', 
        'materiAktif', 
        'daftarSoal', 
        'jawabanUser', 
        'tipeQuiz',
        'preTestRecord',
        'postTestRecord',
        'isLulus',
        'isManajemen',
        'siswaUser',
        'sertifikatMateri' // Dikirim ke view
    ));
}

public function reportByClass($materi_id)
{
    $userId = Auth::id();

    $progressAktif = PrepotesUserModel::where('class_id', $materi_id)
        ->where('user_id', $userId)
        ->orderBy('id', 'desc')
        ->first();

    if (!$progressAktif) {
        return redirect()->route('siswa.materi.belajar', $materi_id)
            ->with('warning', 'Anda belum memiliki riwayat ujian untuk materi ini.');
    }

    return $this->report($materi_id, $progressAktif->id, $userId);
}

// FUNGSI BARU: Generate PDF Sertifikat
public function downloadSertifikat($materi_id, $id)
{
    $authCurrentUser = auth()->user();
    $progressAktif = PrepotesUserModel::where('id', $id)->where('class_id', $materi_id)->firstOrFail();
    
    // Keamanan: Hanya pemilik sertifikat atau manajemen yang boleh download
    if ($progressAktif->user_id !== $authCurrentUser->id && !in_array($authCurrentUser->role, [0, 4])) {
        abort(403, 'Akses tidak sah.');
    }

    // Cek kelulusan
    if ($progressAktif->nilai_akhir < 70) {
        return redirect()->back()->with('warning', 'Sertifikat belum tersedia karena Anda belum mencapai batas kelulusan.');
    }

    $materiAktif = MateriModel::findOrFail($materi_id);
    $siswaUser = \App\Models\User::find($progressAktif->user_id);
    $tanggalLulus = $progressAktif->updated_at ? Carbon::parse($progressAktif->updated_at)->translatedFormat('d F Y') : Carbon::now()->translatedFormat('d F Y');

    // Load ke view khusus PDF (A4 - Landscape)
    $pdf = Pdf::loadView('compact.sertifikat-pdf', compact('progressAktif', 'materiAktif', 'siswaUser', 'tanggalLulus'))
              ->setPaper('a4', 'landscape');

    return $pdf->download('Sertifikat_' . str_replace(' ', '_', $materiAktif->nama) . '_' . $siswaUser->id . '.pdf');
}

// -----------------------------------------------------------------
// METHOD BARU: Untuk Mengakses Laporan dari Menu Bank, Root, Sekolah
// -----------------------------------------------------------------
public function reportOlehManajemen($user_id, $materi_id)
{
    // Cari data riwayat tes terbaru dari siswa tersebut di kelas terkait
    $progressAktif = PrepotesUserModel::where('class_id', $materi_id)
        ->where('user_id', $user_id)
        ->orderBy('id', 'desc')
        ->first();

    if (!$progressAktif) {
        return redirect()->back()->with('warning', 'Siswa tersebut belum memiliki riwayat ujian pada modul ini.');
    }

    // Panggil method report utama dengan menyertakan ID siswa target
    return $this->report($materi_id, $progressAktif->id, $user_id);
}

public function indexLaporanManajemen()
{
    $authCurrentUser = auth()->user();
    $role = $authCurrentUser->role;
    $email = $authCurrentUser->email;
    $userId = $authCurrentUser->id;

    // Menentukan hak akses role terpilih
    $isRoot = ($role == 4 && $email == 'cb@bankir.academy');
    $isBank = ($role == 4 && $email != 'cb@bankir.academy');
    $isSekolah = ($role == 5);

    // Jika bukan salah satu dari 3 role di atas, batalkan akses
    if (!$isRoot && !$isBank && !$isSekolah) {
        abort(403, 'Anda tidak memiliki akses ke halaman rekapitulasi ini.');
    }

    // Base query dengan eager loading relasi user, profil siswa, bank, sekolah, dan materi
    $query = SiswaModulAktif::with(['user.siswa', 'user.bank', 'user.sekolah', 'materi']);

    // Pola Filter Data Berdasarkan Role
    if ($isBank) {
        // Bank hanya melihat siswa yang terhubung dengan bank_id miliknya
        $query->whereHas('user', function($q) use ($userId) {
            $q->where('bank_id', $userId);
        });
    } elseif ($isSekolah) {
        // Sekolah hanya melihat siswa yang terhubung dengan sekolah_id miliknya
        $query->whereHas('user', function($q) use ($userId) {
            $q->where('sekolah_id', $userId);
        });
    }

    $siswaModul = $query->get();

    // Hitung statistik berdasarkan data yang sudah terfilter
    $stats = [
        'total_siswa_aktif'   => $siswaModul->unique('user_id')->count(),
        'total_modul_diikuti' => $siswaModul->unique('class_id')->count(),
        'total_beasiswa'      => $siswaModul->filter(fn($item) => optional($item->user->siswa)->beasiswa == 1)->unique('user_id')->count(),
        'total_non_beasiswa'  => $siswaModul->filter(fn($item) => optional($item->user->siswa)->beasiswa == 0)->unique('user_id')->count(),
    ];

    // Pola Pengelompokan (Grouping) Tampilan Berdasarkan Role
    if ($isRoot) {
        // Root mengelompokkan berdasarkan Bank
        $siswaModulGrouped = $siswaModul->groupBy(function($item) {
            return optional($item->user->bank)->name ?? 'Tanpa Afiliasi Bank';
        });
    } elseif ($isBank) {
        // Bank mengelompokkan berdasarkan Sekolah
        $siswaModulGrouped = $siswaModul->groupBy(function($item) {
            return optional($item->user->sekolah)->name ?? 'Sekolah Tidak Terdata';
        });
    } else {
        // Sekolah mengelompokkan langsung ke nama sekolahnya sendiri
        $siswaModulGrouped = $siswaModul->groupBy(function($item) use ($authCurrentUser) {
            return $authCurrentUser->name;
        });
    }

    return view('compact.laporan-siswa', compact('siswaModulGrouped', 'stats', 'role', 'email', 'isRoot', 'isBank', 'isSekolah'));
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
public function umumIndex()
{
    $userId = Auth::id();
    $user = Auth::user();
    
    // Cek masa aktif bank
    $user->load('bank');
    $bankProfile = $user->bank;
    $isMemberAktif = false;
    if ($bankProfile && $bankProfile->masa_aktif_member) {
        $isMemberAktif = \Carbon\Carbon::parse($bankProfile->masa_aktif_member)->isFuture();
    }

    // Jika tidak aktif, kosongkan data
    if (!$isMemberAktif) {
        $subMateriUmum = collect();
    } else {
        // Cari Materi yang bernama "Umum" beserta Sub-Materinya
        $materiUmum = MateriModel::where('nama', 'Umum')->first();
        
        $siswaProfile = $user->siswa; 
        $statusBeasiswa = $siswaProfile ? $siswaProfile->beasiswa : 0; 
        
        // Sesuaikan jika tipe_beasiswa butuh format array dinamis
        $allowedTipeSubMateri = ($statusBeasiswa == 1) ? [0, 1] : [0, 2];

        if ($materiUmum) {
            // PERBAIKAN: Menggunakan 'id_materi' bukan 'materi_id'
            $subMateriUmum = SubMateriModel::where('id_materi', $materiUmum->id)
                ->whereIn('tipe_beasiswa', $allowedTipeSubMateri)
                ->with('items')
                ->orderBy('urutan', 'asc')
                ->get();
        } else {
            $subMateriUmum = collect();
        }
    }

    return view('compact.umum-index', compact('subMateriUmum', 'isMemberAktif'));
}

public function umumBelajar(Request $request, $sub_materi_id)
{
    $userId = Auth::id();
    $siswaProfile = auth()->user(); 
    $statusBeasiswaSiswa = $siswaProfile ? $siswaProfile->beasiswa : 0;
    $allowedTipeSubMateri = ($statusBeasiswaSiswa == 1) ? [0, 1] : [0, 2];

    // Ambil Bab/Sub Materi Aktif beserta item medianya
    $subMateriAktif = SubMateriModel::whereIn('tipe_beasiswa', $allowedTipeSubMateri)
        ->with(['items', 'materi'])
        ->findOrFail($sub_materi_id);

    $materiAktif = $subMateriAktif->materi;

    // CEK APAKAH SUDAH MENGIKUTI PELATIHAN (Cek Tabel History)
    $sudahIkuti = false;
    if ($siswaProfile) {
        $sudahIkuti = DB::table('history_pelatihan')
            ->where('user_id', $siswaProfile->id)
            ->where('sub_materi_id', $sub_materi_id)
            ->exists();
    }
    $preTest = PreposttestModel::where('id_submateri', $sub_materi_id)->where('tipe_prepost', 0)->first();
    $postTest = PreposttestModel::where('id_submateri', $sub_materi_id)->where('tipe_prepost', 1)->first();
    $contentType = $request->query('type', 'materi');

    // Kontrol Media Item Aktif lewat query string item_id
    $itemIdAktif = $request->query('item_id');
    $itemAktif = null;
    $embedUrl = null;
    $quizAktif = null;
      if ($contentType === 'pre' && $preTest) {
        $quizAktif = $preTest;
        if (is_string($quizAktif->soal)) {
            $quizAktif->soal = json_decode($quizAktif->soal, true);
        }
      }
    if ($subMateriAktif->items->count() > 0) {
        if ($itemIdAktif) {
            $itemAktif = $subMateriAktif->items->where('id', $itemIdAktif)->first();
        }
        if (!$itemAktif) {
            $itemAktif = $subMateriAktif->items->first();
        }

        if ($itemAktif->tipe_link_item == 0) {
            $embedUrl = $this->parseYoutubeCode($itemAktif->link_item);
        } else if ($itemAktif->tipe_link_item == 1) {
            $embedUrl = $this->parseGoogleDriveLink($itemAktif->link_item);
        }
    }
    
    return view('compact.umum-belajar', compact(
        'materiAktif', 
        'subMateriAktif', 
        'itemAktif', 
        'embedUrl', 
        'statusBeasiswaSiswa',
        'preTest',
        'contentType',
        'quizAktif',
        'postTest',
        'sudahIkuti' // Kirim variabel status ke view
    ));
}

// FUNGSI BARU UNTUK PROSES STORE HISTORY
public function ikutiPelatihan(Request $request, $sub_materi_id)
{
    $siswaProfile = auth()->user()->id;
    if (!$siswaProfile) {
        return redirect()->back()->with('error', 'Profil siswa tidak ditemukan.');
    }

    // Insert data menggunakan updateOrInsert agar aman dari duplikasi
    DB::table('history_pelatihan')->updateOrInsert(
        [
            'user_id' => $siswaProfile,
            'sub_materi_id' => $sub_materi_id
        ],
        [
            'created_at' => now(),
            'updated_at' => now()
        ]
    );

    return redirect()->route('siswa.umum.belajar', $sub_materi_id)->with('success', 'Selamat mengikuti kelas pelatihan!');
}
public function historyPelatihan()
{
    $siswaProfile = auth()->user();

    if (!$siswaProfile) {
        return redirect()->back()->with('error', 'Profil siswa tidak ditemukan.');
    }

    // 1. Ambil data history pelatihan (Aktivitas Belajar)
    $history = DB::table('history_pelatihan')
        ->join('sub_materi', 'history_pelatihan.sub_materi_id', '=', 'sub_materi.id')
        ->where('history_pelatihan.user_id', $siswaProfile->id)
        ->select(
            'history_pelatihan.created_at as tanggal_mulai',
            'sub_materi.id as sub_materi_id',
            'sub_materi.nama as nama_sub',
            'sub_materi.urutan'
        )
        ->orderBy('history_pelatihan.created_at', 'desc')
        ->get();

    // 2. Ambil data Riwayat Transaksi (termasuk kelas/materi yang dibeli)
    $riwayatTransaksi = RiwayatTransaksi::with('materi')
        ->where('user_id', $siswaProfile->id)
        ->orderBy('created_at', 'desc')
        ->get();

    // 3. Ambil data Modul/Kelas Aktif yang sedang diikuti
    $modulAktif = SiswaModulAktif::with('materi')
        ->where('user_id', $siswaProfile->id)
        ->orderBy('created_at', 'desc')
        ->get();

    // Hitung statistik sederhana
    $totalMateri = $history->unique('nama_sub')->count();
    $totalBab = $history->count();

    // Ambil info saldo terakhir dari relation profile (jika ada)
    $saldoSiswa = $siswaProfile->siswa ? $siswaProfile->siswa->saldo : 0;

    return view('compact.history-pelatihan', compact(
        'history', 
        'totalMateri', 
        'totalBab', 
        'riwayatTransaksi', 
        'modulAktif',
        'saldoSiswa'
    ));
}
public function listSertifikat()
{
    $user = Auth::user();

    // Mengambil daftar post-test yang lulus ambang batas (>= 70) milik siswa aktif
    $sertifikats = PrepotesUserModel::with(['materi']) // Memuat relasi materi dasar
        ->where('user_id', $user->id)
        ->where('nilai_akhir', '>=', 70)
        ->orderBy('updated_at', 'desc')
        ->get();

    // Lakukan mapping untuk memeriksa CertificateTemplate dari masing-masing materi_id / class_id
    $sertifikats->transform(function($item) {
        // Ambil template sertifikat yang sesuai dengan materi terkait
        $item->sertifikatMateri = \App\Models\CertificateTemplate::where('materi_id', $item->class_id)->first();
        return $item;
    });

    // Mengembalikan ke view list sertifikat dinamis
    return view('compact.sertifikat', compact('user', 'sertifikats'));
}
}