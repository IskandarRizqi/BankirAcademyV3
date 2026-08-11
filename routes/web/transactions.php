<?php

use App\Http\Controllers\Backend\CorporateController;
use App\Http\Controllers\Backend\RefferalController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\ProfileController;
use App\Http\Controllers\HomeController as DashboardHomeController;
use App\Http\Controllers\RecentRegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::resource('recent-registrations', RecentRegistrationController::class)
    ->except(['create', 'edit', 'show']);

Route::get('getBerkas', function (Request $request) {
    return Storage::download($request->rf);
})->middleware('auth');

Route::get('/laman-pembayaran/{id}', [OrderController::class, 'laman_pembayaran'])
    ->name('pembayaran.tampil');

Route::get('getBerkasbukti', function (Request $request) {
    $path = Storage::path($request->rf);

    return response()->file($path);
})->middleware('auth');

Route::post('/bayar', [OrderController::class, 'bayar']);
Route::post('/bayarv2', [OrderController::class, 'bayarv2']);
Route::post('/multi-bayar', [OrderController::class, 'multibayar']);
Route::post('/order', [OrderController::class, 'order_class']);
Route::post('/order/send', [CheckoutController::class, 'store']);
// Legacy GET checkout endpoint. Keep unchanged until external callers are audited.
Route::get('/ordernopost', [OrderController::class, 'order_class']);

Route::post('/inputinstructor', [HomeController::class, 'inputinstructor']);
Route::get('/u-laman/{slug}', [HomeController::class, 'laman']);
Route::get('/all-laman', [HomeController::class, 'getAllLaman']);
Route::post('/registerUser', [HomeController::class, 'registerUser']);
Route::post('/registercorporate', [HomeController::class, 'registercorporate']);

Route::redirect('/sdank', '/syarat-dan-ketentuan', 301);

// Disabled: these legacy closures reference views removed from the source tree.
// Route::get('/registerinstructor', fn () => view('front.registerinstructor'));
// Route::get('/registerc', fn () => view('front.register'));
// Route::get('/detail-kelas', fn () => view('front.kelas.detail'));

Route::post('/kode-promo', [ProfileController::class, 'setKodePromo']);
Route::get('/profile-instructor/{id}/{name}', [ProfileController::class, 'profileinstructor']);
Route::post('/set-master-refferal', [RefferalController::class, 'setMasterRefferal']);
Route::get('/review-instructor', [ProfileController::class, 'review_instructor']);

Route::get('/join/referral/{url}', [RefferalController::class, 'joinRef']);
Route::get('/join/referral/{iduser}/{referral}', [RefferalController::class, 'joinRefAjax']);

Route::get('/admin/corporates/{id}', [CorporateController::class, 'show']);
Route::get('/createSitemap', [DashboardHomeController::class, 'createSitemap']);
