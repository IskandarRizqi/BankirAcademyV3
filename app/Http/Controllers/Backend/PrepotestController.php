<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ClassesModel;
use App\Models\PrepotesModel;
use App\Models\PrepotesUserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PrepotestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['kelas'] = DB::table('classes')->select('id', 'title')->get();
        $data['data'] = PrepotesModel::get();
        $data['prepotes'] = PrepotesModel::select('prepotes.*', 'prepotes_user.nilai', 'prepotes_user.user_id', 'prepotes_user.jawaban as jwbuser', 'users.name')
            ->join('prepotes_user', 'prepotes_user.class_id', 'prepotes.class_id')
            ->join('users', 'users.id', 'prepotes_user.user_id')
            ->get();
        // return $data;
        return view('backend.prepotest.master.pertanyaan', $data);
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
        // return $request->all();
        $valid = Validator::make($request->all(), [
            // 'kelas' => 'required',
            // 'ask.*' => 'required',
            // 'answerA.*' => 'required',
            // 'answerB.*' => 'required',
            // 'answerC.*' => 'required',
            // 'answerD.*' => 'required',
        ]);
        //response error validation
        if ($valid->fails()) {
            return Redirect::back()->withErrors($valid)->withInput($request->all())->with('info', 'Data Tidak Sesuai');
        }

        $jwb = [];
        if ($request->answerA) {
            $jwb['answerA'] = $request->answerA;
        }
        if ($request->answerB) {
            $jwb['answerB'] = $request->answerB;
        }
        if ($request->answerC) {
            $jwb['answerC'] = $request->answerC;
        }
        if ($request->answerD) {
            $jwb['answerD'] = $request->answerD;
        }
        if ($request->answerE) {
            $jwb['answerE'] = $request->answerE;
        }

        $jwb['benar'] = [];
        if ($request->benar) {
            $jwb['benar'] = $request->benar;
        }

        // return $request->all();
        $p = PrepotesModel::updateOrCreate([
            'id' => $request->id
        ], [
            'class_id' => json_decode($request->kelas)->id,
            'kelas_id' => $request->kelas,
            'pertanyaan' => json_encode($request->ask),
            'jawaban' => json_encode($jwb),
        ]);

        if ($p) {
            return Redirect::back()->with('success', 'Data Tersimpan');
        }
        return Redirect::back()->with('info', 'Data Tidak Tersimpan');
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
    public function destroy($id, Request $request)
    {
        if ($id) {
            PrepotesModel::where('id', $id)->delete();
            return Redirect::back()->with('success', 'Data Terhapus');
        }
    }

    public function savejawaban(Request $request)
    {
        // return $request->all();
        $nilai = 0;
        $jwb = false;
        if ($request->jwb) {
            $jwb = json_decode($request->jwb);
        }
        if ($jwb) {
            for ($i = 0; $i < count($jwb->benar); $i++) {
                if ($request->jawaban[$i] == $jwb->benar[$i]) {
                    $nilai++;
                }
            }
        }
        $nilai_final = ($nilai / count($jwb->benar)) * 100;

        $p = PrepotesUserModel::updateOrCreate([
            'class_id' => $request->classid,
            'user_id' => Auth::user()->id,
        ], [
            'jawaban' => json_encode($request->jawaban),
            'nilai' => $nilai_final,
        ]);
        if ($p) {
            return Redirect::back()->with('success', 'Data Tersimpan');
        }
        return Redirect::back()->with('info', 'Data Tidak Tersimpan');
    }
}
