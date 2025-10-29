<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LamaranModel;
use App\Models\LokerApply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LokerApplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['data'] = LokerApply::with('lamaran', 'user')->get();
        // return $data;
        return view('backend.loker.list', $data);
    }

    public function getdatacvpelamar()
    {
        $data['data'] = LamaranModel::select(
            'lamaran_models.*',
            'users.email',
            'users.name',
        )
            ->join('users', 'users.id', 'lamaran_models.user_id')
            ->get();
        return view('backend.loker.cvpelamar', $data);
    }

    public function approvecvpelamar(Request $r)
    {
        $u = LamaranModel::where('id', $r->id)
            ->update([
                'is_approved' => $r->approved,
                'is_approved_message' => $r->approved_message,
            ]);
        if ($u) {
            return Redirect::back()->with('success', 'Data CV Tersimpan');
        }
        return Redirect::back()->with('error', 'Data Tidak CV Tersimpan');
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
        //
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
