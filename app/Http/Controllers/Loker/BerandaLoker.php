<?php

namespace App\Http\Controllers\Loker;

use App\Helper\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Models\LamaranModel;
use App\Models\LokerApply;
use App\Models\LokerModel;
use App\Models\PerusahaanModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BerandaLoker extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $auth = Auth::user();
        if (!$auth) {
            return Redirect::back()->with('akses', 'auth');
        }
        $x['provinsi'] = DB::table('provinsi')->orderBy('name')->get();
        if ($request->ajax()) {
            $data = [];
            $data['data'] = LokerModel::select(
                'loker.*',
                'users.name',
                'users.corporate',
                'users.google_id',
                'user_profile.picture',
                'user_profile.description'
            )
                ->join('users', 'users.id', 'loker.user_id')
                ->leftJoin('user_profile', 'user_profile.user_id', 'loker.user_id')
                ->leftJoin('perusahaan_models', 'perusahaan_models.id', 'loker.perusahaan_id')
                ->where(function ($query) use ($request) {
                    // if ($request->provinsi != 'Pilih') {
                    //     $query->where('loker.provinsi', $request->provinsi);
                    // }
                    if ($request->provinsi != 'Pilih') {
                        $query->where('perusahaan_models.provinsi', $request->provinsi);
                    }
                })
                ->where(function ($query) use ($request) {
                    // if ($request->kabupaten != 'Pilih') {
                    //     return $query->where('loker.kabupaten', $request->kabupaten);
                    // }
                    if ($request->kabupaten != 'Pilih') {
                        $query->where('perusahaan_models.kabupaten', $request->kabupaten);
                    }
                })
                ->whereDate('tanggal_awal', '<=', Carbon::now())
                ->whereDate('tanggal_akhir', '>=', Carbon::now())
                ->orderBy('tanggal_awal', 'desc')
                ->where('loker.status', 1)
                ->paginate(6);
            // foreach ($data['data'] as $key => $vv) {
            //     $vv->kota_name = DB::table('kota')->where('id', $vv->kabupaten)->first('name');
            // }
            return $data;
        }
        return view('front.loker.loker', $x);
    }
    public function index_admin()
    {
        $data = [];
        $auth = Auth::user();
        $data['provinsi'] = DB::table('provinsi')->orderBy('name')->get();
        $data['perusahaan'] = PerusahaanModel::get();
        $data['data'] = LokerModel::select(
            'loker.*',
            'users.name',
            'users.corporate',
            'users.google_id',
            'user_profile.picture',
            'user_profile.description'
        )
            ->join('users', 'users.id', 'loker.user_id')
            ->leftJoin('user_profile', 'user_profile.user_id', 'loker.user_id')
            ->where(function ($query) use ($auth) {
                if ($auth->role > 0) {
                    return $query->where('loker.user_id', $auth->id);
                }
            })
            ->get();
        $data['lokerskill'] = LokerModel::select('skill')->distinct('skill')->pluck('skill')->toArray();
        $data['lokertype'] = LokerModel::select('type')->distinct('type')->pluck('type')->toArray();
        // return $data;
        return view('backend.loker.loker', $data);
    }

    public function getkabupaten($data)
    {
        return DB::table('kota')->where('provinsi_id', $data)->get();
    }
    public function getkecamatan($data)
    {
        return DB::table('kecamatan')->where('kota_id', $data)->get();
    }
    public function getkelurahan($data)
    {
        return DB::table('kelurahan')->where('kecamatan_id', $data)->get();
    }

    public function apply(Request $request)
    {
        $l = LamaranModel::where('user_id', Auth::user()->id)->first();
        if (!$l) {
            return Redirect::back()->with('info', 'CV Tidak Ditemukan');
        }
        if ($l->is_approved == 0) {
            return Redirect::back()->with('info', 'CV Belum Di Approved oleh Admin');
        }
        $f = LokerApply::where('user_id', Auth::user()->id)
            ->where('loker_id', $request->class_id)
            ->get();
        if (count($f) > 0) {
            // return view('front.loker.successlamaran');
            return Redirect::back()->with('info', 'Lamaran Sudah Terkirim');
        }
        $l = LokerApply::create([
            'user_id' => Auth::user()->id,
            'loker_id' => $request->class_id
        ]);
        if ($l) {
            // return view('front.loker.successlamaran');
            return Redirect::back()->with('success', 'Lamaran Proses Terkirim');
        }
        // return view('front.loker.successlamaran');
        return Redirect::back()->with('info', 'Lamaran Gagal Terkirim');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function checkAuth()
    {
        $c = Auth::check() ? true : false;
        return $c;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        if (!$this->checkAuth()) {
            return Redirect::back()->with('info', 'Silahkan Login Dahulu')->withInput($request->all());
        }
        // return $request->all();
        $valid = Validator::make($request->all(), [
            'loker_title' => 'required',
            'loker_gaji_min' => 'required',
            // 'loker_gaji_max' => 'required',
            'loker_deskripsi' => 'required',
            'loker_jobdesk' => 'required',
            'loker_tanggal_awal' => 'required',
            'loker_tanggal_akhir' => 'required',
            'loker_skill' => 'required',
            'loker_type' => 'required',
            'perusahaan_id' => 'required',
        ]);
        //response error validation
        if ($valid->fails()) {
            return Redirect::back()->withErrors($valid)->withInput($request->all())->with('error', 'Data Tidak Sesuai');
        }

        $val = [
            'id' => $request->loker_id,
        ];
        $data = [
            // 'alamat' => $request->loker_alamat,
            // 'email' => $request->loker_email,
            // 'nama' => $request->loker_nama,
            'title' => $request->loker_title,
            'perusahaan_id' => json_decode($request->perusahaan_id)->id,
            'gaji_min' => $request->loker_gaji_min,
            'gaji_max' => 0,
            'deskripsi' => $request->loker_deskripsi,
            'jobdesk' => $request->loker_jobdesk,
            'tanggal_awal' => $request->loker_tanggal_awal,
            'tanggal_akhir' => $request->loker_tanggal_akhir,
            'skill' => json_encode($request->loker_skill),
            'type' => json_encode($request->loker_type),
            'status' => $request->status ? $request->status : 0,
            // 'provinsi' => $request->provinsi,
            // 'kabupaten' => $request->kabupaten,
            // 'kecamatan' => $request->kecamatan,
            // 'kelurahan' => $request->kelurahan,
        ];
        if (!$request->loker_id) {
            $data['user_id'] = Auth::user()->id;
        }
        if ($request->filClassesImage) {
            $namemeta_image = $request->file('filClassesImage')->getClientOriginalName();
            $sizemeta_image = $request->file('filClassesImage')->getSize();
            if ($sizemeta_image >= 1048576) {
                return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB');
            }
            $filename2 = time() . '-' . $namemeta_image;
            $file = $request->file('filClassesImage');
            $file->move(public_path('image/loker'), $filename2);
            $data['image'] = json_encode([
                'url' => $filename2,
                'size' => $sizemeta_image
            ]);
        }

        $l = LokerModel::updateOrCreate($val, $data);
        if ($l) {
            return Redirect::back()->with('success', 'Data Tersimpan');
        }
        return Redirect::back()->with('info', 'Data Gagal Tersimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function detail($id)
    {
        $auth = Auth::user();
        if (!$auth) {
            return Redirect::back()->with('akses', 'auth');
        }
        $next = GlobalHelper::getaksesmembership();
        if (!$next) {
            return Redirect::back()->with('akses', 'member');
        }
        $data = [];
        $data['data'] = LokerModel::select(
            'loker.*',
            'users.name',
            'users.google_id',
            'users.corporate',
            'user_profile.picture',
            'user_profile.description'
        )
            ->join('users', 'users.id', 'loker.user_id')
            ->leftJoin('user_profile', 'user_profile.user_id', 'loker.user_id')
            ->where('loker.status', 1)
            ->where('loker.id', $id)
            ->first();
        if (!$data['data']) {
            return Redirect::back()->with('info', 'Data Tidak Ditemukan');
        }
        $data['lain'] = LokerModel::select(
            'loker.*',
            'users.name',
            'users.google_id',
            'users.corporate',
            'user_profile.picture',
            'user_profile.description'
        )
            ->join('users', 'users.id', 'loker.user_id')
            ->leftJoin('user_profile', 'user_profile.user_id', 'loker.user_id')
            ->where('loker.status', 1)
            ->where('loker.id', '!=', $id)
            ->limit(4)
            ->get();
        $name = 'Bankir Academy';
        if ($data['data']->corporate) {
            $x = json_decode($data['data']->corporate);
            if ($x) {
                if (property_exists($x, 'name')) {
                    $name = $x->name;
                }
            }
        }
        $html = [
            'title' => $data['data']->title,
            'dateposted' => Carbon::parse($data['data']->created_at)->format('Y-m-d'),
            'validThrough' => Carbon::parse($data['data']->created_at),
            'description' => $data['data']->deskripsi,
            'streetAddress' => '',
            'addressLocality' => '',
            'addressRegion' => '',
            'postalCode' => null,
            'name' => $name,
            'sameAs' => 'https://bankiracademy.com',
            'logo' => env('APP_URL') . '/' . $data['data']->picture,
        ];
        if ($data['data']->kecamatan != 'Pilih' && $data['data']->kecamatan != null) {
            $html['streetAddress'] = DB::table('kecamatan')
                ->where('id', $data['data']->kecamatan)
                ->first()->name;
        }
        if ($data['data']->kabupaten != 'Pilih' && $data['data']->kabupaten != null) {
            $html['addressLocality'] = DB::table('kota')
                ->where('id', $data['data']->kabupaten)
                ->first()->name;
        }
        if ($data['data']->provinsi != 'Pilih' && $data['data']->provinsi != null) {
            $html['addressRegion'] = DB::table('provinsi')
                ->where('id', $data['data']->provinsi)
                ->first()->name;
        }
        $data['lokergoogle'] = $html;
        // return $data;
        return view('front.loker.detail', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$this->checkAuth()) {
            return Redirect::back()->with('info', 'Silahkan Login Dahulu');
        }
        $l = LokerModel::where('id', $id)->delete();
        if ($l) {
            return Redirect::back()->with('success', 'Data Terhapus');
        }
        return Redirect::back()->with('info', 'Data Gagal Terhapus');
    }
}
