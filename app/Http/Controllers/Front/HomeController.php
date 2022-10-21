<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ClassesModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['pop'] = ClassesModel::limit(5)->get();
        // return $data;
        return view('front.home.home', $data);
    }
}
