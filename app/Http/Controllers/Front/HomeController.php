<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BannerModel;
use App\Models\ClassesModel;
use App\Models\ClassEventModel;
use App\Models\ClassPartnerModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $kelas_mingguan = [];
        $data['banner_promo'] = BannerModel::where('jenis', 2)->where('mulai', '<=', $now->format('Y-m-d'))->where('selesai', '>=', $now->format('Y-m-d'))->orderBy('nama', 'ASC')->get();
        $data['banner_bawah'] = BannerModel::where('jenis', 1)->where('mulai', '<=', $now->format('Y-m-d'))->where('selesai', '>=', $now->format('Y-m-d'))->orderBy('nama', 'ASC')->first();
        $data['banner_slide'] = BannerModel::where('jenis', 0)->where('mulai', '<=', $now->format('Y-m-d'))->where('selesai', '>=', $now->format('Y-m-d'))->orderBy('nama', 'ASC')->get();
        $data['pop'] = ClassesModel::limit(6)->get();
        $data['minggu_ini'] = ClassesModel::whereBetween("date_start", [
            $now->startOfWeek()->format('Y-m-d'), //This will return date in format like this: 2022-01-10
            $now->endOfWeek()->format('Y-m-d')
        ])
            ->whereDate('date_start', '>', Carbon::now())
            ->orderBy('date_start', 'ASC')
            ->get();
        $class = [];
        $empat = 4;
        if (count($data['minggu_ini']) > 3) {
            foreach ($data['minggu_ini'] as $key => $value) {
                if ($key == $empat) {
                    array_push($kelas_mingguan, $class);
                    $class = [];
                    $empat += 4;
                }
                if ($key == (count($data['minggu_ini']) - 1)) {
                    array_push($kelas_mingguan, $class);
                }
                array_push($class, $value);
            }
        } else {
            array_push($kelas_mingguan, $data['minggu_ini']);
        }
        $data['message'] = '';
        if (Auth::user()) {
            $data['message'] = 'Login Berhasil';
        }
        $data['kelas_mingguan'] = $kelas_mingguan;
        $data['partner'] = ClassPartnerModel::get();
        return view('front.home.home', $data);
    }

    public function detail_class($unique_id, $title)
    {
        $data['pop'] = ClassesModel::where('unique_id', '!=', $unique_id)->limit(3)->inRandomOrder()->get();
        $data['class'] = ClassesModel::where('unique_id', $unique_id)->first();
        $data['event'] = ClassEventModel::where('class_id', $data['class']->id)->get();

        return view('front.kelas.detail', $data);
    }
}
