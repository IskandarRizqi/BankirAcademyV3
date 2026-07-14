<?php

use App\Http\Controllers\Front\ProfileController;
use App\Http\Controllers\MemberNonAnggota\DataEventKelasController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Member Non Anggota Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Member Non Anggota web routes for your application.
|
*/

Route::middleware('auth')->group(function () {
	Route::resource('dash-beranda', ProfileController::class);
	Route::get('/event-kelas', [DataEventKelasController::class, "dataeventkelas"]);
	Route::get('/detail-event/{unique_id}/{title}', [DataEventKelasController::class, "detailevent"]);
});
