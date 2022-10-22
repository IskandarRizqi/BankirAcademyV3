<?php

use App\Http\Controllers\Backend\InstructorController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Front\ProfileController;
use App\Http\Middleware\IsAdminRoot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
    Route::get('/admin', function () {
        return redirect('/home');
    });
    Route::resource('/admin/classes', App\Http\Controllers\Admin\ClassesController::class);
    Route::post('/admin/classes/setpricing', [App\Http\Controllers\Admin\ClassesController::class, 'setpricing']);
    Route::post('/admin/classes/setcontent', [App\Http\Controllers\Admin\ClassesController::class, 'setcontent']);
    Route::post('/admin/classes/setevent', [App\Http\Controllers\Admin\ClassesController::class, 'setevent']);
    Route::get('/admin/classes/createevent/{id}', [App\Http\Controllers\Admin\ClassesController::class, 'createevent']);
    Route::resource('/admin/instructor', InstructorController::class);
    Route::get('/admin/pembayaran', [App\Http\Controllers\Backend\PembayaranController::class, 'index']);
});
Route::get('getBerkas', function (Request $r) {
    return Storage::download($r->rf);
})->middleware('auth');
Route::post('/bayar', [App\Http\Controllers\Front\OrderController::class, 'bayar']);
Route::post('/order', [App\Http\Controllers\Front\OrderController::class, 'order_class']);
Route::get('/', [App\Http\Controllers\Front\HomeController::class, 'index']);
Route::get('/class/{unique_id}/{title}', [App\Http\Controllers\Front\HomeController::class, 'detail_class']);
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
