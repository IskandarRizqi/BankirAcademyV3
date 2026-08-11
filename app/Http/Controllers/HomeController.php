<?php

namespace App\Http\Controllers;

use App\Models\SiswaModulAktif;
use App\Models\SiswaProfile;
use App\Models\User;
use App\Support\AdminPanel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Sitemap\SitemapGenerator;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $auth = Auth::user();
        $isAdminRoot = AdminPanel::canAccess($auth);

        if (! $isAdminRoot && ! in_array($auth->role, [4, 5, 6])) {
            return redirect()->route('dash-beranda.index');
        }

        $data = [];

        if ($isAdminRoot) {
            $data['total_bank'] = User::where('role', 4)->count();
            $data['total_sekolah'] = User::where('role', 5)->count();
            $data['total_siswa'] = User::where('role', 6)->count();
            $data['user_bank'] = User::where('role', 4)
                ->latest()
                ->take(5)
                ->get();
        } elseif ($auth->role == 4) {
            $data['total_sekolah'] = User::where('role', 5)
                ->where('bank_id', $auth->id)
                ->count();
            $data['total_siswa'] = User::where('role', 6)
                ->where('bank_id', $auth->id)
                ->count();
            $data['daftar_sekolah'] = User::where('role', 5)
                ->where('bank_id', $auth->id)
                ->get()
                ->map(function ($sekolah) {
                    $sekolah->jumlah_siswa = User::where('role', 6)
                        ->where('sekolah_id', $sekolah->id)
                        ->count();

                    return $sekolah;
                });
        } elseif ($auth->role == 5) {
            $siswaIds = User::where('role', 6)
                ->where('sekolah_id', $auth->id)
                ->pluck('id');

            $data['total_siswa'] = $siswaIds->count();
            $data['total_beasiswa'] = SiswaProfile::whereIn('user_id', $siswaIds)
                ->where('beasiswa', 1)
                ->count();
            $data['total_tabungan_siswa'] = SiswaProfile::whereIn('user_id', $siswaIds)
                ->sum('saldo');
            $data['daftar_siswa'] = User::where('role', 6)
                ->where('sekolah_id', $auth->id)
                ->with('siswa')
                ->get();
        } else {
            if ($auth->bank_id) {
                $bank = User::find($auth->bank_id);

                if ($bank && $bank->masa_aktif_member) {
                    $expiryDate = Carbon::parse($bank->masa_aktif_member);

                    if ($expiryDate->isPast()) {
                        SiswaProfile::where('user_id', $auth->id)->delete();
                        $auth->role = 2;
                        $auth->save();

                        return redirect()->route('dash-beranda.index')
                            ->with('warning', 'Masa aktif membership Bank Anda telah berakhir. Role Anda telah diubah menjadi Peserta.');
                    }
                }
            }

            $siswaProfile = SiswaProfile::where('user_id', $auth->id)->first();
            $data['profile'] = $siswaProfile;

            if ((int) $auth->is_active === 0) {
                return view('compact.siswa.unverified', $data);
            }

            $data['saldo_siswa'] = $siswaProfile ? $siswaProfile->saldo : 0;
            $data['history'] = DB::table('history_pelatihan')
                ->join('sub_materi', 'history_pelatihan.sub_materi_id', '=', 'sub_materi.id')
                ->where('history_pelatihan.user_id', $auth->id)
                ->select(
                    'history_pelatihan.created_at as tanggal_mulai',
                    'sub_materi.id as sub_materi_id',
                    'sub_materi.nama as nama_sub',
                    'sub_materi.urutan'
                )
                ->latest('history_pelatihan.created_at')
                ->get();
            $data['total_materi'] = $data['history']->unique('nama_sub')->count();
            $data['total_bab'] = $data['history']->count();
            $data['modul_aktif'] = $siswaProfile && $siswaProfile->beasiswa == 1
                ? SiswaModulAktif::where('user_id', $auth->id)->with('materi')->get()
                : collect();
        }

        return view('compact.index', $data);
    }

    public function createSitemap()
    {
        SitemapGenerator::create(env('APP_URL'))->writeToFile(public_path('sitemap.xml'));
    }
}
