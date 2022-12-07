<?php

use App\Http\Controllers\Backend\InstructorController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Backend\BannerslideController;
use App\Http\Controllers\Backend\FeeController;
use App\Http\Controllers\Backend\PromoController;
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
    Route::post('/admin/logininstructor', [InstructorController::class, 'logininstructor']);
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
    Route::resource('/admin/kupon', PromoController::class);
    Route::resource('/admin/fee', FeeController::class);

    //pages
    Route::delete("/admin/pages/delete/{id}", [App\Http\Controllers\Front\PagesController::class, "delete"]);
    Route::post("/admin/pages/update", [App\Http\Controllers\Front\PagesController::class, "update"]);
    Route::get("/admin/pages/edit/{id}", [App\Http\Controllers\Front\PagesController::class, "edit"]);
    Route::get("/admin/pages", [App\Http\Controllers\Front\PagesController::class, "index"]);
    Route::post("/admin/pages/kelas/{tipe}", [App\Http\Controllers\Front\PagesController::class, "setPageKelas"]);
    Route::get("/admin/pages/kelas/{tipe}", [App\Http\Controllers\Front\PagesController::class, "getPageKelas"]);
    Route::get("/admin/pages/getsdank", [App\Http\Controllers\Front\PagesController::class, "getsdank"]);
    Route::post("/admin/pages/setsdank", [App\Http\Controllers\Front\PagesController::class, "setsdank"]);
    Route::get("/admin/pages/getabout", [App\Http\Controllers\Front\PagesController::class, "getAbout"]);
    Route::post("/admin/pages/setabout", [App\Http\Controllers\Front\PagesController::class, "setAbout"]);
    Route::get("/admin/pages/getcontact", [App\Http\Controllers\Front\PagesController::class, "getContact"]);
    Route::post("/admin/pages/setcontact", [App\Http\Controllers\Front\PagesController::class, "setContact"]);
    Route::get("/admin/pages/getbloglist", [App\Http\Controllers\Front\PagesController::class, "getListBlog"]);
    Route::get("/admin/pages/getblog/{id}", [App\Http\Controllers\Front\PagesController::class, "getBlog"]);
    Route::get("/admin/pages/delblog/{id}", [App\Http\Controllers\Front\PagesController::class, "delBlog"]);
    Route::post("/admin/pages/setblog/{id}", [App\Http\Controllers\Front\PagesController::class, "setBlog"]);

    // Laman
    Route::get("/admin/laman", [App\Http\Controllers\Admin\LamanController::class, "index"]);
    Route::get("/admin/laman/create", [App\Http\Controllers\Admin\LamanController::class, "create"]);
    Route::post("/admin/laman/store", [App\Http\Controllers\Admin\LamanController::class, "store"]);
    Route::get("/admin/laman/edit/{id}", [App\Http\Controllers\Admin\LamanController::class, "edit"]);
    Route::delete("/admin/laman/destroy/{id}", [App\Http\Controllers\Admin\LamanController::class, "destroy"]);
    Route::get("/admin/laman/activated/{id}/{status}", [App\Http\Controllers\Admin\LamanController::class, "activated"]);

    // Referral
    Route::get("/admin/master/index", [App\Http\Controllers\Backend\RefferalController::class, "masterReff"]);
    Route::post("/admin/master/store", [App\Http\Controllers\Backend\RefferalController::class, "storeMasterReff"]);
    Route::delete("/admin/master/del/{id}", [App\Http\Controllers\Backend\RefferalController::class, "delMasterReff"]);
});
Route::middleware('auth')->group(function () {
    Route::get('/classes/getcertificate/{id}', [App\Http\Controllers\Admin\ClassesController::class, 'getcertificate']);
    Route::get('/classes/getinvoice/{id}', [App\Http\Controllers\Front\InvoiceController::class, 'getInvoice']);
    Route::get('/classes/certificate/{id}', [App\Http\Controllers\Admin\ClassesController::class, 'getCertificate']);
    Route::post('/classes/review', [App\Http\Controllers\Admin\ClassesController::class, 'sendreview']);
    // 
    Route::post("/instructor/classes/store", [App\Http\Controllers\Backend\InstructorController::class, "classesStore"]);
    Route::get("/instructor/classes/create", [App\Http\Controllers\Backend\InstructorController::class, "classesCreate"]);
    Route::get("/instructor/classes", [App\Http\Controllers\Backend\InstructorController::class, "classes"]);
    Route::get("/instructor/profile", [App\Http\Controllers\Backend\InstructorController::class, "profile"]);
    Route::post("/instructor/profile", [App\Http\Controllers\Backend\InstructorController::class, "profileUpdate"]);
    Route::post("/addreviewinstructor", [App\Http\Controllers\Front\ProfileController::class, "addreviewinstructor"]);
    Route::post("/changestatusreview", [App\Http\Controllers\Front\ProfileController::class, "changestatusreview"]);
    Route::get('/instructor/peserta', [App\Http\Controllers\Backend\PesertaController::class, 'instructor']);
});
Route::get('getBerkas', function (Request $r) {
    return Storage::download($r->rf);
})->middleware('auth');
Route::post('/bayar', [App\Http\Controllers\Front\OrderController::class, 'bayar']);
Route::post('/order', [App\Http\Controllers\Front\OrderController::class, 'order_class']);
Route::get('/ordernopost', [App\Http\Controllers\Front\OrderController::class, 'order_class']);
Route::get('/', [App\Http\Controllers\Front\HomeController::class, 'index']);
Route::get('/class/{unique_id}/{title}', [App\Http\Controllers\Front\HomeController::class, 'detail_class']);
Route::post('/inputinstructor', [App\Http\Controllers\Front\HomeController::class, 'inputinstructor']);
Route::get('/u-laman/{slug}', [App\Http\Controllers\Front\HomeController::class, 'laman']);
Route::get('/all-laman', [App\Http\Controllers\Front\HomeController::class, 'getAllLaman']);
Route::post('/registerUser', [App\Http\Controllers\Front\HomeController::class, 'registerUser']);

Route::get('/sdank', [App\Http\Controllers\Front\PagesController::class, 'showsdank']);
Route::get('/registerinstructor', function () {
    return view('front.registerinstructor');
});
Route::get('/registerc', function () {
    return view('front.register');
});
Route::get('/detail-kelas', function () {
    return view('front.kelas.detail');
});

Route::post("/kode-promo/{id}/{kode}/{payment}", [App\Http\Controllers\Front\ProfileController::class, "setKodePromo"]);
Route::get("/profile-instructor/{id}/{name}", [App\Http\Controllers\Front\ProfileController::class, "profileinstructor"]);
Route::post("/set-master-refferal", [App\Http\Controllers\Backend\RefferalController::class, "setMasterRefferal"]);

Route::get("/promo", [App\Http\Controllers\Front\HomeController::class, "showAllPromo"]);
Route::get("/auth/{provider}", [SocialiteController::class, "redirectToProvider"]);
Route::get("/auth/{provider}/callback", [SocialiteController::class, "handleProviderCallback"]);
Route::resource('profile', ProfileController::class)->middleware('auth');
Route::get("/review-instructor", [App\Http\Controllers\Front\ProfileController::class, "review_instructor"]);
Route::get("/instructor/{provider}", [App\Http\Controllers\Front\HomeController::class, "redirectToProvider"]);
Route::get("/instructor/{provider}/callback", [App\Http\Controllers\Front\HomeController::class, "handleProviderCallback"]);

// Pages
Route::get("/pages/page/{id}", [App\Http\Controllers\Front\PagesController::class, "showKelas"]);
Route::get("/pages/about", [App\Http\Controllers\Front\PagesController::class, "showAbout"]);
Route::get("/pages/contact", [App\Http\Controllers\Front\PagesController::class, "showContact"]);
Route::get("/pages/blog", [App\Http\Controllers\Front\PagesController::class, "showListBlog"]);
Route::get("/pages/blog/{id}/{slug}", [App\Http\Controllers\Front\PagesController::class, "showBlog"]);

// Class
Route::get('/list-class', [App\Http\Controllers\Admin\ClassesController::class, "listClass"]);
Route::post('/list-class', [App\Http\Controllers\Admin\ClassesController::class, "findClass"]);

// Referral
Route::get('/join/referral/{url}', [App\Http\Controllers\Backend\RefferalController::class, "joinRef"]);

Auth::routes();
