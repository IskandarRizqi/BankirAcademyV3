<?php

namespace App\Http\Controllers\Front;

use App\Models\ClassesModel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BankPageController
{
    public function show(Request $request)
    {
        $view = $request->route('frontendView');

        return view($view);
    }

    public function classPage(Request $request, string $slug)
    {
        $now = Carbon::now();
        // Mengambil data kelas dinamis berdasarkan slug
        $class = ClassesModel::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();
        $currentYear  = $now->year;
        // Mengambil 3 kelas terkait (selain kelas yang sedang dibuka)
        $relatedClasses = ClassesModel::where('status', 1)
            ->where('id', '!=', $class->id) 
            ->whereYear('date_start', $currentYear)
            ->where('date_end', '>', $now->format('Y-m-d'))->where('date_start', '<=', $now->format('Y-m-d'))
            ->where('status', 1)->where('iht', 0)
            ->orderBy('date_end', 'asc')
            ->take(3)
            ->get();

        return view('frontend.pages.kelas.detail', compact('class', 'relatedClasses'));
    }
}
