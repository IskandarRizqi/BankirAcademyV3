<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfileModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // 
    }
    public function index()
    {
        if (Auth::user()->role != 0) {
            return Redirect::back()->with('info', 'Anda Tidak Memiliki Akses');
        }
        $data = [];
        $data['user'] = User::get();
        return view('backend.user.user', $data);
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
            'status_membership' => 'required',
            'masa_aktif_membership' => 'required',

        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        }
        $inp = [
            'status_membership' => $request->status_membership,
            'masa_aktif_membership' => $request->masa_aktif_membership ? $request->masa_aktif_membership : Carbon::now()->addYears(5),
        ];
        if ($request->image_bukti_pembayaran) {
            $name = $request->file('image_bukti_pembayaran')->getClientOriginalName(); // Name File
            $size = $request->file('image_bukti_pembayaran')->getSize(); // Size File

            if ($size >= 1048576) {
                return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB');
            }

            $filename = time() . '-' . $name;
            $file = $request->file('image_bukti_pembayaran');
            $file->move(public_path('Image/Member'), $filename);
            $inp['image_bukti_pembayaran'] = 'Image/Member/' . $filename;
        }
        $u = UserProfileModel::where('id', $request->user_id)->update($inp);
        if ($u) {
            return Redirect::back()->with('success', 'Update Akun Berhasil');
        }
        return Redirect::back()->with('error', 'Update Akun Gagal Disimpan');
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
