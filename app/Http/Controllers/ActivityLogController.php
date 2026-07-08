<?php
namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Ambil log terbaru, eager load data user ('causer')
        $logs = Activity::with('causer')
                        ->latest()
                        ->get();

        return view('compact.activity-log', compact('logs'));
    }
} 