<?php

namespace App\Http\Controllers\Backend;

use App\Helper\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Models\RefferralWithdrawModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class WithdrawController extends Controller
{
    public function index()
    {
        $auth = Auth::user();
        $data = [];
        $data['data'] = RefferralWithdrawModel::select('refferral_withdraw.*', 'users.name')
            ->join('users', 'users.id', 'refferral_withdraw.user_id')
            ->where(function ($sql) use ($auth) {
                if ($auth->role == 2) {
                    return $sql->where('refferral_withdraw.user_id', $auth->id);
                }
            })->get();
        // return $data;
        return view('backend.referral.withdraw', $data);
    }

    public function proses(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_bank' => 'required',
            'no_rekening' => 'required|numeric',
            'nominal_penarikan' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput($request->all())->with('error', 'Harap Cek Data Kembali');
        }

        $d = RefferralWithdrawModel::create([
            'user_id' => Auth::user()->id,
            'status' => 0,
            'amount' => $request->nominal_penarikan,
            'nama_bank' => $request->nama_bank,
            'no_rekening' => $request->no_rekening,
            'date' => now(),
        ]);
        if ($d) {
            return Redirect::back()->with('success', 'Menunggu Konfirmasi Admin');
        }
        return Redirect::back()->withInput($request->all())->with('error', 'Gagal Menimpan Data Withdraw');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // 
    }

    public function show($id, Request $request)
    {
        // return GlobalHelper::currentSaldoById($request->user_id);
        if ($request) {
            if (!$request->user_id) {
                return Redirect::back()->with('error', 'Data Member Tidak Ditemukan');
            }
            $amount = GlobalHelper::countReferralAvailableById($request->user_id);
            if ($request->status == 3) {
                if ($amount < $request->acc_amount) {
                    return Redirect::back()->with('error', 'Saldo Tidak Mencukupi');
                }
            }
            $w = RefferralWithdrawModel::where('id', $id)->update([
                'acc_date' => now(),
                'acc_amount' => $request->acc_amount,
                'keterangan' => $request->keterangan,
                'status' => $request->status,
            ]);
            if ($w) {
                return Redirect::back()->with('success', 'Data Terbayar dan Tersimpan');
            }
            return Redirect::back()->with('error', 'Data Tidak Tersimpan');
        }
        return $id;
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        return $request->all();
    }

    public function destroy($id)
    {
        //
    }
}
