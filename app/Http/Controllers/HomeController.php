<?php

namespace App\Http\Controllers;

use App\Models\ClassesModel;
use App\Models\ClassPaymentModel;
use App\Models\DataPayment;
use App\Models\InstructorModel;
use App\Models\KategoriModel;
use App\Models\LokerModel;
use App\Models\MateriModel;
use App\Models\SiswaModulAktif;
use App\Models\SiswaProfile;
use App\Models\SubMateriModel;
use App\Models\User;
use App\Models\UserProfileModel;
use App\Support\AdminPanel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
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
            $rootEmails = ['cb@bankir.academy', 'root@root.root'];
            $operationalUsers = User::whereNotIn('email', $rootEmails);

            $data['total_bank'] = (clone $operationalUsers)->where('role', 4)->count();
            $data['total_sekolah'] = (clone $operationalUsers)->where('role', 5)->count();
            $data['total_siswa'] = (clone $operationalUsers)->where('role', 6)->count();
            $data['active_users'] = (clone $operationalUsers)->where('is_active', 1)->count();
            $data['inactive_users'] = (clone $operationalUsers)->where(function ($query) {
                $query->where('is_active', 0)->orWhereNull('is_active');
            })->count();
            $data['total_kategori'] = KategoriModel::count();
            $data['total_materi'] = MateriModel::count();
            $data['total_sub_materi'] = SubMateriModel::count();
            $data['total_kelas'] = ClassesModel::count();
            $data['active_kelas'] = ClassesModel::where('status', 1)->count();
            $data['total_instruktur'] = InstructorModel::count();
            $data['active_instruktur'] = InstructorModel::where('status', 1)->count();
            $data['total_loker'] = LokerModel::count();
            $data['active_loker'] = LokerModel::where('status', 1)->count();
            $data['payment_pending'] = DataPayment::where('status', DataPayment::STATUS_PENDING)->count();
            $data['payment_paid'] = DataPayment::where('status', DataPayment::STATUS_PAID)->count();
            $data['payment_canceled'] = DataPayment::where('status', DataPayment::STATUS_CANCELED)->count();
            $data['payment_revenue'] = DataPayment::where('status', DataPayment::STATUS_PAID)->sum('nominal');
            $data['class_payment_pending'] = ClassPaymentModel::where('status', 0)->count();
            $data['class_payment_paid'] = ClassPaymentModel::where('status', 1)->count();
            $bankirMemberIds = User::where('role', 2)->pluck('id');
            $data['total_bankir_members'] = $bankirMemberIds->count();
            $data['company_members'] = UserProfileModel::whereIn('user_id', $bankirMemberIds)
                ->where('tipe_membership', DataPayment::MEMBERSHIP_TYPE_COMPANY)
                ->count();
            $data['individual_members'] = UserProfileModel::whereIn('user_id', $bankirMemberIds)
                ->where('tipe_membership', DataPayment::MEMBERSHIP_TYPE_INDIVIDUAL)
                ->count();
            $data['active_bankir_members'] = UserProfileModel::whereIn('user_id', $bankirMemberIds)
                ->where('status_membership', DataPayment::STATUS_PAID)
                ->count();
            $data['bankir_payment_paid'] = DataPayment::whereIn('user_id', $bankirMemberIds)
                ->where('status', DataPayment::STATUS_PAID)
                ->count();
            $data['bankir_revenue'] = DataPayment::whereIn('user_id', $bankirMemberIds)
                ->where('status', DataPayment::STATUS_PAID)
                ->sum('nominal');
            $data['pending_beasiswa'] = SiswaProfile::where('beasiswa', 2)->count();
            $data['user_distribution'] = [
                'bank' => $data['total_bank'],
                'sekolah' => $data['total_sekolah'],
                'siswa' => $data['total_siswa'],
            ];
            $data['recent_activity'] = Activity::with('causer')->latest()->take(6)->get();
            $data['recent_payments'] = DataPayment::with('user')->latest()->take(5)->get();
            $data['user_bank'] = User::where('role', 4)
                ->whereNotIn('email', $rootEmails)
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
