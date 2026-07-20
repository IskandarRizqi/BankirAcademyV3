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
        // Cari ID dari materi yang bernama 'Umum'
        $materiUmum = MateriModel::where('nama', 'Umum')->first();
        $idMateriUmum = $materiUmum ? $materiUmum->id : null;

        $valid = Validator::make($request->all(), [
            'judul' => 'required',
            'id_materi' => 'required',
            
            // Wajib diisi JIKA id_materi bernilai sama dengan ID materi 'Umum'
            'id_submateri' => 'required_if:id_materi,' . $idMateriUmum,
            
            'tipe_prepost' => 'required',
            'soal' => 'required|array|min:1',

            'soal.*.pertanyaan' => 'required',
            'soal.*.jawaban' => 'nullable|string|in:A,B,C,D,E',
            'soal.*.opsi.A' => 'nullable|string',
            'soal.*.opsi.B' => 'nullable|string',
            'soal.*.opsi.C' => 'nullable|string',
            'soal.*.opsi.D' => 'nullable|string',
            'soal.*.opsi.E' => 'nullable|string',
            'soal.*.essay' => 'required_if:soal.*.tipe_pertanyaan,2'
        ], [
            // Custom pesan error agar lebih informatif
            'id_submateri.required_if' => 'Sub Materi wajib diisi untuk kompetensi/materi Umum.'
        ]);

        if ($valid->fails()) {
            // Mengembalikan error validasi ke halaman sebelumnya
            return redirect()->back()
                ->withErrors($valid)
                ->with('info', 'data tidak sesuai')
                ->withInput($request->all());
        }

        $i = [
            'judul' => $request->judul,
            'tipe_prepost' => $request->tipe_prepost,
            'id_materi' => $request->id_materi,
            // Jika bukan materi umum dan tidak diisi, set null
            'id_submateri' => $request->id_materi == $idMateriUmum ? $request->id_submateri : null,
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
