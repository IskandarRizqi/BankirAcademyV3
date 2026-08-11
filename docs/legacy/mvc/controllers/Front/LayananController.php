<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function ShowBankingSolution()
    {

        $data = [];
        return view('frontend.pages.layanan.bankingsolution', $data);
    }


    public function ShowCapacityBuilding()
    {

        $data = [];
        return view('frontend.pages.layanan.capacitysolution', $data);
    }

    public function ShowCTalentSolution()
    {

        $data = [];
        return view('frontend.pages.layanan.bankingtalent', $data);
    }
}
