<?php

namespace App\Http\Controllers;

use App\Models\MateriModel;
use App\Models\PreposttestModel;
use App\Models\SubMateriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PrePostTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $x['materi'] = MateriModel::get();
        $x['submateri'] = SubMateriModel::get();
        $x['data'] = PreposttestModel::select()
            ->with('materi', 'submateri')
            ->get();
        // return $x['data'];
        return view('compact.preposttest', $x);
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
        $valid = Validator::make($request->all(), [
            'judul' => 'required',
            'soal' => 'required|array|min:1',

            'soal.*.pertanyaan' => 'required',
            'soal.*.jawaban' => 'nullable|string|in:A,B,C,D,E',
            'soal.*.opsi.A' => 'nullable|string',
            'soal.*.opsi.B' => 'nullable|string',
            'soal.*.opsi.C' => 'nullable|string',
            'soal.*.opsi.D' => 'nullable|string',
            'soal.*.opsi.E' => 'nullable|string',

            'soal.*.essay' => 'required_if:soal.*.tipe_pertanyaan,2'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->with('info', 'data tidak sesuai')->withInput($request->all());
        }

        $i = [
            'judul' => $request->judul,
            'id_materi' => $request->id_materi,
            'id_submateri' => $request->id_submateri,
            'soal' => json_encode($request->soal),
        ];

        $p = PreposttestModel::updateOrCreate(['id' => $request->id], $i);

        if (!$p) {
            return redirect()->back()->with('info', 'data gagal tersimpan')->withInput($request->all());
        }
        return redirect()->back()->with('info', 'data tersimpan');
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
        if ($id) {
            $p = PreposttestModel::where('id', $id)->delete();
            if (!$p) {
                return redirect()->back()->with('info', 'data gagal terhapus');
            }
            return redirect()->back()->with('info', 'data terhapus');
        }
    }
}
