<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ClassesModel;
use App\Models\ClassEventModel;
use App\Models\ClassPaymentModel;
use App\Models\InstructorModel;
use App\Models\InstructorReviewModel;
use App\Models\KodePromoModel;
use App\Models\MasterRefferralModel;
use App\Models\RefferralModel;
use App\Models\RefferralPesertaModel;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        $auth = Auth::user()->id;
        $data['pfl'] = UserProfileModel::where('user_id', Auth::user()->id)->first();
        $data['pop'] = ClassesModel::limit(6)->get();
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
            ->orderBy('class_payment.status')
            ->orderBy('class_payment.created_at', 'desc')
            ->get();
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
        foreach ($data['class'] as $key => $value) {
            $value->class = ClassesModel::select('title', 'instructor', 'date_start', 'date_end', 'id')->where('id', $value->class_id)->get();
            $value->event = ClassEventModel::where('class_id', $value->class_id)->get();
        }
        $data['reff'] = RefferralPesertaModel::where('user_id', Auth::user()->id)->first();
        $data['referralku'] = RefferralModel::select('code')->where('user_aplicator', Auth::user()->id)->first();
        // return $data;
        return view('front.profile.profile', $data);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'nomor_handphone' => 'required|numeric',
            'alamat' => 'required',
            'tanggal_lahir' => 'required',
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

        UserProfileModel::updateOrCreate([
            'user_id' => $request->user_id,
        ], [
            'name' => $request->nama_lengkap,
            'phone' => $request->nomor_handphone,
            'rekening' => $request->rekening,
            'tanggal_lahir' => $request->tanggal_lahir,
            'gender' => $request->jenis_kelamin,
            'description' => $request->alamat,
            'instansi' => $request->company,
        ]);

        // return view('front.profile.profile');
        return redirect('/profile')->with('success', 'Berhasil memperbarui profile');
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
            return Redirect::back()->with('success', 'Review Gagal Disimpan');
        }
        return Redirect::back()->with('success', 'Review Berhasil Disimpan');
    }
    public function review_instructor(Request $request)
    {
        $auth = Auth::user();
        $validasi = InstructorReviewModel::where('users_id', $auth->id)->where('instructor_id', $request->id_instructor)->get();
        return $validasi;
    }
    public function setKodePromo($title_kelas, $kode_promo, $id_payment)
    {
        $kp = KodePromoModel::where('kode', $kode_promo)->where('class_title', 'like', '%"' . $title_kelas . '"%')->where('tgl_selesai', '>=', Carbon::now())->get();
        if (count($kp) > 0) {
            ClassPaymentModel::where('id', $id_payment)->update([
                'kode_promo' => $kode_promo,
            ]);
            return response()->json(['message' => 'Kode Benar', 'status' => true]);
        }
        return response()->json(['message' => 'Kupon Tidak Tersedia', 'status' => false]);
    }
}
