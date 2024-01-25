<?php

namespace App\Http\Controllers\Front;

use App\Helper\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Models\BannerModel;
use App\Models\ClassesModel;
use App\Models\ClassEventModel;
use App\Models\ClassLamanModel;
use App\Models\ClassParticipantModel;
use App\Models\ClassPartnerModel;
use App\Models\CorporateModel;
use App\Models\DashboardModel;
use App\Models\InstructorModel;
use App\Models\KodePromoModel;
use App\Models\LokerModel;
use App\Models\Pages;
use App\Models\RefferralModel;
use App\Models\RefferralPesertaModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class HomeController extends Controller
{

    public function apiberanda()
    {
        $data = [];
        $data['banner'] = [];
        $banner = BannerModel::where('jenis', '>', 0)
            ->where('mulai', '<=', Carbon::now()->format('Y-m-d'))
            ->where('selesai', '>=', Carbon::now()->format('Y-m-d'))
            ->limit(3)
            ->pluck('image')
            ->toArray();
        foreach ($banner as $key => $v) {
            array_push($data['banner'], 'https://bankiracademy.com/Image/' . $v);
        }
        $data['kelaspopuler'] = ClassesModel::select()
            ->where('date_end', '>=', Carbon::now())
            ->orderBy('date_end', 'DESC')
            ->first();
        return response()->json($data, 200);
    }
    public function index_custom()
    {
        return view('home');
    }
    public function paginateAjax($r)
    {
        $categori = ClassesModel::groupBy('category')->pluck('category')->toArray();
        $dx['kelas'] = [];
        $data['o']['owlCustom'] =
            '<div class="owl-item" style="margin:0px !important;">
            <div class="oc-item">
            <div class="portfolio-item">
                <div class="portfolio-image">
                    <button class="mr-2 Semua btn btn-outline-primary" style="border-radius: 10px; font-size:18px;"
                        onclick=tabsCategory("Semua")><small>Semua</small></button>
                </div>
            </div>
            </div>
        </div>';
        $data['o']['cateKelas'] = '';
        $data['o']['kelas'] = ['Semua'];
        $next_page_url = null;
        $dx['kelas']['Semua'] = ClassesModel::where('date_end', '>=', Carbon::now()->format('Y-m-d'))->where('status', 1)->orderBy('date_end', 'asc')->paginate(9)->toArray();
        // $semua = '<div id="Semua" class="row tabsCustom mt-2" hidden>';
        $semua = '';
        $kelas = [];
        foreach ($categori as $key => $value) {
            $dx['kelas'][$value] = ClassesModel::where('date_end', '>=', Carbon::now()->format('Y-m-d'))->where('category', $value)->where('status', 1)->paginate(9)->toArray();
            $data['o']['kelas'][] = preg_replace('/\s+/', '', $value);
            $owl = '';
            $owl .= '<div class="owl-item" style="margin:0px !important;">';
            $owl .= '    <div class="oc-item">';
            $owl .= '        <div class="portfolio-item">';
            $owl .= '            <div class="portfolio-image">';
            $owl .= '                <button class="mr-2 ' . preg_replace('/\s+/', '', $value) . ' btn btn-outline-primary" style="border-radius: 10px;font-size:18px;"';
            $owl .= '                    onclick=tabsCategory("' . preg_replace('/\s+/', '', $value) . '")><small>' . $value . '</small></button>';
            $owl .= '            </div>';
            $owl .= '        </div>';
            $owl .= '    </div>';
            $owl .= '</div>';
            $data['o']['owlCustom'] .= $owl;
            // array_push($data['o']['cateKelas'], '<div id="' . preg_replace('/\s+/', '', $value) . '" class="row tabsCustom mt-2" hidden></div>');
            $html = '';

            // $html .= '<div id="' . preg_replace('/\s+/', '', $value) . '" class="row tabsCustom mt-2" hidden>';
            if ($dx['kelas'][$value]['next_page_url']) {
                $next_page_url = $dx['kelas'][$value]['next_page_url'];
            }
            foreach ($dx['kelas'][$value]['data'] as $k => $v) {
                $tglawal = $v['date_start'];
                $tglakhir = $v['date_end'];
                if (count($v['event_list']) > 0) {
                    $tglawal = $v['event_list'][0]->time_start;
                    $tglakhir = $v['event_list'][count($v['event_list']) - 1]->time_end;
                }
                $html .= '<div class="col-lg-4 col-sm-6 mb-4">';
                $html .= '    <div class="card">';
                $html .= '        <div class="card-body" style="min-height: 708px !important">';
                $html .= '            <div class="card" style="min-height: 340px !important">';
                $html .= '                <img src="' . $v['image'] . '" width=100%>';
                $html .= '            </div>';
                $html .= '            <div style="position: absolute; bottom: 30px; left: 30px; right: 30px;">';
                $html .= '            <h5 class="text-uppercase mt-2" style="margin-bottom: 0px !important; font-size:15px !important;">' . $v['title'] . '</h5>';
                if (Carbon::parse($tglawal)->format('d-m-Y') == Carbon::parse($tglakhir)->format('d-m-Y')) {
                    $html .= '<p class="text-left" style="margin: 0px !important; font-size:10px !important;>' . Carbon::parse($tglawal)->format('d-m-Y') . '</p>';
                } else {
                    $html .= '<p class="text-left" style="margin: 0px !important; font-size:10px !important;>' . Carbon::parse($tglawal)->format('d-m-Y') . ' - ' . Carbon::parse($tglakhir)->format('d-m-Y') . '</p>';
                }
                $html .= '            <a href="/profile-instructor/' . $v['instructor_list'][0]->id . '/' . $v['instructor_list'][0]->name . '" class="d-flex mt-2">';
                if (json_decode($v['instructor_list'][0]->picture)) {
                    $html .= '                <img class="mr-3 rounded-circle"';
                    $html .= '                    src="Image/' . json_decode($v['instructor_list'][0]->picture)->url . '" alt=Generic placeholder image style="max-width:50px; max-height:50px;">';
                }
                $html .= '                <div class=>';
                $html .= '                    <small class="d-block mb-0">INSTRUCTOR</small>';
                $html .= '                    <h5 class="text-uppercase d-block mb-0">' . $v['instructor_list']['0']->name . '</h5>';
                $html .= '                    <small class="text-uppercase d-block mb-0" style="font-size:10px !important">' . $v['instructor_list'][0]->title . '</small>';
                $html .= '                </div>';
                $html .= '                <div class="ml-2 flex-fill">';
                $html .= '                    <label class="d-block mb-0"> Harga';
                $html .= '                    </label>';
                if ($v['pricing']) {
                    if ($v['pricing']->promo) {
                        $html .= '<del> Rp. ' . number_format($v['pricing']->price) . '</del>' . '<sup class="badge badge-danger" style="font-size: 8px">' . number_format(($v['pricing']->promo_price / $v['pricing']->price) * 100) . ' %</sup>';
                    } else {
                        $html .= '<small> Rp. ' . number_format($v['pricing']->price) . '</small>';
                    }
                } else {
                    $html .= '<small> Rp. -</small>';
                }
                $html .= '                </div>';
                $html .= '            </a>';
                $html .= '            <div class="text-center mt-2 w-100">';
                if ($v['pricing']) {
                    if ($v['pricing']->promo) {
                        $html .=
                            '<h3 style=" color:#139700 !important;"> Rp. ' . number_format($v['pricing']->price - $v['pricing']->promo_price) . '</h3>';
                    } else {
                        $html .=
                            '<h3 style=" color:#139700 !important;"> Rp. ' . number_format($v['pricing']->price) . '</h3>';
                    }
                } else {
                    $html .=
                        '<h3 style=" color:#139700 !important;"> Rp. -</h3>';
                }
                $html .=
                    '                <a class="btn btn-primary btn-block btn-rounded mt-auto"';
                $html .=
                    '                    style="border-radius:10px !important"';
                $html .= '                    href="class/' . $v['unique_id'] .
                    '/' . str_replace('/', '-', $v['title']) . '">';
                $html .= '                    Detail';
                $html .= '                </a>';
                $html .= '            </div>';
                $html .= '        </div>';
                $html .= '        </div>';
                $html .= '    </div>';
                $html .= '</div>';
            }
            $kelas[$value] = $html;
            // $html .= '</div>';
            // $semua .= $html;
            $data['o']['cateKelas'] .= $html;
        }
        foreach ($dx['kelas']['Semua']['data'] as $key => $v) {
            if ($dx['kelas']['Semua']['next_page_url']) {
                $next_page_url = $dx['kelas']['Semua']['next_page_url'];
            }
            $tglawal = $v['date_start'];
            $tglakhir = $v['date_end'];
            if (count($v['event_list']) > 0) {
                $tglawal = $v['event_list'][0]->time_start;
                $tglakhir = $v['event_list'][count($v['event_list']) - 1]->time_end;
            }
            $semua .= '<div class="col-lg-4 col-sm-6 mb-4">';
            $semua .= '    <div class="card">';
            $semua .= '        <div class="card-body" style="min-height: 708px !important">';
            $semua .= '            <div class="card" style="min-height: 340px !important">';
            $semua .= '                <img src="' . $v['image'] . '" width=100%>';
            $semua .= '            </div>';
            $semua .= '            <div class="" style="position: absolute; bottom: 30px; left: 30px; right: 30px;">';
            $semua .= '            <h5 class="text-uppercase mt-2" style="margin-bottom: 0px !important; font-size:15px !important;">' . $v['title'] . '</h5>';
            if (Carbon::parse($tglawal)->format('d-m-Y') == Carbon::parse($tglakhir)->format('d-m-Y')) {
                $semua .= '<p class="text-left" style="margin: 0px !important; font-size:10px !important;">' . Carbon::parse($tglawal)->format('d-m-Y') . '</p>';
            } else {
                $semua .= '<p class="text-left" style="margin: 0px !important; font-size:10px !important;">' . Carbon::parse($tglawal)->format('d-m-Y') . ' - ' . Carbon::parse($tglakhir)->format('d-m-Y') . '</p>';
            }
            $semua .= '            <a href="/profile-instructor/' . $v['instructor_list'][0]->id . '/' . $v['instructor_list'][0]->name . '" class="d-flex mt-2">';
            if (json_decode($v['instructor_list'][0]->picture)) {
                $semua .= '                <img class="mr-3 rounded-circle"';
                $semua .= '                    src="Image/' . json_decode($v['instructor_list'][0]->picture)->url . '" alt=Generic placeholder image style="max-width:50px; max-height:50px;">';
            }
            $semua .= '                <div class="text-left">';
            $semua .= '                    <small class="d-block mb-0">INSTRUCTOR</small>';
            $semua .= '                    <h5 class="text-uppercase d-block mb-0">' . $v['instructor_list']['0']->name . '</h5>';
            $semua .= '                    <small class="text-uppercase d-block mb-0" style="font-size:10px !important">' . $v['instructor_list'][0]->title . '</small>';
            $semua .= '                </div>';
            $semua .= '                <div class="ml-2 flex-fill text-center">';
            $semua .= '                    <label class="d-block mb-0"> Harga';
            $semua .= '                    </label>';
            if ($v['pricing']) {
                if ($v['pricing']->promo) {
                    $semua .= '<del> Rp. ' . number_format($v['pricing']->price) . '</del>' . '<sup class="badge badge-danger" style="font-size: 8px">' . number_format(($v['pricing']->promo_price / $v['pricing']->price) * 100) . ' %</sup>';
                } else {
                    $semua .= '<small> Rp. ' . number_format($v['pricing']->price) . '</small>';
                }
            } else {
                $semua .= '<small> Rp. -</small>';
            }
            $semua .= '                </div>';
            $semua .= '            </a>';
            $semua .= '            <div class="text-center mt-2 w-100">';
            if ($v['pricing']) {
                if ($v['pricing']->promo) {
                    $semua .=
                        '<h3 class="text-primary mb-2"> Rp. ' . number_format($v['pricing']->price - $v['pricing']->promo_price) . '</h3>';
                } else {
                    $semua .=
                        '<h3 class="text-primary mb-2"> Rp. ' . number_format($v['pricing']->price) . '</h3>';
                }
            } else {
                $semua .=
                    '<h3 class="text-primary mb-2"> Rp. -</h3>';
            }
            $semua .=
                '                <a class="btn btn-primary btn-block btn-rounded mt-auto"';
            $semua .=
                '                    style="border-radius:10px !important"';
            $semua .= '                    href="class/' . $v['unique_id'] .
                '/' . str_replace('/', '-', $v['title']) . '">';
            $semua .= '                    Detail';
            $semua .= '                </a>';
            $semua .= '            </div>';
            $semua .= '            </div>';
            $semua .= '        </div>';
            $semua .= '    </div>';
            $semua .= '</div>';
        }
        $kelas['Semua'] = $semua;
        // $semua .= '</div>';
        // $data['o']['cateKelas'] .= $semua;
        // $kelas['next_page_url'] = $r['page'] + 1;

        return $kelas;
        // return $dx;
    }
    public function indexv2($request)
    {
        $now = Carbon::now();
        $data['carisearch'] = null;
        if ($request->carisearch) {
            $data['carisearch'] = $request->carisearch;
        }
        if ($request->ajax()) {
            $data['kelas'] = ClassesModel::where('date_end', '>=', $now->format('Y-m-d'))
                ->where('status', 1)
                ->where(function ($query) use ($data) {
                    if ($data['carisearch'] !== 'null') {
                        $query->where('category', $data['carisearch']);
                    }
                })
                ->orderBy('date_end', 'asc')
                ->paginate(9)
                ->toArray();
            return response()->json([
                'success' => true,
                'msg' => 'Data Terkirim',
                'data' => $data,
            ], 200);
        }
        $data['banner_promo'] = [];
        $data['banner_bawah'] = [];
        $data['banner_slide'] = [];
        $data['banner_slide_mobile'] = [];
        $banner = BannerModel::where('mulai', '<=', $now->format('Y-m-d'))->where('selesai', '>=', $now->format('Y-m-d'))->orderBy('nama', 'ASC')->get();
        foreach ($banner as $key => $value) {
            if ($value->jenis == 0) {
                array_push($data['banner_slide'], $value);
            }
            if ($value->jenis == 1) {
                array_push($data['banner_bawah'], $value);
            }
            if ($value->jenis == 2) {
                array_push($data['banner_promo'], $value);
            }
            if ($value->jenis == 3) {
                array_push($data['banner_slide_mobile'], $value);
            }
        }
        $data['categori'] = ClassesModel::groupBy('category')->pluck('category')->toArray();

        $data['kelas_populer'] = [];
        $data['kelas_lama'] = ClassesModel::select()
            ->where('date_end', '<', $now->format('Y-m-d'))
            ->where('status', 1)
            ->orderBy('date_end', 'asc')
            ->limit(8)
            ->get();
        $data['kelas'] = ClassesModel::select()
            ->where('date_end', '>=', $now->format('Y-m-d'))
            // ->whereMonth('date_end',  $now->month)
            // ->whereYear('date_end',  $now->year)
            ->where('status', 1)
            ->orderBy('date_end', 'asc')
            ->get();
        foreach ($data['kelas'] as $key => $value) {
            if ($value->total_peserta > 3) {
                array_push($data['kelas_populer'], $value);
            }
        }
        $data['loker'] = LokerModel::select(
            'loker.*',
            'users.name',
            'users.corporate',
            'users.google_id',
            'user_profile.picture',
            'user_profile.description',
        )
            ->join('users', 'users.id', 'loker.user_id')
            ->leftJoin('user_profile', 'user_profile.user_id', 'loker.user_id')
            ->where('loker.status', 1)
            // ->whereDate('loker.tanggal_awal', '<=', Carbon::now())
            // ->whereDate('loker.tanggal_akhir', '>=', Carbon::now())
            ->orderBy('loker.tanggal_akhir', 'asc')
            ->limit(4)
            ->get();
        foreach ($data['loker'] as $key => $vv) {
            $vv->kota_name = DB::table('kota')->where('id', $vv->kabupaten)->first('name');
        }
        $data['testimoni'] = ClassParticipantModel::select('class_participant.*', 'user_profile.name', 'user_profile.picture')
            ->join('user_profile', 'user_profile.user_id', 'class_participant.user_id')
            ->where('class_participant.review_active', 1)
            ->get();
        // return $data;
        return view('front.homev2.homev2', $data);
    }
    public function index(Request $request)
    {
        return $this->indexv2($request);
        // return $this->index_custom();
        $data = [];
        $data['logo_perusahaan'] = DashboardModel::select()->first();
        $data['class_upcoming'] = [];
        for ($i = 0; $i < 3; $i++) {
            $now = Carbon::now()->locale('id_ID');
            $data['class_upcoming'][$now->addMonths($i)->monthName] = ClassesModel::select()
                ->whereMonth('date_end', Carbon::now()
                    ->addMonths($i)->month)
                ->whereYear('date_end', Carbon::now()->year)
                ->where('status', 1)
                ->get();
        }
        $now = Carbon::now()->locale('id_ID');
        // return $data;
        $kelas_mingguan = [];
        $data['banner_promo'] = BannerModel::where('jenis', 2)->where('mulai', '<=', $now->format('Y-m-d'))->where('selesai', '>=', $now->format('Y-m-d'))->orderBy('nama', 'ASC')->get();
        $data['banner_bawah'] = BannerModel::where('jenis', 1)->where('mulai', '<=', $now->format('Y-m-d'))->where('selesai', '>=', $now->format('Y-m-d'))->orderBy('nama', 'ASC')->get();
        $data['banner_slide'] = BannerModel::where('jenis', 0)->where('mulai', '<=', $now->format('Y-m-d'))->where('selesai', '>=', $now->format('Y-m-d'))->orderBy('nama', 'ASC')->get();
        $data['banner_slide_mobile'] = BannerModel::where('jenis', 3)->where('mulai', '<=', $now->format('Y-m-d'))->where('selesai', '>=', $now->format('Y-m-d'))->orderBy('nama', 'ASC')->get();
        $data['minggu_ini'] = ClassesModel::whereBetween("date_start", [
            // $now->startOfWeek()->format('Y-m-d'), //This will return date in format like this: 2022-01-10
            // $now->endOfWeek()->format('Y-m-d')
            $now->format('Y-m-d'),
            $now->addDays(14)->format('Y-m-d')
        ])
            ->whereDate('date_start', '>=', Carbon::now())
            ->where('status', 1)
            ->orderBy('date_start', 'ASC')
            ->get();
        // return $data;
        $class = [];
        $empat = 4;
        if (count($data['minggu_ini']) > 3) {
            foreach ($data['minggu_ini'] as $key => $value) {
                if ($key == $empat) {
                    array_push($kelas_mingguan, $class);
                    $class = [];
                    $empat += 4;
                }
                array_push($class, $value);
                if (($key + 1) == count($data['minggu_ini'])) {
                    array_push($kelas_mingguan, $class);
                }
            }
        } else {
            array_push($kelas_mingguan, $data['minggu_ini']);
        }
        $data['kelas_mingguan'] = $kelas_mingguan;
        $data['partner'] = ClassPartnerModel::get();
        $data['testimoni'] = ClassParticipantModel::select('class_participant.*', 'user_profile.name', 'user_profile.picture')
            ->join('user_profile', 'user_profile.user_id', 'class_participant.user_id')
            ->where('class_participant.review_active', 1)
            ->get();
        $categori = ClassesModel::groupBy('category')->pluck('category')->toArray();
        $data['kelas'] = [];
        $data['lucas'] = ClassesModel::where('date_end', '>=', Carbon::now()->format('Y-m-d'))->limit(6)->get();

        if ($request->ajax()) {
            $dx = $this->paginateAjax($request->all());
            return response()->json($dx);
        }

        $dx['kelas'] = [];
        $data['o']['owlCustom'] =
            '<div class="owl-item" style="margin:0px !important;">
                <div class="oc-item">
                <div class="portfolio-item">
                    <div class="portfolio-image">
                        <button class="mr-2 Semua btn btn-outline-primary" style="border-radius: 10px; font-size:18px;"
                            onclick=tabsCategory("Semua")><small>Semua</small></button>
                    </div>
                </div>
                </div>
            </div>';
        $data['o']['cateKelas'] = '';
        $data['o']['kelas'] = ['Semua'];
        $dx['kelas']['Semua'] = ClassesModel::where('date_end', '>=', Carbon::now()->format('Y-m-d'))->where('status', 1)->orderBy('date_end', 'asc')->paginate(9)->toArray();
        $semua = '<div id="Semua" class="row tabsCustom mt-2" hidden>';
        foreach ($categori as $key => $value) {
            $rep = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $value);
            $replace = preg_replace('/\s+/', '', $rep);
            $data['o']['kelas'][] = $replace;
            $owl = '';
            $dx['kelas'][$value] = ClassesModel::where('date_end', '>=', Carbon::now()->format('Y-m-d'))->where('category', $value)->where('status', 1)->paginate(9)->toArray();
            $owl .= '<div class="owl-item" style="margin:0px !important;">';
            $owl .= '    <div class="oc-item">';
            $owl .= '        <div class="portfolio-item">';
            $owl .= '            <div class="portfolio-image">';
            $owl .= '                <button class="mr-2 ' . $replace . ' btn btn-outline-primary" style="border-radius: 10px;font-size:18px;"';
            $owl .= '                    onclick=tabsCategory("' . $replace . '")><small>' . $value . '</small></button>';
            $owl .= '            </div>';
            $owl .= '        </div>';
            $owl .= '    </div>';
            $owl .= '</div>';
            $data['o']['owlCustom'] .= $owl;
            // array_push($data['o']['cateKelas'], '<div id="' . $replace . '" class="row tabsCustom mt-2" hidden></div>');
            $html = '';

            $html .= '<div id="' . $replace . '" class="row tabsCustom mt-2" hidden>';
            foreach ($dx['kelas'][$value]['data'] as $k => $v) {
                $tglawal = $v['date_start'];
                $tglakhir = $v['date_end'];
                if (count($v['event_list']) > 0) {
                    $tglawal = $v['event_list'][0]->time_start;
                    $tglakhir = $v['event_list'][count($v['event_list']) - 1]->time_end;
                }
                $tglawal = $v['date_start'];
                $tglakhir = $v['date_end'];
                if (count($v['event_list']) > 0) {
                    $tglawal = $v['event_list'][0]->time_start;
                    $tglakhir = $v['event_list'][count($v['event_list']) - 1]->time_end;
                }
                $html .= '<div class="col-lg-4 col-sm-6 mb-4">';
                $html .= '    <div class="card">';
                $html .= '        <div class="card-body" style="min-height: 708px !important">';
                $html .= '            <div class="card" style="min-height: 340px !important">';
                $html .= '                <img src="' . $v['image'] . '" width=100%>';
                $html .= '            </div>';
                $html .= '            <div class="" style="position: absolute; bottom: 30px; left: 30px; right: 30px;">';
                $html .= '            <h5 class="text-uppercase mt-2" style="margin-bottom: 0px !important; font-size:15px !important;">' . $v['title'] . '</h5>';
                if (Carbon::parse($tglawal)->format('d-m-Y') == Carbon::parse($tglakhir)->format('d-m-Y')) {
                    $html .= '<p class="text-left" style="margin: 0px !important; font-size:10px !important;">' . Carbon::parse($tglawal)->format('d-m-Y') . '</p>';
                } else {
                    $html .= '<p class="text-left" style="margin: 0px !important; font-size:10px !important;">' . Carbon::parse($tglawal)->format('d-m-Y') . ' - ' . Carbon::parse($tglakhir)->format('d-m-Y') . '</p>';
                }
                $html .= '            <a href="/profile-instructor/' . $v['instructor_list'][0]->id . '/' . $v['instructor_list'][0]->name . '" class="d-flex mt-2">';
                if (json_decode($v['instructor_list'][0]->picture)) {
                    $html .= '                <img class="mr-3 rounded-circle"';
                    $html .= '                    src="Image/' . json_decode($v['instructor_list'][0]->picture)->url . '" alt=Generic placeholder image style="max-width:50px; max-height:50px;">';
                }
                $html .= '                <div class="text-left">';
                $html .= '                    <small class="d-block mb-0">INSTRUCTOR</small>';
                $html .= '                    <h5 class="text-uppercase d-block mb-0">' . $v['instructor_list']['0']->name . '</h5>';
                $html .= '                    <small class="text-uppercase d-block mb-0" style="font-size:10px !important">' . $v['instructor_list'][0]->title . '</small>';
                $html .= '                </div>';
                $html .= '                <div class="ml-2 flex-fill text-center">';
                $html .= '                    <label class="d-block mb-0"> Harga';
                $html .= '                    </label>';
                if ($v['pricing']) {
                    if ($v['pricing']->promo) {
                        $html .= '<del> Rp. ' . number_format($v['pricing']->price) . '</del>' . '<sup class="badge badge-danger" style="font-size: 8px">' . number_format(($v['pricing']->price / $v['pricing']->promo_price) * 100) . ' %</sup>';
                    } else {
                        $html .= '<small> Rp. ' . number_format($v['pricing']->price) . '</small>';
                    }
                } else {
                    $html .= '<small> Rp. -</small>';
                }
                $html .= '                </div>';
                $html .= '            </a>';
                $html .= '            <div class="text-center mt-2 w-100">';
                if ($v['pricing']) {
                    if ($v['pricing']->promo) {
                        $html .=
                            '<h3 class="text-primary mb-2"> Rp. ' . number_format($v['pricing']->price - $v['pricing']->promo_price) . '</h3>';
                    } else {
                        $html .=
                            '<h3 class="text-primary mb-2"> Rp. ' . number_format($v['pricing']->price) . '</h3>';
                    }
                } else {
                    $html .=
                        '<h3 class="text-primary mb-2"> Rp. -</h3>';
                }
                $html .=
                    '                <a class="btn btn-primary btn-block btn-rounded mt-auto"';
                $html .=
                    '                    style="border-radius:10px !important"';
                $html .= '                    href="class/' . $v['unique_id'] .
                    '/' . str_replace('/', '-', $v['title']) . '">';
                $html .= '                    Detail';
                $html .= '                </a>';
                $html .= '            </div>';
                $html .= '            </div>';
                $html .= '        </div>';
                $html .= '    </div>';
                $html .= '</div>';
            }
            $html .= '</div>';
            // $semua .= $html;
            $data['o']['cateKelas'] .= $html;
        }
        foreach ($dx['kelas']['Semua']['data'] as $key => $v) {
            $tglawal = $v['date_start'];
            $tglakhir = $v['date_end'];
            if (count($v['event_list']) > 0) {
                $tglawal = $v['event_list'][0]->time_start;
                $tglakhir = $v['event_list'][count($v['event_list']) - 1]->time_end;
            }
            $semua .= '<div class="col-lg-4 col-sm-6 mb-4">';
            $semua .= '    <div class="card">';
            $semua .= '        <div class="card-body" style="min-height: 708px !important">';
            $semua .= '            <div class="card" style="min-height: 340px !important">';
            $semua .= '                <img src="' . $v['image'] . '" width=100%>';
            $semua .= '            </div>';
            $semua .= '            <div class="" style="position: absolute; bottom: 30px; left: 30px; right: 30px;">';
            $semua .= '            <h5 class="text-uppercase mt-2" style="margin-bottom: 0px !important; font-size:15px !important;">' . $v['title'] . '</h5>';
            if (Carbon::parse($tglawal)->format('d-m-Y') == Carbon::parse($tglakhir)->format('d-m-Y')) {
                $semua .= '<p class="text-left" style="margin: 0px !important; font-size:10px !important;">' . Carbon::parse($tglawal)->format('d-m-Y') . '</p>';
            } else {
                $semua .= '<p class="text-left" style="margin: 0px !important; font-size:10px !important;">' . Carbon::parse($tglawal)->format('d-m-Y') . ' - ' . Carbon::parse($tglakhir)->format('d-m-Y') . '</p>';
            }
            $semua .= '            <a href="/profile-instructor/' . $v['instructor_list'][0]->id . '/' . $v['instructor_list'][0]->name . '" class="d-flex mt-2">';
            if (json_decode($v['instructor_list'][0]->picture)) {
                $semua .= '                <img class="mr-3 rounded-circle"';
                $semua .= '                    src="Image/' . json_decode($v['instructor_list'][0]->picture)->url . '" alt=Generic placeholder image style="max-width:50px; max-height:50px;">';
            }
            $semua .= '                <div class="text-left">';
            $semua .= '                    <small class="d-block mb-0">INSTRUCTOR</small>';
            $semua .= '                    <h5 class="text-uppercase d-block mb-0">' . $v['instructor_list']['0']->name . '</h5>';
            $semua .= '                    <small class="text-uppercase d-block mb-0" style="font-size:10px !important">' . $v['instructor_list'][0]->title . '</small>';
            $semua .= '                </div>';
            $semua .= '                <div class="ml-2 flex-fill text-center">';
            $semua .= '                    <label class="d-block mb-0"> Harga';
            $semua .= '                    </label>';
            if ($v['pricing']) {
                if ($v['pricing']->promo) {
                    $semua .= '<del> Rp. ' . number_format($v['pricing']->price) . '</del>' . '<sup class="badge badge-danger" style="font-size: 8px">' . number_format(($v['pricing']->promo_price / $v['pricing']->price) * 100) . ' %</sup>';
                } else {
                    $semua .= '<small> Rp. ' . number_format($v['pricing']->price) . '</small>';
                }
            } else {
                $semua .= '<small> Rp. -</small>';
            }
            $semua .= '                </div>';
            $semua .= '            </a>';
            $semua .= '            <div class="text-center mt-2 w-100">';
            if ($v['pricing']) {
                if ($v['pricing']->promo) {
                    $semua .=
                        '<h3 class="text-primary mb-2"> Rp. ' . number_format($v['pricing']->price - $v['pricing']->promo_price) . '</h3>';
                } else {
                    $semua .=
                        '<h3 class="text-primary mb-2"> Rp. ' . number_format($v['pricing']->price) . '</h3>';
                }
            } else {
                $semua .=
                    '<h3 class="text-primary mb-2"> Rp. -</h3>';
            }
            $semua .=
                '                <a class="btn btn-primary btn-block btn-rounded mt-auto"';
            $semua .=
                '                    style="border-radius:10px !important"';
            $semua .= '                    href="class/' . $v['unique_id'] .
                '/' . str_replace('/', '-', $v['title']) . '">';
            $semua .= '                    Detail';
            $semua .= '                </a>';
            $semua .= '            </div>';
            $semua .= '            </div>';
            $semua .= '        </div>';
            $semua .= '    </div>';
            $semua .= '</div>';
        }
        $semua .= '</div>';
        $data['o']['cateKelas'] .= $semua;
        $data['o']['next_page'] = $dx['kelas']['Semua']['next_page_url'];
        $data['loker'] = LokerModel::select(
            'loker.*',
            'users.name',
            'users.corporate',
            'users.google_id',
            'user_profile.picture',
            'user_profile.description'
        )
            ->join('users', 'users.id', 'loker.user_id')
            ->leftJoin('user_profile', 'user_profile.user_id', 'loker.user_id')
            ->where('loker.status', 1)
            ->whereDate('loker.tanggal_awal', '<=', Carbon::now())
            ->whereDate('loker.tanggal_akhir', '>=', Carbon::now())
            ->orderBy('loker.tanggal_akhir', 'asc')
            ->limit(3)
            ->get();
        // return $dx['kelas']['Semua']['next_page_url'];
        // return $dx;
        return view(env('CUSTOM_HOME_PAGE', 'front.home.home'), $data);
    }

    public function detail_class($unique_id, $title)
    {
        // $next = GlobalHelper::getaksesmembership();
        // if (!$next) {
        //     return Redirect::back()->with('akses', 'member');
        // }
        $start = '';
        $end = '';
        $lokasi = '';
        $data['pop'] = ClassesModel::where('date_end', '>=', Carbon::now()->format('Y-m-d'))->where('unique_id', '!=', $unique_id)->limit(3)->get();
        $data['class'] = ClassesModel::where('unique_id', $unique_id)->first();
        $data['event'] = ClassEventModel::where('class_id', $data['class']->id)->get();

        foreach ($data['event'] as $key => $value) {
            if ($key == 0) {
                $start = $value->time_start;
                $lokasi = $value->location;
            }
            $end = $value->time_end;
        }
        $data['time_start'] = $start;
        $data['time_end'] = $end;
        $data['lokasi'] = $lokasi;
        $data['title'] = $title;

        $data['kelas_populer'] = ClassesModel::select()
            ->where('date_end', '>=', Carbon::now()
                ->format('Y-m-d'))
            ->limit(12)
            ->get();
        $data['literasi'] = Pages::where('type', 0)->whereDate('date_start', '<=', Carbon::now()->format('Y-m-d'))->whereDate('date_end', '>=', Carbon::now()->format('Y-m-d'))->limit(3)->get();
        // return $data;
        // return view('front.kelas.detail', $data);
        return view('front.kelasv2.detail', $data);
    }

    public function inputinstructor(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required',
            'nohp' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'dokumen' => 'required',
            'foto' => 'required',
        ]);
        //response error validation
        if ($valid->fails()) {
            return Redirect::back()->withErrors($valid)->withInput($request->all());
        }
        $dokumen = $request->file('dokumen')->getSize();
        if (($dokumen / 1024) > 1000) {
            return Redirect::back()->with('error', 'Size Maximum 1 Mb');
        }

        if ($request->foto) {
            $name = $request->file('foto')->getClientOriginalName(); // Name File
            $size = $request->file('foto')->getSize(); // Size File

            if ($size >= 1048576) {
                return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB');
            }

            $filename = time() . '-' . $name;
            $file = $request->file('foto');
            $file->move(public_path('Image/instructor/' . $request->nama), $filename);
        }
        $do = $request->file('dokumen')->store('instructor/' . $request->nama . '/' . time());
        $i = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'role' => 3,
        ]);
        if ($i) {
            InstructorModel::create([
                'name' => $request->nama,
                'title' => 'e-class ehr system',
                'picture' => json_encode(['url' => $filename, 'size' => $size]),
                'dokumen' => json_encode(['url' => $do, 'size' => $dokumen]),
                'desc' => $request->deskripsi,
                'alamat' => $request->alamat,
                'nohp' => $request->nohp,
                'user_id' => $i->id,
                'status' => 0,
            ]);
            return Redirect::to('/')->with('success', 'Pendaftaran Berhasil, Menunggu Konfirmasi Admin via Email');
        }
        return Redirect::back()->with('error', 'Pendaftaran Gagal')->withInput($request->all());
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect('/');
    }

    public function findOrCreateUser($socialUser, $provider)
    {
        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'google_id'  => $socialUser->getId(),
                'name'  => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'role' => 3,
            ]);
            $i = InstructorModel::create([
                'name' => $socialUser->getName(),
                'title' => 0,
                'picture' => $socialUser->getAvatar(),
                'desc' => 0,
                'user_id' => $user->id,
                'status' => 1,
                'dokumen' => 0,
                'alamat' => 0,
                'nohp' => 0,
            ]);
        }

        return $user;
    }

    public function getAllLaman()
    {
        $now = Carbon::now();
        $data['laman_head'] = ClassLamanModel::where('type', 1)->where('status', 1)->where('tgl_tayang', '<=', $now->format('Y-m-d'))->where('tgl_expired', '>=', $now->format('Y-m-d'))->orderBy('no_urut', 'asc')->get();
        $data['laman_footer'] = ClassLamanModel::where('type', 2)->where('status', 1)->where('tgl_tayang', '<=', $now->format('Y-m-d'))->where('tgl_expired', '>=', $now->format('Y-m-d'))->orderBy('no_urut', 'asc')->get();
        return $data;
    }

    public function laman($slug)
    {
        $l = [];
        $l['data'] = ClassLamanModel::where('slug', $slug)->first();
        // return $l;
        return view('front.home.laman', $l);
    }

    public function showAllPromo()
    {
        $now = Carbon::now();
        $data['data'] = BannerModel::where('jenis', 2)->where('mulai', '<=', $now->format('Y-m-d'))->where('selesai', '>=', $now->format('Y-m-d'))->paginate(12)->toArray();
        // $data['data'] = KodePromoModel::where('tgl_mulai', '<=', $now->format('Y-m-d'))->where('tgl_selesai', '>=', $now->format('Y-m-d'))->paginate(12)->toArray();
        // return $data;
        return view('front.allpromo', $data);
    }

    public function registerUser(Request $request)
    {
        $va = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        //response error validation
        if ($va->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $va->errors()
            ], 400);
        }

        if ($request->referral) {
            $r = RefferralPesertaModel::where('code', $request->referral)->first();
            if (!$r) {
                return response()->json([
                    'status' => 400,
                    'error' => ['referral' => 'Kode Referral Tidak Ditemukan']
                ], 400);
            }

            $u = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => 2,
                'password' => Hash::make($request->password),
            ]);
            if (!$u) {
                return response()->json([
                    'status' => 400,
                    'error' => ['register' => 'Register Gagal']
                ], 400);
            }
            Auth::login($u);
            RefferralModel::create([
                'user_id' => $r->user_id,
                'user_aplicator' => $u->id,
                'code' => $request->referral,
            ]);
            return response()->json([
                'status' => 200,
                'error' => ''
            ], 200);
        }

        $u = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 2,
            'password' => Hash::make($request->password),
        ]);
        if (!$u) {
            return response()->json([
                'status' => 400,
                'error' => ['register' => 'Register Gagal']
            ], 400);
        }
        Auth::login($u);
        return response()->json([
            'status' => 200,
            'error' => ''
        ], 200);
    }

    public function registercorporate(Request $r)
    {
        // {"name":"b","phone_region":62,"phone":"3456456","tanggal_lahir":"2022-11-01","gender":"1"}
        $va = Validator::make($r->all(), [
            'corporate' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        //response error validation
        if ($va->fails()) {
            return Redirect::back()->with('error', 'Register Failed!')->withErrors($va->errors())->withInput($r->all());
        }

        $c = CorporateModel::where('id', $r->corporate)->first();
        $co = [
            'jenis_corporate' => $r->jenis_corporate,
            'id_corporate' => $r->corporate,
            'name' => $c->nama,
            'phone_region' => 64,
            'phone' => $c->no_telp,
            'tanggal_lahir' => now(),
            'gender' => 1,
            'description' => 'Belum Ditentukan',
        ];

        $u = User::create([
            'name' => $r->name,
            'email' => $r->email,
            // 'google_id' => $r->google_id,
            'role' => 2,
            'password' => Hash::make($r->password),
            'corporate' => json_encode($co),
        ]);
        if ($u) {
            Auth::login($u);
            return Redirect::to('/profile')->with('success', 'Register Success!');
        }
        return Redirect::back()->with('error', 'Register Failed!')->withErrors($va->errors())->withInput($r->all());
    }
}
