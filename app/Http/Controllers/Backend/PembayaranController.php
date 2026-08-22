<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ClassParticipantModel;
use App\Models\ClassPaymentModel;
use App\Models\DataPayment;
use App\Models\Dompet;
use App\Models\MasterRefferralModel;
use App\Models\MutasiDompet;
use App\Models\RefferralModel;
use App\Models\RiwayatTransaksi;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class PembayaranController extends Controller
{
    public function index(Request $r)
    {
        // 1. Inisialisasi parameter filter default
        $startDate = $r->param_date_start ?? Carbon::now()->subMonths(3)->format('Y-m-d');
        $endDate   = $r->param_date_end ?? Carbon::now()->format('Y-m-d');

        // Status default: [0, 1] (0: Belum Lunas, 1: Lunas)
        $status    = $r->has('param_checked_lunas') ? (array) $r->param_checked_lunas : [0, 1, 2, 3];

        $data['param'] = [
            'date'   => [$startDate, $endDate],
            'status' => array_map('intval', $status),
        ];

        // 2. Query DataPayment dengan filter dan relasi (Hapus relasi profile yang error)
        $query = DataPayment::with([
            // 'user',
            'paymentClass',
            'classPayment'
        ]);

        // Filter berdasarkan rentang tanggal
        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        // Filter berdasarkan status
        if (!empty($status)) {
            $query->whereIn('status', $status);
        }

        $pembayaran = $query->orderBy('created_at', 'desc')->get();

        // 3. Mapping data agar atribut sesuai dengan Blade
        $data['pembayaran'] = $pembayaran->map(function ($item) {
            // Mengambil nama langsung dari relasi user
            $item->name = $item->user->name ?? '-';

            // Ambil detail dari relasi kelas jika ada
            if ($item->paymentClass) {
                $item->title      = $item->paymentClass->title;
                $item->date_start = $item->paymentClass->date_start;
                $item->date_end   = $item->paymentClass->date_end;
                $item->category   = $item->paymentClass->category;
            }

            // Ambil detail dari ClassPaymentModel jika ada
            if ($item->classPayment) {
                $item->certificate    = $item->classPayment->certificate ?? 0;
                $item->sudah_cetak    = $item->classPayment->sudah_cetak ?? 0;
                $item->bukti_transfer = $item->classPayment->bukti_transfer ?? null;
                $item->file           = $item->classPayment->bukti_transfer ?? null;
            }

            return $item;
        });
        // return $data['pembayaran'];

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
        $status = $request->status == 1 ? 99 : 1;
        $msg = $request->status ? 'Pembatalan Berhasil' : 'Pembayaran Berhasil';

        // Ambil data pembayaran berdasarkan no_invoice sebelum di-update
        $payments = DataPayment::where('no_invoice', $request->id)->first();
        // return $payments;
        $transaksi = RiwayatTransaksi::where('no_invoice', $request->id)->first();
        if (!$payments) {
            return Redirect::back()->with(['error' => 'Data Pembayaran Tidak Ditemukan']);
        }

        // Eksekusi update status pembayaran
        $isUpdated = DataPayment::where('no_invoice', $request->id)->update(['status' => $status]);

        if ($transaksi) {
            $transactionStatus = $request->status == 1 ? 'FAILED' : 'SUCCESS';

            RiwayatTransaksi::where('no_invoice', $request->id)->update(['status' => $transactionStatus]);

            // Build the base query
            $historyQuery = DB::table('history_pelatihan')
                ->where('user_id', $payments['user_id'])
                ->where('sub_materi_id', $payments['submateri_id']);

            // Check if the record exists
            if ($historyQuery->exists()) {
                // Delete directly using the Query Builder
                $historyQuery->delete();
            } else {
                DB::table('history_pelatihan')->insertOrIgnore([
                    'user_id' => $payments['user_id'],
                    'sub_materi_id' => $payments['submateri_id']
                ]);
            }
        }
        if ($payments->class_id) {
            $classStatus = $request->status == 1 ? 0 : 1;
            ClassPaymentModel::where('no_invoice', $request->id)->update(['status' =>  $classStatus]);
        }

        if ($isUpdated) {
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
