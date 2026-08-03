<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

class BankPageController
{
    public function show(Request $request)
    {
        $view = $request->route('bankView');

        return view($view, [
            'bankPage' => $request->route('bankPage'),
        ]);
    }

    public function classPage(Request $request, string $slug)
    {
        return view('frontend.pages.kelas.detail', [
            'bankPage' => $slug,
        ]);
    }
}
