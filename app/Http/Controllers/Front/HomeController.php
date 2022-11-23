<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BannerModel;
use App\Models\ClassesModel;
use App\Models\ClassEventModel;
use App\Models\ClassParticipantModel;
use App\Models\ClassPartnerModel;
use App\Models\InstructorModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();
        $kelas_mingguan = [];
        $data['banner_promo'] = BannerModel::where('jenis', 2)->where('mulai', '<=', $now->format('Y-m-d'))->where('selesai', '>=', $now->format('Y-m-d'))->orderBy('nama', 'ASC')->get();
        $data['banner_bawah'] = BannerModel::where('jenis', 1)->where('mulai', '<=', $now->format('Y-m-d'))->where('selesai', '>=', $now->format('Y-m-d'))->orderBy('nama', 'ASC')->get();
        $data['banner_slide'] = BannerModel::where('jenis', 0)->where('mulai', '<=', $now->format('Y-m-d'))->where('selesai', '>=', $now->format('Y-m-d'))->orderBy('nama', 'ASC')->get();
        $data['banner_slide_mobile'] = BannerModel::where('jenis', 3)->where('mulai', '<=', $now->format('Y-m-d'))->where('selesai', '>=', $now->format('Y-m-d'))->orderBy('nama', 'ASC')->get();
        $data['minggu_ini'] = ClassesModel::whereBetween("date_start", [
            $now->startOfWeek()->format('Y-m-d'), //This will return date in format like this: 2022-01-10
            $now->endOfWeek()->format('Y-m-d')
        ])
            ->whereDate('date_start', '>=', Carbon::now())
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
        // $data['kelas']['Semua'] = ClassesModel::where('date_end', '>=', Carbon::now()->format('Y-m-d'))->paginate(6)->toArray();
        // foreach ($categori as $key => $value) {
        //     $data['kelas'][$value] = ClassesModel::where('date_end', '>=', Carbon::now()->format('Y-m-d'))->where('category', $value)->paginate(6)->toArray();
        // }

        if ($request->ajax()) {
            $categori = ClassesModel::groupBy('category')->pluck('category')->toArray();
            $dx['kelas'] = [];
            $dx['kelas']['Semua'] = ClassesModel::where('date_end', '>=', Carbon::now()->format('Y-m-d'))->paginate(6)->toArray();
            foreach ($categori as $key => $value) {
                $dx['kelas'][$value] = ClassesModel::where('date_end', '>=', Carbon::now()->format('Y-m-d'))->where('category', $value)->paginate(6)->toArray();
            }
            return response()->json($dx);
        }
        // return $data;
        return view(env('CUSTOM_HOME_PAGE', 'front.home.home'), $data);
    }

    public function detail_class($unique_id, $title)
    {
        $data['pop'] = ClassesModel::where('date_end', '>=', Carbon::now()->format('Y-m-d'))->where('unique_id', '!=', $unique_id)->limit(3)->inRandomOrder()->get();
        $data['class'] = ClassesModel::where('unique_id', $unique_id)->first();
        $data['event'] = ClassEventModel::where('class_id', $data['class']->id)->get();
        // return $data;
        return view('front.kelas.detail', $data);
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
            $file->move(public_path('Image'), $filename);
        }
        $do = $request->file('dokumen')->store('instructor/' . Auth::user()->email . '/' . time());
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
}
