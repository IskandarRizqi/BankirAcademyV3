<?php

namespace App\Http\Controllers;

use App\Models\ClassesModel;
use App\Models\ClassParticipantModel;
use App\Models\ClassPaymentModel;
use App\Models\DashboardModel;
use App\Models\FeeModel;
use App\Models\InstructorModel;
use App\Models\InstructorReviewModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Spatie\Sitemap\SitemapGenerator;

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
        $data = [];
        // Dashboard Instructor
        if ($auth->role == 3) {
            $data['data'] = json_encode([2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2, 2.3, 1.4, 0.8, 0.5, 0.2]);
            $ins = InstructorModel::where('user_id', Auth::user()->id)->first();
            for ($i = 1; $i < 13; $i++) {
                $class[] = ClassesModel::where('instructor', 'like', '%"' . $ins->id . '"%')
                    // ->whereDate('date_end', '<', Carbon::now())
                    ->whereMonth('created_at', $i)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->count();
            }
            $data['class'] = json_encode($class);
            $i = InstructorModel::where('user_id', $auth->id)->first();
            $data['review'] = InstructorReviewModel::select('instructor_review.*', 'users.name')
                ->join('users', 'users.id', 'instructor_review.users_id')
                ->where('instructor_review.instructor_id', $i->id)
                ->get();
            return view('backend.instructor.dashboard', $data);
        }
        $data['fee'] = ClassPaymentModel::select('class_payment.*', 'classes.title', 'users.name')
            ->join('classes', 'classes.id', 'class_payment.class_id')
            ->join('users', 'users.id', 'class_payment.user_id')
            ->where('class_payment.status', 1)
            ->get();
        foreach ($data['fee'] as $key => $value) {
            $f = FeeModel::where('class_id', 'like', '%"' . $value->title . '"%')->get();
            if ($f) {
                $value->data_fee = $f;
            } else {
                $value->data_fee = FeeModel::where('class_id', 'null')->get();
            }
        }

        $data['peserta'] = ClassParticipantModel::select('class_participant.*', 'users.name', 'users.google_id', 'classes.title', 'user_profile.phone', 'user_profile.picture', 'users.corporate')
            ->join('users', 'users.id', 'class_participant.user_id')
            ->join('classes', 'classes.id', 'class_participant.class_id')
            ->leftJoin('user_profile', 'user_profile.user_id', 'class_participant.user_id')
            ->whereNotNull('users.corporate')
            ->get();
        // return $data;
        return view('backend.beranda', $data);
    }

    public function createSitemap()
    {
        SitemapGenerator::create(env('APP_URL'))->writeToFile(public_path('sitemap.xml'));
    }

    public function inputlogopurusahaan(Request $request)
    {
        if ($request->checked) {
            $d = DashboardModel::updateOrCreate([
                'id' => $request->id
            ], [
                'logo_perusahaan' => json_encode($request->checked)
            ]);

            if ($d) {
                return Redirect::back()->with('success', 'Data Tersimpan');
            }
            return Redirect::back()->with('info', 'Data Tidak Tersimpan');
        }
    }
}
