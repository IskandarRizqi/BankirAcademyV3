<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Helper\GlobalHelper;
use App\Models\RefferralWithdrawModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

/**
 * Compatibility endpoint for the compact member withdrawal form.
 */
class WithdrawController extends Controller
{
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
        $saldoTersedia = GlobalHelper::currentSaldoById(Auth::user()->id);
        if ($request->nominal_penarikan > $saldoTersedia) {
            return Redirect::back()->withInput($request->all())->with('error', 'Saldo Tidak Cukup');
        }

        $withdrawal = RefferralWithdrawModel::create([
            'user_id' => Auth::user()->id,
            'status' => 0,
            'amount' => $request->nominal_penarikan,
            'nama_bank' => $request->nama_bank,
            'no_rekening' => $request->no_rekening,
            'date' => now(),
        ]);
        if ($withdrawal) {
            return Redirect::back()->with('success', 'Menunggu Konfirmasi Admin');
        }

        return Redirect::back()->withInput($request->all())->with('error', 'Gagal Menimpan Data Withdraw');
    }
}
