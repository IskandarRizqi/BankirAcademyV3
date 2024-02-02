<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BannerModel;
use App\Models\ClassesModel;
use App\Models\ClassEventModel;
use App\Models\ClassPaymentModel;
use App\Models\CorporateModel;
use App\Models\DataRekeningModel;
use App\Models\InstructorModel;
use App\Models\InstructorReviewModel;
use App\Models\KodePromoModel;
use App\Models\MasterRefferralModel;
use App\Models\RefferralModel;
use App\Models\RefferralPesertaModel;
use App\Models\User;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Helper\GlobalHelper;
use App\Models\LamaranModel;
use App\Models\LokerApply;
use App\Models\LokerModel;
use App\Models\MembershipModel;
use App\Models\PrepotesModel;
use App\Models\RefferralWithdrawModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Query\Processors\Processor;
use Illuminate\Support\Facades\Process;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        return $this->indexv2($r);
        $auth = Auth::user()->id;
        $data['user'] = User::where('id', Auth::user()->id)->first();
        $data['pfl'] = UserProfileModel::select('user_profile.*', 'referral.code')
            ->leftJoin('referral', 'referral.user_id', 'user_profile.user_id')
            ->where('user_profile.user_id', Auth::user()->id)
            ->first();
        $data['param'] = [];
        $data['param']['date'] = [Carbon::now()->submonth(3)->format('Y-m-d'), date('Y-m-d')];
        $data['param']['status'] = [0, 1];

        if ($r->param_date_start) {
            $data['param']['date'][0] = $r->param_date_start;
        }
        if ($r->param_date_end) {
            $data['param']['date'][1] = $r->param_date_end;
        }

        if ($r->param_checked_lunas) {
            $data['param']['status'] = $r->param_checked_lunas;
        }
        $data['count_payment'] = ClassPaymentModel::select()
            ->whereDate('class_payment.expired', '>=', Carbon::now()->format('Y-m-d'))
            ->where('class_payment.user_id', $auth)
            ->where('class_payment.status', 0)
            ->count();
        $data['payment'] = ClassPaymentModel::select(
            'class_payment.*',
            'classes.title',
            'classes.participant_limit',
            'class_participant.review',
            // 'class_participant.jumlah',
            'class_participant.id as participant_id'
        )
            ->join('classes', 'classes.id', 'class_payment.class_id')
            ->leftJoin('class_participant', 'class_participant.payment_id', 'class_payment.id')
            // ->where('class_participant.user_id', $auth)
            ->where('class_payment.user_id', $auth)
            ->whereDate('class_payment.created_at', '>=', $data['param']['date'][0])
            ->whereDate('class_payment.created_at', '<=', $data['param']['date'][1])
            ->whereIn('class_payment.status', $data['param']['status'])
            ->where(function ($q) {
                // return $q->where('class_payment.expired', '>=', date('Y-m-d H:i:s'))->orWhere('status', '1')->orWhereNotNull('file');
            })
            ->orderBy('class_payment.status', 'desc')
            ->orderBy('class_payment.updated_at', 'desc')
            ->get();
        $id_class = [];
        foreach ($data['payment'] as $key => $value) {
            array_push($id_class, $value->class_id);
        }
        $data['class'] = ClassPaymentModel::select(
            'class_payment.*',
            'class_participant.review',
            'class_participant.review_point',
            'class_participant.id as participant_id',
            'class_participant.jumlah',
        )
            ->join('class_participant', 'class_participant.payment_id', 'class_payment.id')
            ->where('class_payment.status', 1)
            ->whereDate('class_payment.created_at', '>=', $data['param']['date'][0])
            ->whereDate('class_payment.created_at', '<=', $data['param']['date'][1])
            ->where('class_payment.user_id', $auth)
            ->where('class_participant.user_id', $auth)
            ->orderBy('class_payment.created_at', 'desc')
            ->get();
        $data['poin'] = 0;
        foreach ($data['class'] as $key => $value) {
            $value->class = ClassesModel::select('title', 'instructor', 'date_start', 'date_end', 'id', 'poin')->where('id', $value->class_id)->get();
            $value->status_pembayaran = 0;
            foreach ($value->class as $key => $v) {
                $data['poin'] += $v->poin;
                foreach ($v->peserta_list['lunas'] as $key => $va) {
                    if ($va->user_id == $auth) {
                        $value->status_pembayaran = 1;
                    }
                }
            }
            $value->event = ClassEventModel::where('class_id', $value->class_id)->get();
        }
        $data['reff'] = RefferralPesertaModel::where('user_id', $auth)->first();
        $data['referralku'] = RefferralModel::select('referral.*', 'users.name')
            ->join('users', 'users.id', 'referral.user_aplicator')
            ->where('referral.user_id', $auth)
            ->get();
        $data['saldo'] = GlobalHelper::currentSaldoById($auth);
        $data['saldoProses'] = GlobalHelper::countSaldoProsesById($auth);
        $data['saldoPenarikan'] = GlobalHelper::currentSaldoPenarikanById($auth);
        $data['withdraw'] = RefferralWithdrawModel::where('user_id', $auth)->get();
        $data['prepotes'] = PrepotesModel::select('prepotes.*', 'prepotes_user.nilai_awal', 'prepotes_user.nilai_akhir')
            ->leftJoin('prepotes_user', 'prepotes_user.class_id', 'prepotes.class_id')
            ->whereIn('prepotes.class_id', $id_class)
            ->get();
        $data['loker'] = LokerModel::where('user_id', $auth)->get();
        $data['lamaran'] = LokerApply::with('lamaran')->where('user_id', $auth)->get();
        $data['lokerall'] = LokerModel::select()
            ->whereDate('tanggal_awal', '<=', Carbon::now())
            ->whereDate('tanggal_akhir', '>=', Carbon::now())
            ->orderBy('tanggal_akhir', 'asc')
            ->where('loker.status', 1)
            ->limit(3)
            ->get();
        $data['lokerskill'] = LokerModel::select('skill')->distinct('skill')->pluck('skill')->toArray();
        $data['lokertype'] = LokerModel::select('type')->distinct('type')->pluck('type')->toArray();
        $data['ismember'] = GlobalHelper::getaksesmembership();
        $data['member'] = MembershipModel::get();
        return view('front.profile.profile', $data);
    }

    public function indexv2($request)
    {
        $auth_id = Auth::user()->id;
        $data['user'] = User::where('id', $auth_id)->first();
        $data['pfl'] = UserProfileModel::select('user_profile.*', 'referral.code')
            ->leftJoin('referral', 'referral.user_id', 'user_profile.user_id')
            ->where('user_profile.user_id', $auth_id)
            ->first();
        $data['billingkelasall'] = $this->getbillingkelas(100);
        $data['getkelasanda'] = $this->getkelasanda(100);
        $data['reff'] = RefferralPesertaModel::where('user_id', $auth_id)->first();
        $data['referralku'] = RefferralModel::select('referral.*', 'users.name')
            ->join('users', 'users.id', 'referral.user_aplicator')
            ->where('referral.user_id', $auth_id)
            ->get();
        $data['saldo'] = GlobalHelper::currentSaldoById($auth_id);
        $data['saldoProses'] = GlobalHelper::countSaldoProsesById($auth_id);
        $data['saldoPenarikan'] = GlobalHelper::currentSaldoPenarikanById($auth_id);
        $data['withdraw'] = RefferralWithdrawModel::where('user_id', $auth_id)->get();
        $data['member'] = MembershipModel::orderBy('harga')->limit(3)->get();
        $data['lamaran'] = LokerApply::with('lamaran')->where('user_id', $auth_id)->get();
        $lokerid = []; // id loker yang pernah di apply
        foreach ($data['lamaran'] as $key => $value) {
            if (!in_array($value->loker_id, $lokerid)) {
                array_push($lokerid, $value->loker_id);
            }
        }
        $limitloker = 10;
        $data['loker'] = LokerModel::select()
            ->whereNotIn('id', $lokerid)
            ->limit($limitloker)
            ->get();
        return view('front.profilev2.index', $data);
    }

    public function getbillingkelas($type)
    {
        $status = 'Dibatalkan';
        $data['billingkelasall'] = ClassPaymentModel::select(
            'class_payment.*',
            'classes.title',
            'classes.participant_limit',
            'class_participant.review',
            'class_participant.id as participant_id'
        )
            ->join('classes', 'classes.id', 'class_payment.class_id')
            ->leftJoin('class_participant', 'class_participant.payment_id', 'class_payment.id')
            ->where('class_payment.user_id', Auth::user()->id)
            // ->whereDate('class_payment.created_at', '>=', $data['param']['date'][0])
            // ->whereDate('class_payment.created_at', '<=', $data['param']['date'][1])
            ->where(function ($query) use ($type) {
                if ($type == 0) {
                    return $query->where('class_payment.expired', '<', Carbon::now())->where('class_payment.status', 0);
                }
                if ($type == 1) {
                    return $query->whereNotNull('class_payment.file')->where('class_payment.status', 1);
                }
                if ($type == 2) {
                    return $query->whereNotNull('class_payment.file')->where('class_payment.status', 0);
                }
                if ($type == 3) {
                    return $query->where('class_payment.expired', '>', Carbon::now())->whereNull('class_payment.file')->where('class_payment.status', 0);
                }
            })
            ->orderBy('class_payment.status', 'desc')
            ->orderBy('class_payment.updated_at', 'desc')
            ->get();
        foreach ($data['billingkelasall'] as $key => $value) {
            if (!$value->file && $value->status == 0) {
                $status = 'Menunggu Pembayaran';
            }
            if ($value->file && $value->status == 0) {
                $status = 'Menunggu Konfirmasi';
            }
            if ($value->file && $value->status == 1) {
                $status = 'Lunas';
            }
            if ($value->expired < Carbon::now() && $value->status == 0) {
                $status = 'Expired';
            }
            $value->status_pembayaran = $status;
        }

        return response()->json([
            'status' => 1,
            'msg' => 'Data Success',
            'data' => $data
        ], 200);
    }

    public function getkelasanda($type)
    {
        $start = Carbon::now()->subYears(30)->format('Y-m-d');
        $end = Carbon::now()->addDay()->format('Y-m-d');
        $status = [1, 0];
        // Dalam Proses
        if ($type == 0) {
            $start = Carbon::now()->subDays(10)->format('Y-m-d');
            $status = [1];
        }
        // Menunggu Konfirmasi
        if ($type == 1) {
            $status = [0];
        }
        // Selesai
        if ($type == 2) {
            $start = Carbon::now()->subYears(10)->format('Y-m-d');
            $status = [1];
        }
        $data['getkelasanda'] = ClassPaymentModel::select(
            'class_payment.*',
            'classes.title',
            'classes.image',
            'classes.participant_limit',
            'class_participant.review',
            'class_participant.id as participant_id'
        )
            ->join('classes', 'classes.id', 'class_payment.class_id')
            ->leftJoin('class_participant', 'class_participant.payment_id', 'class_payment.id')
            ->where('class_payment.user_id', Auth::user()->id)
            ->whereBetween('class_payment.created_at', [$start, $end])
            ->whereIn('class_payment.status', $status)
            // ->whereDate('class_payment.created_at', '>=', Carbon::now()->subMonths(3)->format('Y-m-d'))
            // ->whereDate('class_payment.created_at', '<=', Carbon::now()->format('Y-m-d'))
            // ->whereIn('class_payment.status', $data['param']['status'])
            ->orderBy('class_payment.status', 'desc')
            ->orderBy('class_payment.updated_at', 'desc')
            ->get();
        return response()->json([
            'status' => 1,
            'msg' => 'Data Success',
            'data' => $data
        ], 200);
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

    public function saveCorporate($data)
    {
        $pesan = 'Simpan data gagal';
        // $c = CorporateModel::where('nama', $data->nama_lengkap)->first();
        $c = CorporateModel::updateOrCreate([
            'nama' => $data->nama_lengkap
        ], [
            'jenis' => $data->jenis_corporate
        ]);
        $insert = [
            'jenis_corporate' => $data->jenis_corporate,
            'id_corporate' => $c->id,
            'name' => $c->nama,
            'phone_region' => 62,
            'phone' => $data->nomor_handphone,
            'tanggal_lahir' => $data->tanggal_lahir,
            'gender' => 0,
            'description' => $data->alamat,
        ];
        if ($data->picture) {
            $name = $data->file('picture')->getClientOriginalName(); // Name File
            $size = $data->file('picture')->getSize(); // Size File

            if ($size >= 1048576) {
                return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB');
            }

            $filename = time() . '-' . $name;
            $file = $data->file('picture');
            $file->move(public_path('Image/Member'), $filename);
            // $d['picture'] = json_encode(['url' => $filename, 'size' => $size]);
            $insert['picture'] = 'Image/Member/' . $filename;
        }
        $p = UserProfileModel::updateOrCreate([
            'user_id' => Auth::user()->id
        ], $insert);
        if ($p) {
            User::where('id', Auth::user()->id)->update(['corporate' => json_encode($insert)]);
            // CorporateModel::create([
            //     'nama' => $c->nama,
            //     'no_telp' => $data->nomor_handphone,
            //     'alamat' => $data->alamat,
            //     'lokasi' => 'Belum Ditentukan',
            //     'jenis' => 'Belum Ditentukan',
            // ]);
            $pesan = 'Simpan data berhasil';
        }
        return $pesan;
    }

    public function store(Request $request)
    {
        // return $request->all();
        if ($request->iscorporate) {
            $pesan = $this->saveCorporate($request);
            return Redirect::back()->with('success', $pesan);
        }

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            // 'jenis_corporate' => 'required',
            // 'jenis_kelamin' => 'required',
            'nomor_handphone' => 'required|numeric',
            'alamat' => 'required',
            // 'tanggal_lahir' => 'required',
            'rekening' => 'required',
            // 'image_produk' => 'image|mimes:jpeg,png,jpg|max:2048|required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        // if ($request->referral) {
        //     $r = RefferralPesertaModel::where('code', $request->referral)->first();
        //     if (!$r) {
        //         return Redirect::back()->withInput($request->all())->with('referral', 'Kode Referral Tidak Ditemukan');
        //     }
        //     RefferralModel::updateOrCreate(
        //         [
        //             'user_id' => $r->user_id,
        //         ],
        //         [
        //             'user_aplicator' => $request->user_id,
        //             'code' => $request->referral,
        //         ]
        //     );
        // }

        // $c = CorporateModel::where('id', $request->jenis_corporate)->first();
        // $co = [
        //     'name' => $c->nama_lengkap,
        //     'phone_region' => 64,
        //     'phone' => $c->nomor_handphone,
        //     'tanggal_lahir' => now(),
        //     'gender' => 1,
        // ];

        $d = [
            'name' => $request->nama_lengkap,
            'phone' => $request->nomor_handphone,
            'rekening' => $request->rekening,
            'tanggal_lahir' => $request->tanggal_lahir,
            'gender' => $request->jenis_kelamin,
            'description' => $request->alamat,
            'instansi' => 'perorangan',
        ];

        if ($request->picture) {
            $name = $request->file('picture')->getClientOriginalName(); // Name File
            $size = $request->file('picture')->getSize(); // Size File

            if ($size >= 1048576) {
                return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB');
            }

            $filename = time() . '-' . $name;
            $file = $request->file('picture');
            $file->move(public_path('Image/Member'), $filename);
            // $d['picture'] = json_encode(['url' => $filename, 'size' => $size]);
            $d['picture'] = 'Image/Member/' . $filename;
        }

        // if ($request->company) {
        // }
        User::where('id', Auth::user()->id)->update([
            'corporate' => 'perorangan'
        ]);

        UserProfileModel::updateOrCreate([
            'user_id' => Auth::user()->id,
        ], $d);

        // return view('front.profile.profile');
        return redirect('/profile')->with('success', 'Berhasil memperbarui profile');
    }

    public function updateprofile(Request $r)
    {
        $u = UserProfileModel::updateOrCreate([
            'user_id' => Auth::user()->id,
        ], [
            'name' => $r->name,
            'description' => $r->description,
        ]);

        if ($u) {
            return response()->json([
                'status' => 1,
                'msg' => 'Data Tersimpan',
                'data' => UserProfileModel::where('user_id', Auth::user()->id)->first()
            ], 200);
        }
        return response()->json(
            [
                'status' => 0,
                'msg' => 'Data Tidak Tersimpan',
                'data' => []
            ],
            400
        );
    }

    public function settingprofile(Request $r)
    {
        $ins = [
            'name' => $r->name,
            'phone' => $r->no_hp,
            'jenis_kelamin' => $r->jenis_kelamin,
            'tanggal_lahir' => $r->tgl_lahir,
            'description' => $r->alamat,
        ];
        if ($r->gambar && $r->gambar != 'undefined') {
            $name = $r->file('gambar')->getClientOriginalName(); // Name File
            $size = $r->file('gambar')->getSize(); // Size File

            if ($size >= 1048576) {
                return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB');
            }

            $filename = time() . '-' . $name;
            $file = $r->file('gambar');
            $file->move(public_path('Image/Member'), $filename);
            // $d['profile_gambar'] = json_encode(['url' => $filename, 'size' => $size]);
            $ins['picture'] = 'Image/Member/' . $filename;
        }
        $u = UserProfileModel::updateOrCreate([
            'user_id' => Auth::user()->id,
        ], $ins);

        if ($u) {
            return response()->json([
                'status' => 1,
                'msg' => 'Data Tersimpan',
                'data' => UserProfileModel::where('user_id', Auth::user()->id)->first()
            ], 200);
        }
        return response()->json(
            [
                'status' => 0,
                'msg' => 'Data Tidak Tersimpan',
                'data' => []
            ],
            400
        );
    }
    public function rekeningprofile(Request $r)
    {
        $ins = [
            'nama_bank' => $r->nama_bank,
            'rekening' => $r->no_rekening,
        ];
        $u = UserProfileModel::updateOrCreate([
            'user_id' => Auth::user()->id,
        ], $ins);

        if ($u) {
            return response()->json([
                'status' => 1,
                'msg' => 'Data Tersimpan',
                'data' => UserProfileModel::where('user_id', Auth::user()->id)->first()
            ], 200);
        }
        return response()->json(
            [
                'status' => 0,
                'msg' => 'Data Tidak Tersimpan',
                'data' => []
            ],
            400
        );
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function profileinstructor($id, $name)
    {
        $p = InstructorModel::where('id', $id)->first();
        $review = InstructorReviewModel::select('instructor_review.*', 'users.name')
            ->join('users', 'users.id', 'instructor_review.users_id')
            ->where('instructor_review.instructor_id', $id)
            ->where('instructor_review.status', 1)
            ->get();
        return view('front.profile.instructor', [
            'data' => $p,
            'review' => $review
        ]);
    }

    public function addreviewinstructor(Request $request)
    {
        $auth = Auth::user();
        $validasi = InstructorReviewModel::where('users_id', $auth->id)->where('instructor_id', $request->instructor_id)->get();
        if (count($validasi) > 0) {
            InstructorReviewModel::where('users_id', $auth->id)->where('instructor_id', $request->instructor_id)->update([
                'review_msg' => $request->comment,
                'review_val' => $request->nilai,
            ]);
            return Redirect::back()->with('success', 'Update Review Berhasil');
        }
        $r = InstructorReviewModel::create([
            'instructor_id' => $request->instructor_id,
            'users_id' => $auth->id,
            'review_msg' => $request->comment,
            'review_val' => $request->nilai,
            'status' => 0,
        ]);
        if (!$r) {
            return view('front.profile.instructor')->with('error', 'Review Gagal Tersimpan');
        }
        return Redirect::back()->with('success', 'Review Berhasil Disimpan');
    }

    public function changestatusreview(Request $request)
    {
        $status = 0;
        if ($request->val_review == 'Tampil') {
            $status = 1;
        }
        $i = InstructorReviewModel::where('id', $request->id_review)->update([
            'status' => $status
        ]);
        if (!$i) {
            return Redirect::back()->with('error', 'Review Gagal Disimpan');
        }
        return Redirect::back()->with('success', 'Review Berhasil Disimpan');
    }
    public function review_instructor(Request $request)
    {
        $auth = Auth::user();
        $validasi = InstructorReviewModel::where('users_id', $auth->id)->where('instructor_id', $request->id_instructor)->get();
        return $validasi;
    }
    public function setKodePromo(Request $request)
    {
        $bp = BannerModel::where('jenis', 2)->where('kode', $request->kode)->where('mulai', '<', Carbon::now())->where('selesai', '>=', Carbon::now())->get();
        $kp = KodePromoModel::where('kode', $request->kode)->where('class_title', 'like', '%"' . urldecode($request->id) . '"%')->where('tgl_selesai', '>=', Carbon::now())->get();
        // $kp = KodePromoModel::where('kode', $kode_promo)->where('class_title', 'like', '%"' . $title_kelas . '"%')->where('tgl_selesai', '>=', Carbon::now())->get();
        if (count($kp) > 0) {
            ClassPaymentModel::where('id', $request->idpayment)->update([
                'kode_promo' => $request->kode,
            ]);
            return response()->json(['message' => 'Kode Promo Benar', 'status' => true]);
        }
        if (count($bp) > 0) {
            ClassPaymentModel::where('id', $request->idpayment)->update([
                'kode_promo' => $request->kode,
            ]);
            return response()->json(['message' => 'Kode Benar', 'status' => true]);
        }
        return response()->json(['message' => 'Kupon Tidak Tersedia', 'status' => false]);
    }
    public function updatemember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image_bukti_pembayaran' => 'image|mimes:jpeg,jpg,png|required|max:10000',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        }
        $inp = [
            'status_membership' => $request->status_membership,
            'id_member' => $request->id_member,
            'masa_aktif_membership' => $request->masa_aktif_membership ? $request->masa_aktif_membership : Carbon::now()->addYears(5),
        ];
        if ($request->image_bukti_pembayaran) {
            $name = $request->file('image_bukti_pembayaran')->getClientOriginalName(); // Name File
            $size = $request->file('image_bukti_pembayaran')->getSize(); // Size File
            $ext = $request->file('image_bukti_pembayaran')->extension(); // Extension File

            if ($size >= 1048576) {
                return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB');
            }

            $filename = $request->user_id . '-' . time() . '-' . preg_replace('/[^A-Za-z0-9\-]/', '-', $name) . '.' . $ext;
            $file = $request->file('image_bukti_pembayaran');
            $file->move(public_path('Image/Member'), $filename);
            $inp['image_bukti_pembayaran'] = 'Image/Member/' . $filename;
        }
        $u = UserProfileModel::where('user_id', $request->user_id)->update($inp);
        if ($u) {
            return Redirect::back()->with('success', 'Update Akun Berhasil, Sedang Diproses Mohon Ditunggu');
        }
        return Redirect::back()->with('error', 'Update Akun Gagal Disimpan');
    }
    public function updaterekening(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'nama_bank' => 'required',
            'no_rekening' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        }

        $u = DataRekeningModel::updateOrCreate([
            'user_id' => $request->user_id
        ], [
            'nama_bank' => $request->nama_bank,
            'no_rekening' => $request->no_rekening,
        ]);
        if ($u) {
            return Redirect::back()->with('success', 'Update Rekening Berhasil Disimpan');
        }
        return Redirect::back()->with('error', 'Update Rekening Gagal Disimpan');
    }
    public function datalamaran(Request $request)
    {
        $data = [];
        $data['datax'] = false;
        $data['data'] = LamaranModel::where('user_id', Auth::user()->id)->first();
        if ($data['data']) {
            $data['datax'] = true;
        }
        // return $data;
        if ($request->cetak) {
            $pdf = Pdf::loadView('front.loker.cetaklamaran', $data);
            return $pdf->stream();
            return view('front.loker.cetaklamaran', $data);
        }
        return view('front.loker.datalamaran', $data);
    }
    function simpanlamaran(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'nama_panggilan' => 'required',
            'tmpttgllahir' => 'required',
            'agama' => 'required',
            'alamatdomisili' => 'required',
            'telpdomisili' => 'required',
            'kodepos' => 'required',
            'namaorangtua' => 'required',
            'jmlsaudara' => 'required',
            'statusperkawinan' => 'required',
            'namapasangan' => 'required',
            'namaorangtuakandung' => 'required',
            'namaorangtuasuamiistri' => 'required',
            'namaanak' => 'required',
            'namakakeknenek' => 'required',
            'namacucu' => 'required',
            'namasuamiistri' => 'required',
            'namamertua' => 'required',
            'namabesan' => 'required',
            'namasuamiistrianak' => 'required',
            'namakakeksuami' => 'required',
            'namasuamiistricucu' => 'required',
            'namasuamiistrisaudara' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        }
        // return $request->all();
        $dl = LamaranModel::updateOrCreate([
            'id' => $request->id
        ], [
            'user_id' => Auth::user()->id,
            'nama_lengkap' => $request->nama_lengkap,
            'nama_panggilan' => $request->nama_panggilan,
            'tmpttgllahir' => $request->tmpttgllahir,
            'agama' => $request->agama,
            'alamatdomisili' => $request->alamatdomisili,
            'telpdomisili' => $request->telpdomisili,
            'kodepos' => $request->kodepos,
            'namaorangtua' => $request->namaorangtua,
            'jmlsaudara' => $request->jmlsaudara,
            'statusperkawinan' => $request->statusperkawinan,
            'namapasangan' => $request->namapasangan,
            'namaorangtuakandung' => $request->namaorangtuakandung,
            'namaorangtuasuamiistri' => $request->namaorangtuasuamiistri,
            'namaanak' => $request->namaanak,
            'namakakeknenek' => $request->namakakeknenek,
            'namacucu' => $request->namacucu,
            'namasuamiistri' => $request->namasuamiistri,
            'namamertua' => $request->namamertua,
            'namabesan' => $request->namabesan,
            'namasuamiistrianak' => $request->namasuamiistrianak,
            'namakakeksuami' => $request->namakakeksuami,
            'namasuamiistricucu' => $request->namasuamiistricucu,
            'namasuamiistrisaudara' => $request->namasuamiistrisaudara,
            'sdtahun' => $request->sdtahun,
            'sdnama' => $request->sdnama,
            'sdfakultas' => $request->sdfakultas,
            'sdgelar' => $request->sdgelar,
            'smptahun' => $request->smptahun,
            'smpnama' => $request->smpnama,
            'smpfakultas' => $request->smpfakultas,
            'smpgelar' => $request->smpgelar,
            'smatahun' => $request->smatahun,
            'smanama' => $request->smanama,
            'smafakultas' => $request->smafakultas,
            'smagelar' => $request->smagelar,
            'akademitahun' => $request->akademitahun,
            'akademinama' => $request->akademinama,
            'akademifakultas' => $request->akademifakultas,
            'akademigelar' => $request->akademigelar,
            'perguruantahun' => $request->perguruantahun,
            'perguruannama' => $request->perguruannama,
            'perguruanfakultas' => $request->perguruanfakultas,
            'perguruangelar' => $request->perguruangelar,
            'pascasarjanatahun' => $request->pascasarjanatahun,
            'pascasarjananama' => $request->pascasarjananama,
            'pascasarjanafakultas' => $request->pascasarjanafakultas,
            'pascasarjanagelar' => $request->pascasarjanagelar,
            'pelatihannama' => json_encode($request->pelatihannama),
            'pelatihantahun' => json_encode($request->pelatihantahun),
            'pelatihanpenyelanggara' => json_encode($request->pelatihanpenyelanggara),
            'pelatihanlokasi' => json_encode($request->pelatihanlokasi),
            'pekerjaantahun' => json_encode($request->pekerjaantahun),
            'pekerjaanperusahaan' => json_encode($request->pekerjaanperusahaan),
            'pekerjaanjabatan' => json_encode($request->pekerjaanjabatan),
            'pekerjaantanggungjawab' => json_encode($request->pekerjaantanggungjawab),
            'pekerjaanprestasi' => json_encode($request->pekerjaanprestasi),
            'pekerjaanpenghargaan' => json_encode($request->pekerjaanpenghargaan),
            'pekerjaantotalaset' => json_encode($request->pekerjaantotalaset),
            'pengalamanspesifik' => json_encode($request->pengalamanspesifik),
        ]);
        if ($dl) {
            return Redirect::to('profile')->with('success', 'Data Tersimpan');
        }
        return Redirect::back()->withErrors($validator)->withInput($request->all());
    }
}
