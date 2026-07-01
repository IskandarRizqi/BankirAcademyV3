<?php

namespace App\Http\Controllers\Beasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriModel;
use App\Models\MateriModel;
use App\Models\PreposttestModel;
use App\Models\SubMateriModel;
use App\Models\PrepotesUserModel; // Model progress/test user
use App\Models\SiswaModulAktif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SiswaMateriController extends Controller
{
public function index()
{
    $userId = Auth::id();
    $user = Auth::user();
    
    // 1. Ambil masa aktif dari User Bank terkait (menggunakan eager loading relasi 'bank')
    $bankProfile = $user->bank;
    
    // Cek jika bank ditemukan, pakai masa_aktif_member milik bank. 
    // Jika tidak ada bank, kita default-kan false agar aman.
    $isMemberAktif = false;
    if ($bankProfile && $bankProfile->masa_aktif_member) {
        $isMemberAktif = \Carbon\Carbon::parse($bankProfile->masa_aktif_member)->isFuture();
    }

    $siswaProfile = $user->siswa; 
    $statusBeasiswa = $siswaProfile ? $siswaProfile->beasiswa : 0; 
    $allowedTipeSubMateri = ($statusBeasiswa == 1) ? [0, 1] : [0, 2];
    
    $modulTerkunci = DB::table('siswa_modul_aktif')
        ->where('user_id', $userId)
        ->first();

    // 2. Jika masa aktif Bank HABIS, kosongkan data kategori materi
    if (!$isMemberAktif) {
        $kategori = collect(); // Mengembalikan collection kosong
        $hasPrepostData = false;
    } else {
        // Jika Bank masih aktif, jalankan query materi seperti biasa
        $kategori = KategoriModel::with(['materi' => function($query) {
            $query->orderBy('urutan', 'asc');
        }, 'materi.subMateri' => function($query) use ($allowedTipeSubMateri) {
            $query->whereIn('tipe_beasiswa', $allowedTipeSubMateri)
                  ->orderBy('urutan', 'asc');
        }])->get();

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

    // Variabel $isMemberAktif tetap dikirim ke view Blade yang kemarin tanpa perlu mengubah kodenya lagi
    return view('compact.materi-siswa', compact('kategori', 'modulTerkunci', 'hasPrepostData', 'isMemberAktif'));
}

  public function belajar(Request $request, $materi_id, $sub_materi_id = null)
    {
        $userId = Auth::id();

        // Ambil profil siswa dan status beasiswanya
        $siswaProfile = auth()->user()->siswa; 
        $statusBeasiswaSiswa = $siswaProfile ? $siswaProfile->beasiswa : 0;

        // Tentukan sub-materi apa saja yang boleh dilewati berdasarkan tipe siswa
        // 1 = Beasiswa, 0 = Non-Beasiswa
        $allowedTipeSubMateri = ($statusBeasiswaSiswa == 1) ? [0, 1] : [0, 2];

        // 1. CEK ATAU DAFTARKAN MODUL AKTIF (RULE 1: Satu siswa, satu modul)
        $modulLain = DB::table('siswa_modul_aktif')
            ->where('user_id', $userId)
            ->where('class_id', '!=', $materi_id)
            ->first();

        if ($modulLain) {
            return redirect()->route('siswa.materi.belajar', [$modulLain->class_id])
                ->with('error', 'Peringatan! Anda hanya diperbolehkan mengikuti 1 modul pelatihan yang sudah dipilih sebelumnya.');
        }

        $sudahTerkunci = DB::table('siswa_modul_aktif')
            ->where('user_id', $userId)
            ->where('class_id', $materi_id)
            ->exists();

        if (!$sudahTerkunci) {
            DB::table('siswa_modul_aktif')->insert([
                'user_id'    => $userId,
                'class_id'   => $materi_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // 2. AMBIL DATA MATERI (Hanya me-load subMateri yang sesuai hak akses siswa)
        $materiAktif = MateriModel::with(['subMateri' => function($query) use ($allowedTipeSubMateri) {
            $query->whereIn('tipe_beasiswa', $allowedTipeSubMateri)
                  ->orderBy('urutan', 'asc');
        }, 'kategori', 'preposttest'])->findOrFail($materi_id);

        $preTest = $materiAktif->preposttest->where('tipe_prepost', 0)->first();
        $postTest = $materiAktif->preposttest->where('tipe_prepost', 1)->first();

        // Cek status test user di database
        $userProgress = PrepotesUserModel::where('class_id', $materi_id)
            ->where('user_id', $userId)
            ->first();

        // Ambil type dari query string, default-nya adalah 'materi'
        $contentType = $request->query('type', 'materi');
        $subMateriAktif = null;
        $embedUrl = null;
        $quizAktif = null;
        $openedLessons = session()->get("materi_progress_{$materi_id}", []);
        $totalSubMateri = $materiAktif->subMateri->count();
        $semuaMateriSelesai = count($openedLessons) >= $totalSubMateri;

        // RULE 2: Wajib Pre-test jika ada DAN siswa adalah penerima Beasiswa
        if ($statusBeasiswaSiswa == 1) {
            $sudahPreTest = $userProgress && !is_null($userProgress->nilai_awal);
            if ($preTest && !$sudahPreTest) {
                $contentType = 'pre';
            }
        }
        if ($contentType === 'post' && !$semuaMateriSelesai) {
                return redirect()->route('siswa.materi.belajar', [$materi_id])
                    ->with('warning', 'Anda harus menyelesaikan seluruh materi pelajaran terlebih dahulu sebelum mengikuti Post-Test.');
            }

        // Blokir akses jika siswa Non-Beasiswa mencoba masuk ke halaman Test melalui URL
        if (($contentType === 'pre' || $contentType === 'post') && $statusBeasiswaSiswa == 0) {
            return redirect()->route('siswa.materi.belajar', [$materi_id])
                ->with('error', 'Siswa non-beasiswa tidak diperkenankan mengakses Pre-Test maupun Post-Test.');
        }

        // 3. LOGIKA SELEKSI KONTEN (SUDAH DIPERBAIKI)
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
            // Jika bukan pre/post test, paksa contentType kembali ke 'materi'
            $contentType = 'materi';
            
            $listSubMateri = $materiAktif->subMateri; 
            
            if ($sub_materi_id) {
                $subMateriAktif = SubMateriModel::whereIn('tipe_beasiswa', $allowedTipeSubMateri)->findOrFail($sub_materi_id);
            } else {
                // Langsung ambil materi pertama yang tersedia dari list yang sudah terfilter
                $subMateriAktif = $listSubMateri->first();
            }

            if ($subMateriAktif) {
                // VALIDASI BACKEND: Double check bypass URL
                if (!in_array($subMateriAktif->tipe_beasiswa, $allowedTipeSubMateri)) {
                    return redirect()->route('siswa.materi.belajar', [$materi_id])
                        ->with('error', 'Anda tidak memiliki hak akses untuk mempelajari bab materi ini.');
                }

                // RULE 3: Materi berurutan tidak boleh loncat bab
                $materiSebelumnya = $listSubMateri->where('urutan', '<', $subMateriAktif->urutan);
                $openedLessons = session()->get("materi_progress_{$materi_id}", []);
                
                if ($listSubMateri->first() && $subMateriAktif->id !== $listSubMateri->first()->id) {
                    foreach ($materiSebelumnya as $prev) {
                        if (!in_array($prev->id, $openedLessons)) {
                            return redirect()->route('siswa.materi.belajar', [$materi_id, $prev->id])
                                ->with('info', 'Anda harus mempelajari materi ini secara berurutan.');
                        }
                    }
                }

                // Simpan riwayat progress membaca ke Session
                if (!in_array($subMateriAktif->id, $openedLessons)) {
                    $openedLessons[] = $subMateriAktif->id;
                    session()->put("materi_progress_{$materi_id}", $openedLessons);
                }
            }

           if ($subMateriAktif && $subMateriAktif->tipe_link == 0) {
    $embedUrl = $this->parseYoutubeCode($subMateriAktif->link);
} else if ($subMateriAktif && $subMateriAktif->tipe_link == 1) { // Asumsi 1 adalah tipe PDF
    // Daftarkan fungsi parsing Google Drive di bawah
    $embedUrl = $this->parseGoogleDriveLink($subMateriAktif->link);
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
            'userProgress',
            'statusBeasiswaSiswa'
        ));
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
    
    // Jika diakses dari panel manajemen, $userId pasti dilewatan dari parameter
    if (!$userId) {
        $userId = $authCurrentUser->id;
    }
    
    // Flag untuk menentukan apakah pengakses adalah Manajemen (Root/Bank dengan role 0 atau 4)
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

    return view('compact.report-kelulusan', compact(
        'progressAktif', 
        'materiAktif', 
        'daftarSoal', 
        'jawabanUser', 
        'tipeQuiz',
        'preTestRecord',
        'postTestRecord',
        'isLulus',
        'isManajemen' // Dikirim ke view
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
    $authCurrentUser = auth()->user(); // Mengambil user manajemen yang login
    $role = $authCurrentUser->role;    // Role: 0 = Root, 4 = Bank (Berdasarkan model Anda)
    $email = $authCurrentUser->email;
    $query = SiswaModulAktif::with(['user.siswa', 'user.bank', 'user.sekolah', 'materi']);
    if ($role == 4 && $email != 'cb@bankir.academy') {
        // Karena bank_id berada di tabel 'users', kita filter lewat relasi 'user'
        $query->whereHas('user', function($q) use ($authCurrentUser) {
            $q->where('bank_id', $authCurrentUser->id); // Menggunakan id dari bank yang sedang login
        });
    }

    $siswaModul = $query->get();
    $stats = [
        'total_siswa_aktif'   => $siswaModul->unique('user_id')->count(),
        'total_modul_diikuti' => $siswaModul->unique('class_id')->count(),
        'total_beasiswa'      => $siswaModul->filter(fn($item) => optional($item->user->siswa)->beasiswa == 1)->unique('user_id')->count(),
        'total_non_beasiswa'  => $siswaModul->filter(fn($item) => optional($item->user->siswa)->beasiswa == 0)->unique('user_id')->count(),
    ];
    if ($email == 'cb@bankir.academy' || $role == 0) {
        $siswaModulGrouped = $siswaModul->groupBy(function($item) {
            return optional($item->user->bank)->name ?? 'Tanpa Afiliasi Bank';
        });
    } else {
        $siswaModulGrouped = $siswaModul->groupBy(function($item) {
            return optional($item->user->sekolah)->name ?? 'Sekolah Tidak Terdata'; 
        });
    }

    return view('compact.laporan-siswa', compact('siswaModulGrouped', 'stats', 'role'));
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