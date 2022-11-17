<?php

namespace App\Http\Controllers;

use App\Models\ClassesModel;
use App\Models\InstructorModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $auth = Auth::user();
        if ($auth->role == 3) {
            $data['data'] = json_encode([2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2, 2.3, 1.4, 0.8, 0.5, 0.2]);
            $ins = InstructorModel::where('user_id', Auth::user()->id)->first();
            for ($i = 1; $i < 13; $i++) {
                $class[] = ClassesModel::where('instructor', 'like', '%"' . $ins->id . '"%')
                    ->whereDate('date_end', '<', Carbon::now())
                    ->whereMonth('created_at', $i)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->count();
            }
            $data['class'] = json_encode($class);
            return view('backend.instructor.dashboard', $data);
        }
        return view('backend.beranda');
    }
}
