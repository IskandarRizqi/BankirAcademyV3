<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ClassParticipantModel;
use App\Models\ClassPaymentModel;
use App\Models\MasterRefferralModel;
use App\Models\RefferralModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class PembayaranController extends Controller
{
    public function index(Request $r)
    {
        $data['param'] = [];
        $data['param']['date'] = [Carbon::now()->submonth(3)->format('Y-m-d'), date('Y-m-d')];
        $data['param']['status'] = [0, 1];

        if ($r->param_date_start) {
            $data['param']['date'][0] = $r->param_date_start;
        }
        if ($r->param_date_end) {
            $data['param']['date'][1] = $r->param_date_end;
        }

        if ($r->param_checked_lunas) {
            $data['param']['status'] = $r->param_checked_lunas;
        }

        $data['pembayaran'] = ClassPaymentModel::select(
            'class_payment.*',
            'user_profile.name',
            'classes.title',
            'classes.date_start',
            'classes.date_start',
            'classes.category',
            'class_participant.certificate'

        )
            ->leftJoin('user_profile', 'user_profile.user_id', 'class_payment.user_id')
            ->leftJoin('classes', 'classes.id', 'class_payment.class_id')
            ->leftJoin('class_participant', 'class_participant.payment_id', 'class_payment.id')
            ->whereDate('class_payment.created_at', '>=', $data['param']['date'][0])
            ->whereDate('class_payment.created_at', '<=', $data['param']['date'][1])
            ->whereIn('class_payment.status', $data['param']['status'])
            // ->orderBy('class_payment.status')
            ->orderBy('class_payment.created_at', 'desc')
            ->get();
        // return $data;
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
        // $status = 0;
        $msg = $request->status ? 'Pembatalan Berhasil' : 'Pembayaran Berhasil';
        $masterReferral = MasterRefferralModel::first();
        if (!$masterReferral) {
            return Redirect::back()->with('error', 'Master Referral Belum Ditentukan');
        }
        $cs = ClassPaymentModel::where('no_invoice', $request->id)->update(['status' => $status]);
        // return $cs;
        if ($cs) {
            $cp = ClassPaymentModel::where('no_invoice', $request->id)->get();
            foreach ($cp as $key => $v) {
                ClassParticipantModel::updateOrCreate(
                    [
                        'payment_id' => $v->id,
                        'user_id' => $v->user_id
                    ],
                    [
                        'jumlah' => $v->jumlah,
                        'class_id' => $v->class_id,
                        'user_id' => $v->user_id,
                    ]
                );
                $r = RefferralModel::where('user_aplicator', $v->user_id)->first();
                if ($r) {
                    $nominal_class = 0;
                    $nominal_admin = 0;
                    $total = 0;
                    if ($v->additional_discount) {
                        $jd = json_decode($v->additional_discount);
                        if (count((array)$jd) > 0) {
                            $nominal_class = $jd->reff;
                            $nominal_admin = $jd->reff_nominal;
                            $total = $jd->komisi;
                        }
                    }
                    if ($r->available == 0) {
                        RefferralModel::where('user_aplicator', $v->user_id)->update([
                            'available' => $status,
                            'nominal_class' => $nominal_class,
                            'nominal_admin' => $nominal_admin,
                            'total' => $total,
                        ]);
                    }
                }
            }
            return Redirect::back()->with(['success' => $msg]);
        }
        return Redirect::back()->with(['error' => 'Pembayaran Gagal', 'msg' => $cs]);
    }
}
