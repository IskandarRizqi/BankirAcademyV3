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
            ->with('pricingData')
            ->firstOrFail();
        // Mengambil 3 kelas terkait (selain kelas yang sedang dibuka)
        $relatedClasses = ClassesModel::query()
            ->landingVisible($now)
            ->where('id', '!=', $class->id) 
            ->with('pricingData')
            ->orderBy('date_end', 'asc')
            ->take(3)
            ->get();

        return view('frontend.pages.kelas.detail', compact('class', 'relatedClasses'));
    }
}
