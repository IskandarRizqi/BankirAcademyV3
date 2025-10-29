<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ClassesModel;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $r)
    {
        $l = ClassesModel::select()
            ->where(function ($q) use ($r) {
                if ($r->date_start && $r->date_end) {
                    return $q->whereDate('loker.date_start', '>=', $r->date_start)->whereDate('loker.date_end', '<=', $r->date_end);
                }
            })
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->paginate();
        if ($r->limit) {
            $l = ClassesModel::select()
                ->where(function ($q) use ($r) {
                    if ($r->date_start && $r->date_end) {
                        return $q->whereDate('loker.date_start', '>=', $r->date_start)->whereDate('loker.date_end', '<=', $r->date_end);
                    }
                })
                ->where('status', 1)
                ->orderBy('created_at', 'DESC')
                ->limit($r->limit)
                ->get();
        }
        $data  = [
            'message' => 'Data berhasil',
            'status' => true,
            'data' => $l
        ];
        return response()->json($data);
    }
}
