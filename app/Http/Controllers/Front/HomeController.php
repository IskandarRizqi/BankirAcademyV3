<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BannerModel;
use App\Models\ClassesModel;
use App\Models\ClassEventModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $data['bannerslide'] = BannerModel::get();
        $data['pop'] = ClassesModel::limit(6)->get();
        $data['message'] = '';
        if (Auth::user()) {
            $data['message'] = 'Login Berhasil';
        }
        return view('front.home.home', $data);
    }

    public function detail_class($unique_id, $title)
    {
        $data['pop'] = ClassesModel::where('unique_id', '!=', $unique_id)->limit(3)->inRandomOrder()->get();
        $data['class'] = ClassesModel::where('unique_id', $unique_id)->first();
        $data['event'] = ClassEventModel::where('class_id', $data['class']->id)->get();

        return view('front.kelas.detail', $data);
    }
}
