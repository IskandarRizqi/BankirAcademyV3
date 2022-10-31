<?php

use App\Http\Controllers\Backend\InstructorController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Backend\BannerslideController;
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
    Route::post('/admin/classes/inputcertificatetemplate/{id}', [App\Http\Controllers\Admin\ClassesController::class, 'setcertificate']);
    Route::get('/admin/classes/createevent/{id}', [App\Http\Controllers\Admin\ClassesController::class, 'createevent']);
    Route::get('/admin/classes/previewcertificate/{id}', [App\Http\Controllers\Admin\ClassesController::class, 'previewcertificate']);
    Route::get('/admin/classes/createcertificate/{id}', [App\Http\Controllers\Admin\ClassesController::class, 'createcertificate']);
    Route::resource('/admin/instructor', InstructorController::class);
    Route::resource('/admin/banner', BannerslideController::class);
    Route::post('/update-banner', [BannerslideController::class, 'updatebanner'])->name('updatebanner');
    Route::get('/admin/pembayaran', [App\Http\Controllers\Backend\PembayaranController::class, 'index']);
    Route::post('/admin/pembayaran/approved', [App\Http\Controllers\Backend\PembayaranController::class, 'approved']);
    Route::post('/admin/pembayaran/certificate', [App\Http\Controllers\Backend\PembayaranController::class, 'publish_certificate']);
    Route::get('/admin/partner', [App\Http\Controllers\Backend\PartnerController::class, 'index']);
    Route::post('/admin/partner', [App\Http\Controllers\Backend\PartnerController::class, 'input_partner']);
    Route::post('/admin/partner/delete', [App\Http\Controllers\Backend\PartnerController::class, 'delete_partner']);
    Route::get('/admin/peserta', [App\Http\Controllers\Backend\PesertaController::class, 'index']);
    Route::get('/admin/classes/getreview/{id}', [App\Http\Controllers\Admin\ClassesController::class, 'getreview']);
    Route::get('/admin/classes/setreview/{id}/{review_active}', [App\Http\Controllers\Admin\ClassesController::class, 'setreview']);
});
Route::middleware('auth')->group(function () {
    Route::get('/classes/getcertificate/{id}', [App\Http\Controllers\Admin\ClassesController::class, 'getcertificate']);
    Route::get('/classes/getinvoice/{id}', [App\Http\Controllers\Front\InvoiceController::class, 'getInvoice']);
    Route::get('/classes/certificate/{id}', [App\Http\Controllers\Admin\ClassesController::class, 'getCertificate']);
    Route::post('/classes/review', [App\Http\Controllers\Admin\ClassesController::class, 'sendreview']);
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
