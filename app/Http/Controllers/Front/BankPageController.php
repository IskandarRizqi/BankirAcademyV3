<?php

namespace App\Http\Controllers\Front;

use App\Models\ClassesModel;
use Illuminate\Http\Request;

class BankPageController
{
    public function show(Request $request)
    {
        $view = $request->route('frontendView');

        return view($view);
    }

    public function classPage(Request $request, string $slug)
    {
        // Mengambil data kelas dinamis berdasarkan slug
        $class = ClassesModel::where('id', $slug)
            ->where('status', 1)
            ->firstOrFail();

        // Mengambil 3 kelas terkait (selain kelas yang sedang dibuka)
        $relatedClasses = ClassesModel::where('status', 1)
            ->where('id', '!=', $class->id)
            ->take(3)
            ->get();

        return view('frontend.pages.kelas.detail', compact('class', 'relatedClasses'));
    }
}
