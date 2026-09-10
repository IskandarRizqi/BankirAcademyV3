<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ClassParticipantModel;
use App\Models\ClassPaymentModel;
use App\Models\DataPayment;
use App\Models\RiwayatTransaksi;
use App\Models\UserProfileModel;
use App\Services\MembershipPaymentService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class PembayaranController extends Controller
{
    public function index(Request $r)
    {
        // 1. Inisialisasi parameter filter default
        $startDate = $r->param_date_start ?? Carbon::now()->subMonths(3)->format('Y-m-d');
        $endDate = $r->param_date_end ?? Carbon::now()->format('Y-m-d');

        // Status default: [0, 1] (0: Belum Lunas, 1: Lunas)
        $status = $r->has('param_checked_lunas') ? (array) $r->param_checked_lunas : [0, 1, 2, 3, 98, 99];

        $data['param'] = [
            'date' => [$startDate, $endDate],
            'status' => array_map('intval', $status),
        ];

        // 2. Query DataPayment dengan filter dan relasi (Hapus relasi profile yang error)
        $query = DataPayment::with([
            'user',
            'paymentClass',
            'classPayment',
            'riwayatTransaksi',
        ]);

        // Filter berdasarkan rentang tanggal
        if (! empty($startDate) && ! empty($endDate)) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
        }

        // Filter berdasarkan status
        if (! empty($status)) {
            $query->whereIn('status', $status);
        }

        $pembayaran = $query->orderBy('created_at', 'desc')->get();

        // 3. Mapping data agar atribut sesuai dengan Blade
        $data['pembayaran'] = $pembayaran->map(function ($item) {
            // Mengambil nama langsung dari relasi user
            $item->name = $item->user->name ?? '-';

            // Ambil detail dari relasi kelas jika ada
            if ($item->paymentClass) {
                $item->title = $item->paymentClass->title;
                $item->date_start = $item->paymentClass->date_start;
                $item->date_end = $item->paymentClass->date_end;
                $item->category = $item->paymentClass->category;
            }

            // Ambil detail dari ClassPaymentModel jika ada
            if ($item->classPayment) {
                $item->certificate = $item->classPayment->certificate ?? 0;
                $item->sudah_cetak = $item->classPayment->sudah_cetak ?? 0;
                $item->bukti_transfer = $item->classPayment->bukti_transfer ?? null;
                $item->file = $item->classPayment->file ?? $item->classPayment->bukti_transfer ?? null;
            }

            if (! $item->file && $item->link_payment && ! filter_var($item->link_payment, FILTER_VALIDATE_URL)) {
                $item->file = $item->link_payment;
            }

            if ((int) $item->tipe_pembelian === DataPayment::PURCHASE_TYPE_MEMBERSHIP) {
                $item->title = $item->tipe_membership === DataPayment::MEMBERSHIP_TYPE_INDIVIDUAL
                    ? 'Membership Perorangan'
                    : 'Membership Perusahaan';
                $item->category = 'Membership';
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
        $payments = DataPayment::where('no_invoice', $request->id)->first();
        if (! $payments) {
            return Redirect::back()->with(['error' => 'Data Pembayaran Tidak Ditemukan']);
        }

        if ((int) $payments->tipe_pembelian === DataPayment::PURCHASE_TYPE_MEMBERSHIP) {
            if ((int) $request->status === DataPayment::STATUS_PAID) {
                return $this->cancelMembershipPayment($payments);
            }

            return $this->approveMembershipPayment($payments);
        }

        // 1. Tentukan status (0 = Batal, 1 = Sukses)
        $status = $request->status == 1 ? 99 : 1;
        $msg = (int) $request->status === DataPayment::STATUS_PAID
            ? 'Pembatalan Berhasil'
            : 'Pembayaran Berhasil';

        // Ambil data pembayaran berdasarkan no_invoice sebelum di-update
        // return $payments;
        $transaksi = RiwayatTransaksi::where('no_invoice', $request->id)->first();
        if (! $payments) {
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
                    'sub_materi_id' => $payments['submateri_id'],
                ]);
            }
        }
        if ($payments->class_id) {
            $classStatus = $request->status == 1 ? 0 : 1;
            ClassPaymentModel::where('no_invoice', $request->id)->update(['status' => $classStatus]);
        }

        if ($isUpdated) {
            return Redirect::back()->with(['success' => $msg]);
        }

        return Redirect::back()->with(['error' => 'Pembayaran Gagal', 'msg' => $isUpdated]);
    }

    public function reject(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'string'],
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        $payment = DataPayment::where('no_invoice', $validated['id'])->first();
        if (! $payment) {
            return Redirect::back()->with('error', 'Data Pembayaran Tidak Ditemukan');
        }

        $isManual = $payment->payment_method === 'manual'
            || ($payment->payment_method === null && ! filter_var($payment->link_payment, FILTER_VALIDATE_URL));

        if (! $isManual || (int) $payment->status !== DataPayment::STATUS_WAITING_CONFIRMATION) {
            return Redirect::back()->with('error', 'Pembayaran ini belum dapat ditolak.');
        }

        DB::transaction(function () use ($payment, $validated) {
            $lockedPayment = DataPayment::whereKey($payment->id)->lockForUpdate()->first();
            if (! $lockedPayment || (int) $lockedPayment->status !== DataPayment::STATUS_WAITING_CONFIRMATION) {
                return;
            }

            $lockedPayment->update([
                'status' => DataPayment::STATUS_REJECTED,
                'rejection_reason' => $validated['rejection_reason'],
            ]);

            RiwayatTransaksi::where('no_invoice', $lockedPayment->no_invoice)
                ->update(['status' => 'FAILED', 'keterangan' => $validated['rejection_reason']]);

            if ((int) $lockedPayment->tipe_pembelian === DataPayment::PURCHASE_TYPE_MEMBERSHIP) {
                UserProfileModel::where('user_id', $lockedPayment->user_id)
                    ->where('status_membership', DataPayment::STATUS_PENDING)
                    ->update(['status_membership' => 0]);
            }
        });

        return Redirect::back()->with('success', 'Bukti pembayaran berhasil ditolak.');
    }

    private function approveMembershipPayment(DataPayment $payment)
    {
        $isManual = $payment->payment_method === 'manual'
            || ($payment->payment_method === null && ! filter_var($payment->link_payment, FILTER_VALIDATE_URL));

        if (! $isManual || (int) $payment->status !== DataPayment::STATUS_WAITING_CONFIRMATION || blank($payment->link_payment)) {
            return Redirect::back()->with('error', 'Membership hanya dapat disetujui setelah bukti transfer diunggah.');
        }

        DB::transaction(function () use ($payment) {
            $lockedPayment = DataPayment::whereKey($payment->id)->lockForUpdate()->firstOrFail();
            app(MembershipPaymentService::class)->activate($lockedPayment);
        });

        return Redirect::back()->with('success', 'Pembayaran membership disetujui dan membership user diaktifkan.');
    }

    private function cancelMembershipPayment(DataPayment $payment)
    {
        DB::transaction(function () use ($payment) {
            $lockedPayment = DataPayment::whereKey($payment->id)->lockForUpdate()->firstOrFail();
            $lockedPayment->update(['status' => DataPayment::STATUS_CANCELED]);

            UserProfileModel::where('user_id', $lockedPayment->user_id)
                ->where('status_membership', DataPayment::STATUS_PAID)
                ->update(['status_membership' => 0]);
        });

        return Redirect::back()->with('success', 'Membership berhasil dibatalkan.');
    }

    public function update_bukti(Request $request)
    {
        if ($request->foto) {
            $size = $request->file('foto')->getSize();
            if (($size / 1024) > 100) {
                return Redirect::back()->with('error', 'Size Maximum 100kb');
            }
            $gambar = $request->foto->store('order/'.Auth::user()->email.'/'.time());

            ClassPaymentModel::where('id', $request->idpembayaran)->update([
                'file' => $gambar,
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

        if ((string) $request->server('HTTP_X_CALLBACK_EVENT') !== 'payment_status') {
            return Response::json([
                'success' => false,
                'message' => 'Unrecognized callback event, no action was taken',
            ]);
        }

        $data = json_decode($json);

        if (json_last_error() !== JSON_ERROR_NONE) {
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

        if (! hash_equals($secret, $incomingSecret)) {
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
                $status = 'pending';
                break;
        }

        //   $transaction->status =  $status;
        //   $transaction->save();

        return response()->json(['success' => true, 'status' => $status], 200);
    }
}
