<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

/**
 * Compatibility endpoint for member invoice PDFs.
 */
class MembershipController extends Controller
{
    public function cetakinvoicepending($id, Request $request)
    {
        $data['profile'] = UserProfileModel::where('user_id', Auth::user()->id)->first();
        $pdf = PDF::loadView('invoice/membershippending', $data);

        return $pdf->setPaper('a4', 'landscape')->stream('invoice.pdf');
    }
}
