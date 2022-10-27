<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ClassesModel;
use App\Models\ClassPaymentModel;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user()->id;
        $data['pfl'] = UserProfileModel::where('user_id', Auth::user()->id)->first();
        $data['payment'] = ClassPaymentModel::select('class_payment.*', 'classes.title')
            ->join('classes', 'classes.id', 'class_payment.class_id')
            ->where('user_id', $auth)
            ->get();
        $data['class_id'] = ClassPaymentModel::where('user_id', $auth)->pluck('class_id')->toArray();
        $data['class'] = ClassesModel::whereIn('id', $data['class_id'])->get();
        $data['pop'] = ClassesModel::limit(6)->get();
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
            // 'image_produk' => 'image|mimes:jpeg,png,jpg|max:2048|required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        UserProfileModel::updateOrCreate([
            'user_id' => $request->user_id,
        ], [
            'name' => $request->nama_lengkap,
            'phone' => $request->nomor_handphone,
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
}
