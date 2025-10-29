<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function ShowBankingSolution() {

    $data = [];
    return view('front.layanan.bankingsolution', $data);
    }


    public function ShowCapacityBuilding() {

    $data = [];
    return view('front.layanan.capacitybuilding', $data);
    }

    public function ShowCTalentSolution() {

    $data = [];
    return view('front.layanan.talentsolution', $data);
    }
}
