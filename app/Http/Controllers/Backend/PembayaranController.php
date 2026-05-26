<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ClassParticipantModel;
use App\Models\ClassPaymentModel;
use App\Models\Dompet;
use App\Models\MasterRefferralModel;
use App\Models\MutasiDompet;
use App\Models\RefferralModel;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

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
    public function setsudahcetak(Request $request)
    {
        $certificate = $request->certificate == 1 ? 0 : 1;
        $cs = ClassPaymentModel::where('id', $request->id)->update(['sudah_cetak' => $certificate]);
        if ($cs) {
            return Redirect::back()->with(['success' => 'Set Status Cetak Berhasil']);
        }
        return Redirect::back()->with(['error' => 'Set Status Cetak Gagal', 'msg' => $cs]);
    }
  public function approved(Request $request)
{
    // 1. Tentukan status (0 = Batal, 1 = Sukses)
    $status = $request->status ? 0 : 1;
    $msg = $request->status ? 'Pembatalan Berhasil' : 'Pembayaran Berhasil';

    // Ambil data pembayaran berdasarkan no_invoice sebelum di-update
    $payments = ClassPaymentModel::where('no_invoice', $request->id)->get();

    if ($payments->isEmpty()) {
        return Redirect::back()->with(['error' => 'Data Pembayaran Tidak Ditemukan']);
    }

    // Eksekusi update status pembayaran
    $isUpdated = ClassPaymentModel::where('no_invoice', $request->id)->update(['status' => $status]);

    if ($isUpdated) {
        foreach ($payments as $key => $v) {
            $kode = 0;
            if ($v->promo) {
                $kode = $v->promo;
            }
            
            // Hitung harga final setelah promo kupon/potongan langsung
            $n = ($v->price_final * $v->jumlah) - $kode;

            // Update atau buat partisipan kelas
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

            // =================================================================
            // LOGIKA CASHBACK MEMBERSHIP & DOMPET (HANYA JIKA STATUS APPROVE/1)
            // =================================================================
            if ($status == 1) {
                // Ambil profile user beserta data membership-nya jika aktif
                $userProfile = UserProfileModel::where('user_id', $v->user_id)->first();

                if ($userProfile && $userProfile->status_membership == 1 && $userProfile->id_member) {
                    // Load relasi membership
                    $membership = $userProfile->membership;

                    if ($membership && $membership->is_active == 1) {
                        $cashback = 0;

                        // type 0 = Persentase, type 1 = Nominal Fixed
                        if ($membership->type == 0) {
                            $cashback = $n * ($membership->nominal / 100);
                        } elseif ($membership->type == 1) {
                            $cashback = $membership->nominal;
                        }

                        if ($cashback > 0) {
                            // 1. Update atau Buat Dompet User
                            $dompet = Dompet::firstOrCreate(
                                ['user_id' => $v->user_id],
                                ['saldo' => 0]
                            );
                            $dompet->increment('saldo', $cashback);

                            // 2. Catat riwayat ke Mutasi Dompet
                            MutasiDompet::create([
                                'user_id'      => $v->user_id,
                                'jenis'        => 'masuk', // Atau sesuaikan dengan enum sistem Anda (misal: 'in' / 'kredit')
                                'jumlah'       => $cashback,
                                'class_id'     => $v->class_id,
                                'payment_id'   => $v->id,
                                'tipe_aksi'    => 'cashback_membership',
                                'referensi_id' => $v->id,
                                'keterangan'   => 'Cashback member ' . $membership->nama . ' untuk pembelian kelas.',
                            ]);
                        }
                    }
                }
            }
            // =================================================================

            // LOGIKA REFERRAL (Bawaan Kode Lama Anda)
            $r = RefferralModel::where('user_aplicator', $v->user_id)
                ->whereNull('class_id')
                ->first();
                
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
                
                $mr = MasterRefferralModel::first();
                if ($mr) {
                    $data['payment']['reff'] = $n * ($mr->potongan_harga / 100);
                    $additional_discount['reff_nominal'] = $mr->nominal;
                    $additional_discount['reff'] = $n * ($mr->potongan_harga / 100);
                    $additional_discount['komisi'] = $data['payment']['reff'] * ($mr->nominal / 100);
                    $additional_discount['totalAkhir'] = $n - $data['payment']['reff'];
                    
                    RefferralModel::updateOrCreate([
                        'user_aplicator' => $v->user_id,
                        'class_id' => $v->class_id
                    ], [
                        'available' => 1,
                        'user_id' => $r->user_id,
                        'user_aplicator' => $r->user_aplicator,
                        'code' => $r->code,
                        'nominal_class' => $n,
                        'nominal_admin' => $additional_discount['komisi'],
                        'total' => $additional_discount['reff'],
                    ]);
                }
            }
        }
        return Redirect::back()->with(['success' => $msg]);
    }

    return Redirect::back()->with(['error' => 'Pembayaran Gagal', 'msg' => $isUpdated]);
}
    public function update_bukti(Request $request)
    {
        if ($request->foto) {
            $size = $request->file('foto')->getSize();
            if (($size / 1024) > 100) {
                return Redirect::back()->with('error', 'Size Maximum 100kb');
            }
            $gambar = $request->foto->store('order/' . Auth::user()->email . '/' . time());

            ClassPaymentModel::where('id', $request->idpembayaran)->update([
                'file' => $gambar
            ]);
            return Redirect::back()->with('success', 'Update Berhasil');
        }
    }
    protected $privateKey = 'kiBIA-pMNd6-DbD2T-6Z7Sf-YvTrK';
    // api key : uQoS9OhaPOZF90d55su5eObbHUbuYBuoXq6fjhu0
    public function tripaycreate(Request $request)
    {
        // Isi dengan private key anda
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, $this->privateKey);

        if ($signature !== (string) $callbackSignature) {
            return Response::json([
                'success' => false,
                'message' => 'Invalid signature',
            ]);
        }

        if ('payment_status' !== (string) $request->server('HTTP_X_CALLBACK_EVENT')) {
            return Response::json([
                'success' => false,
                'message' => 'Unrecognized callback event, no action was taken',
            ]);
        }

        $data = json_decode($json);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return Response::json([
                'success' => false,
                'message' => 'Invalid data sent by tripay',
            ]);
        }

        $invoiceId = $data->merchant_ref;
        $tripayReference = $data->reference;
        $status = strtoupper((string) $data->status);
        return Response::json(['success' => $data ? true : false, 'message' => $data]);

        // if ($data->is_closed_payment === 1) {
        //     $invoice = Invoice::where('id', $invoiceId)
        //         ->where('tripay_reference', $tripayReference)
        //         ->where('status', '=', 'UNPAID')
        //         ->first();

        //     if (! $invoice) {
        //         return Response::json([
        //             'success' => false,
        //             'message' => 'No invoice found or already paid: ' . $invoiceId,
        //         ]);
        //     }

        //     switch ($status) {
        //         case 'PAID':
        //             $invoice->update(['status' => 'PAID']);
        //             break;

        //         case 'EXPIRED':
        //             $invoice->update(['status' => 'EXPIRED']);
        //             break;

        //         case 'FAILED':
        //             $invoice->update(['status' => 'FAILED']);
        //             break;

        //         default:
        //             return Response::json([
        //                 'success' => false,
        //                 'message' => 'Unrecognized payment status',
        //             ]);
        //     }

        //     return Response::json(['success' => true]);
        // }
    }
    public function tripayppob(Request $request)
    {
        $secret = '3gbDwrtTuAku95lExw3nvTUXPVqPBv1z';
        $incomingSecret = $request->server('HTTP_X_CALLBACK_SECRET') ?: '';

        if (!hash_equals($secret, $incomingSecret)) {
            throw new Exception('Invalid Secret');
        }

        $json = $request->getContent();
        $data = json_decode($json);

        //   $transaction = Transaction::where('id', $data->api_trxid)->first();

        //   if (!$transaction) {
        //       throw new Exception('Transaction not found');
        //   }

        switch ($data->status) {
            case '0':
                $status = 'pending';
                break;
            case '1':
                $status = 'success';
                break;
            case '2':
                $status = 'failed';
                break;
            default:
                $status = "pending";
                break;
        }

        //   $transaction->status =  $status;
        //   $transaction->save();

        return response()->json(['success' => true, 'status' => $status], 200);
    }
}
