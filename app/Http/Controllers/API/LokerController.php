<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LokerModel;
use Illuminate\Http\Request;

class LokerController extends Controller
{
    public function index(Request $r)
    {
        $l = LokerModel::select(
            'loker.*',
            'users.name',
            'users.email as email_user'
        )
            ->join('users', 'users.id', 'loker.user_id')
            ->where(function ($q) use ($r) {
                if ($r->date_start && $r->date_end) {
                    return $q->whereDate('loker.tanggal_awal', '>=', $r->date_start)->whereDate('loker.tanggal_akhir', '<=', $r->date_end);
                }
            })
            ->where('status', 1)
            ->paginate();
        return response()->json($l);
        // [
        //     'msg' => 'Data berhasil',
        //     'message' => true,
        //     'data' => $l
        // ]
    }
}
