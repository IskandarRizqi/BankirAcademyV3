<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PrepotesUserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

/**
 * Student pre-test submission endpoint.
 *
 * The legacy admin CRUD was removed with the old admin screen.
 */
class PrepotestController extends Controller
{
    public function savejawaban(Request $request)
    {
        $pr = PrepotesUserModel::where('class_id', $request->classid)
            ->where('user_id', Auth::user()->id)
            ->first();

        if ($pr && $pr->jml_jawaban > 2) {
            return Redirect::back()->with('error', 'Maksimal Input 2 Kali');
        }

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
        $data = [
            'jawaban' => json_encode($request->jawaban),
            'jml_jawaban' => $pr->jml_jawaban + 1,
        ];

        if ($request->nilai_awal >= 0) {
            $data['nilai_akhir'] = $nilai_final;
        } else {
            $data['nilai_awal'] = $nilai_final;
        }

        $p = PrepotesUserModel::updateOrCreate([
            'class_id' => $request->classid,
            'user_id' => Auth::user()->id,
        ], $data);

        if ($p) {
            return Redirect::back()->with('success', 'Data Tersimpan');
        }

        return Redirect::back()->with('info', 'Data Tidak Tersimpan');
    }
}
