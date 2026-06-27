<?php

namespace App\Http\Controllers\Beasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriModel;
use App\Models\MateriModel;
use App\Models\PreposttestModel;
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
        $modulTerkunci = DB::table('siswa_modul_aktif')
        ->where('user_id', $userId)
        // ->where('class_id', '!=', $materi_id)
        ->first();

        $kategori = KategoriModel::with(['materi' => function($query) {
            $query->orderBy('urutan', 'asc');
        }, 'materi.subMateri'])->get();

        return view('compact.materi-siswa', compact('kategori', 'modulTerkunci'));
    }

   public function belajar(Request $request, $materi_id, $sub_materi_id = null)
{
    $userId = Auth::id();

    // Ambil profil siswa dan status beasiswanya
    $siswaProfile = auth()->user()->siswa; 
    $statusBeasiswaSiswa = $siswaProfile ? $siswaProfile->beasiswa : 0;

    // 1. CEK ATAU DAFTARKAN MODUL AKTIF (RULE 1: Satu siswa, satu modul)
    // Cek apakah user sudah terikat di modul lain
    $modulLain = DB::table('siswa_modul_aktif')
        ->where('user_id', $userId)
        ->where('class_id', '!=', $materi_id)
        ->first();

    if ($modulLain) {
        return redirect()->route('siswa.materi.belajar', [$modulLain->class_id])
            ->with('error', 'Peringatan! Anda hanya diperbolehkan mengikuti 1 modul pelatihan yang sudah dipilih sebelumnya.');
    }

    // Jika belum terikat di modul manapun, kunci pilihan siswa ke modul ini secara permanen
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

    // --- SISA LOGIKA CODE ANDA DIBAWAH TETAP SAMA ---
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

        // RULE 2: Wajib Pre-test jika ada DAN siswa adalah penerima Beasiswa (status == 1)
        // Jika siswa Non-Beasiswa (status == 0), abaikan aturan wajib pre-test ini
        if ($statusBeasiswaSiswa == 1) {
            $sudahPreTest = $userProgress && !is_null($userProgress->nilai_awal);
            if ($preTest && !$sudahPreTest) {
                $contentType = 'pre';
            }
        }

        // TAMBAHAN ATURAN BARU: Siswa Non-Beasiswa dilarang keras masuk ke halaman Pre/Post-Test
        if (($contentType === 'pre' || $contentType === 'post') && $statusBeasiswaSiswa == 0) {
            return redirect()->route('siswa.materi.belajar', [$materi_id])
                ->with('error', 'Siswa non-beasiswa tidak diperkenankan mengakses Pre-Test maupun Post-Test.');
        }

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
            
            // Ambil daftar ID sub materi untuk validasi urutan
            $listSubMateri = $materiAktif->subMateri;
            
            if ($sub_materi_id) {
                $subMateriAktif = SubMateriModel::findOrFail($sub_materi_id);
            } else {
                // Cari materi pertama yang valid sesuai dengan tipe beasiswa siswa tersebut
                $subMateriAktif = $listSubMateri->filter(function($item) use ($statusBeasiswaSiswa) {
                    if ($statusBeasiswaSiswa == 0 && $item->tipe_beasiswa == 1) return false;
                    if ($statusBeasiswaSiswa == 1 && $item->tipe_beasiswa == 2) return false;
                    return true;
                })->first();
            }

            if ($subMateriAktif) {
                // VALIDASI BACKEND: Blokir jika siswa mencoba bypass URL ke materi yang bukan tipenya
                if (($subMateriAktif->tipe_beasiswa == 1 && $statusBeasiswaSiswa == 0) || 
                    ($subMateriAktif->tipe_beasiswa == 2 && $statusBeasiswaSiswa == 1)) {
                    
                    return redirect()->route('siswa.materi.belajar', [$materi_id])
                        ->with('error', 'Anda tidak memiliki hak akses untuk mempelajari bab materi ini.');
                }

                // RULE 3: Materi berurutan tidak boleh loncat bab
                $materiSebelumnya = $listSubMateri->where('urutan', '<', $subMateriAktif->urutan);
                $openedLessons = session()->get("materi_progress_{$materi_id}", []);
                
                // Pengecekan urutan bab sebelumnya
                if ($listSubMateri->first() && $subMateriAktif->id !== $listSubMateri->first()->id) {
                    foreach ($materiSebelumnya as $prev) {
                        // Lewati validasi urutan jika materi tersebut memang dari awal tipenya tidak boleh diakses siswa saat ini
                        if (($prev->tipe_beasiswa == 1 && $statusBeasiswaSiswa == 0) || 
                            ($prev->tipe_beasiswa == 2 && $statusBeasiswaSiswa == 1)) {
                            continue; 
                        }

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
            'statusBeasiswaSiswa' // Kita kirim variabel ini ke view agar pengecekan di blade lebih ringan
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

public function report($materi_id, $id)
{
    $userId = Auth::id();
    
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

    // PERBAIKAN: Gunakan Model Eloquent agar casting array berjalan otomatis
    $quizData = PreposttestModel::where('id_materi', $materi_id)
        ->where('tipe_prepost', $tipeQuiz)
        ->first();

    if (!$quizData) {
        abort(404, 'Data Kuis Referensi Tidak Ditemukan.');
    }

    // Karena sudah dicasting di model, langsung ambil atau decode jika masih string
    $daftarSoal = is_array($quizData->soal) ? $quizData->soal : json_decode($quizData->soal, true);
    
    // Pastikan jawaban user berupa array
    $jawabanUser = is_array($progressAktif->jawaban) ? $progressAktif->jawaban : json_decode($progressAktif->jawaban, true);
if (is_string($daftarSoal)) { $daftarSoal = json_decode($daftarSoal, true); }
    if (is_string($jawabanUser)) { $jawabanUser = json_decode($jawabanUser, true); }

    // Tambahkan variabel pengecekan kelulusan (KKM 70)
    $isLulus = ($progressAktif->nilai_akhir >= 70);

    return view('compact.report-kelulusan', compact(
        'progressAktif', 
        'materiAktif', 
        'daftarSoal', 
        'jawabanUser', 
        'tipeQuiz',
        'preTestRecord',
        'postTestRecord',
        'isLulus' // Ambil data ini di view
    ));
}

// -------------------------------------------------------------
// METHOD BARU: Report berdasarkan Class ID saja
// -------------------------------------------------------------
public function reportByClass($materi_id)
{
    $userId = Auth::id();

    // Cari progress terbaru (bisa pre atau post test) berdasarkan class_id
    $progressAktif = PrepotesUserModel::where('class_id', $materi_id)
        ->where('user_id', $userId)
        ->orderBy('id', 'desc') // Ambil yang paling baru dikerjakan
        ->first();

    if (!$progressAktif) {
        return redirect()->route('siswa.materi.belajar', $materi_id)
            ->with('warning', 'Anda belum memiliki riwayat ujian untuk materi ini.');
    }

    // Alihkan ke fungsi report utama dengan membawa ID progress yang ditemukan
    return $this->report($materi_id, $progressAktif->id);
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