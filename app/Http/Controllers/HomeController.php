<?php

namespace App\Http\Controllers;

use App\Models\ClassesModel;
use App\Models\ClassParticipantModel;
use App\Models\ClassPaymentModel;
use App\Models\DashboardModel;
use App\Models\FeeModel;
use App\Models\InstructorModel;
use App\Models\InstructorReviewModel;
use App\Models\SiswaModulAktif;
use App\Models\SiswaProfile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Spatie\Sitemap\SitemapGenerator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $auth = Auth::user();
        $data = [];
        // Dashboard Instructor
        if ($auth->role == 3) {
            $data['data'] = json_encode([2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2, 2.3, 1.4, 0.8, 0.5, 0.2]);
            $ins = InstructorModel::where('user_id', Auth::user()->id)->first();
            for ($i = 1; $i < 13; $i++) {
                $class[] = ClassesModel::where('instructor', 'like', '%"' . $ins->id . '"%')
                    // ->whereDate('date_end', '<', Carbon::now())
                    ->whereMonth('created_at', $i)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->count();
            }
            $data['class'] = json_encode($class);
            $i = InstructorModel::where('user_id', $auth->id)->first();
            $data['review'] = InstructorReviewModel::select('instructor_review.*', 'users.name')
                ->join('users', 'users.id', 'instructor_review.users_id')
                ->where('instructor_review.instructor_id', $i->id)
                ->get();
            return view('backend.instructor.dashboard', $data);
            // return view('compact-menu.index');
        }
        if (in_array($auth->role, [4, 5, 6]) || $auth->email == 'cb@bankir.academy') {
            $data = [];
            
            // 1. DATA UNTUK ROOT
            if ($auth->email == 'cb@bankir.academy') {
                $data['total_bank'] = User::where('role', 4)->count();
                $data['total_sekolah'] = User::where('role', 5)->count();
                $data['total_siswa'] = User::where('role', 6)->count();
                
                // Mengambil user bank lengkap dengan waktu bergabung terbaru
                $data['user_bank'] = User::where('role', 4)
                    ->orderBy('created_at', 'desc')
                    ->take(5) // Batasi 5 bank terbaru demi performa dashboard
                    ->get();
            }
            
            // 2. DATA UNTUK BANK (ROLE 4)
            elseif ($auth->role == 4) {
                $data['total_sekolah'] = User::where('role', 5)->where('bank_id', $auth->id)->count();
                $data['total_siswa'] = User::where('role', 6)->where('bank_id', $auth->id)->count();
                
                // Bank melihat ringkasan sekolah binaannya dan jumlah siswa per sekolah tersebut
                $data['daftar_sekolah'] = User::where('role', 5)
                    ->where('bank_id', $auth->id)
                    ->get()
                    ->map(function($sekolah) {
                        // Hitung jumlah siswa yang ada di sekolah ini
                        $sekolah->jumlah_siswa = User::where('role', 6)->where('sekolah_id', $sekolah->id)->count();
                        return $sekolah;
                    });
            }
            
            // 3. DATA UNTUK SEKOLAH (ROLE 5)
            elseif ($auth->role == 5) {
                // Ambil semua ID siswa yang bersekolah di sini
                $siswaIds = User::where('role', 6)->where('sekolah_id', $auth->id)->pluck('id');
                
                $data['total_siswa'] = $siswaIds->count();
                // Hitung total siswa beasiswa & total akumulasi saldo siswa dari table siswa_profiles
                $data['total_beasiswa'] = SiswaProfile::whereIn('user_id', $siswaIds)->where('beasiswa', 1)->count();
                $data['total_tabungan_siswa'] = SiswaProfile::whereIn('user_id', $siswaIds)->sum('saldo');
                
                // Tampilkan daftar siswa aktif beserta ringkasan profil singkatnya
                $data['daftar_siswa'] = User::where('role', 6)
                    ->where('sekolah_id', $auth->id)
                    ->with('siswa')
                    ->get();
            }
            
           elseif ($auth->role == 6) {
                $siswaProfile = SiswaProfile::where('user_id', $auth->id)->first();
                $data['profile'] = $siswaProfile;
                
                // Tambahkan variabel saldo agar mudah dibaca di view (default ke 0 jika profile belum dibuat)
                $data['saldo_siswa'] = $siswaProfile ? $siswaProfile->saldo : 0;

                // Query history pelatihan siswa
                $data['history'] = \DB::table('history_pelatihan')
                    ->join('sub_materi', 'history_pelatihan.sub_materi_id', '=', 'sub_materi.id')
                    ->where('history_pelatihan.user_id', $auth->id)
                    ->select(
                        'history_pelatihan.created_at as tanggal_mulai',
                        'sub_materi.id as sub_materi_id',
                        'sub_materi.nama as nama_sub',
                        'sub_materi.urutan'
                    )
                    ->orderBy('history_pelatihan.created_at', 'desc')
                    ->get();

                $data['total_materi'] = $data['history']->unique('nama_sub')->count();
                $data['total_bab'] = $data['history']->count();

                if ($siswaProfile && $siswaProfile->beasiswa == 1) {
                    $data['modul_aktif'] = SiswaModulAktif::where('user_id', $auth->id)->with('materi')->get();
                } else {
                    $data['modul_aktif'] = collect();
                }
            }
            return view('compact.index', $data);
        }
        $data['fee'] = ClassPaymentModel::select('class_payment.*', 'classes.title', 'users.name')
            ->join('classes', 'classes.id', 'class_payment.class_id')
            ->join('users', 'users.id', 'class_payment.user_id')
            ->where('class_payment.status', 1)
            ->get();
        foreach ($data['fee'] as $key => $value) {
            $f = FeeModel::where('class_id', 'like', '%"' . $value->title . '"%')->get();
            if ($f) {
                $value->data_fee = $f;
            } else {
                $value->data_fee = FeeModel::where('class_id', 'null')->get();
            }
        }

        $data['peserta'] = ClassParticipantModel::select('class_participant.*', 'users.name', 'users.google_id', 'classes.title', 'user_profile.phone', 'user_profile.picture', 'users.corporate')
            ->join('users', 'users.id', 'class_participant.user_id')
            ->join('classes', 'classes.id', 'class_participant.class_id')
            ->leftJoin('user_profile', 'user_profile.user_id', 'class_participant.user_id')
            ->whereNotNull('users.corporate')
            ->get();
        // return $data;
        return view('backend.beranda', $data);
    }

    public function createSitemap()
    {
        SitemapGenerator::create(env('APP_URL'))->writeToFile(public_path('sitemap.xml'));
    }

    public function inputlogopurusahaan(Request $request)
    {
        if ($request->checked) {
            $d = DashboardModel::updateOrCreate([
                'id' => $request->id
            ], [
                'logo_perusahaan' => json_encode($request->checked)
            ]);

            if ($d) {
                return Redirect::back()->with('success', 'Data Tersimpan');
            }
            return Redirect::back()->with('info', 'Data Tidak Tersimpan');
        }
    }
}
