<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ClassPaymentModel;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $data['pembayaran'] = ClassPaymentModel::get();
        return view('backend.pembayaran.pembayaran', $data);
    }
}
