<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ClassParticipantModel;
use App\Models\ClassPaymentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PembayaranController extends Controller
{
    public function index()
    {
        $data['pembayaran'] = ClassPaymentModel::select(
            'class_payment.*',
            'users.name',
            'classes.title',
            'classes.date_start',
            'classes.date_start',
            'class_participant.certificate'

        )
            ->join('users', 'users.id', 'class_payment.user_id')
            ->join('classes', 'classes.id', 'class_payment.class_id')
            ->join('class_participant', 'class_participant.payment_id', 'class_payment.id')
            ->get();
        return view('backend.pembayaran.pembayaran', $data);
    }

    public function publish_certificate(Request $request)
    {
        $certificate = $request->certificate ? 0 : 1;
        $cs = ClassParticipantModel::where('payment_id', $request->id)->update(['certificate' => $certificate]);
        if ($cs) {
            return Redirect::back()->with(['success' => 'Pembayaran Berhasil']);
        }
        return Redirect::back()->with(['error' => 'Pembayaran Gagal', 'msg' => $cs]);
    }
    public function approved(Request $request)
    {
        $status = $request->status ? 0 : 1;
        $cs = ClassPaymentModel::where('id', $request->id)->update(['status' => $status]);
        if ($cs) {
            return Redirect::back()->with(['success' => 'Pembayaran Berhasil']);
        }
        return Redirect::back()->with(['error' => 'Pembayaran Gagal', 'msg' => $cs]);
    }
}
