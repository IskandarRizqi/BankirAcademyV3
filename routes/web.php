<?php

use App\Http\Middleware\IsAdminRoot;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware([IsAdminRoot::class])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
Route::get('/', function () {
    return view('front.home.home');
});
Route::get('/registerc', function () {
    return view('front.register');
});
Route::get('/profile', function () {
    return view('front.profile.profile');
});
Route::get('/detail-kelas', function () {
    return view('front.kelas.detail');
});

Auth::routes();
