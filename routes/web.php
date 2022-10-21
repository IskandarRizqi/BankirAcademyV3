<?php

use App\Http\Controllers\Backend\InstructorController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Front\ProfileController;
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
    Route::get('/admin', function (){return redirect('/home');});
    Route::resource('/admin/classes', App\Http\Controllers\Admin\ClassesController::class);
    Route::post('/admin/classes/setpricing', [App\Http\Controllers\Admin\ClassesController::class,'setpricing']);
    Route::post('/admin/classes/setcontent', [App\Http\Controllers\Admin\ClassesController::class,'setcontent']);
    Route::resource('/admin/instructor', InstructorController::class);
});
Route::get('/', function () {
    return view('front.home.home');
});
Route::get('/registerc', function () {
    return view('front.register');
});
Route::get('/detail-kelas', function () {
    return view('front.kelas.detail');
});

Route::get("/auth/{provider}", [SocialiteController::class, "redirectToProvider"]);
Route::get("/auth/{provider}/callback", [SocialiteController::class, "handleProviderCallback"]);
Route::resource('profile', ProfileController::class)->middleware('auth');

Auth::routes();
