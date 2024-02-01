<?php

use App\Http\Controllers\Backend\InstructorController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Backend\BannerslideController;
use App\Http\Controllers\Backend\CorporateController;
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
    Route::resource('/admin/prepotes', App\Http\Controllers\Backend\PrepotestController::class);
    Route::resource('/admin/classes', App\Http\Controllers\Admin\ClassesController::class);
    Route::post('/admin/classes/setpricing', [App\Http\Controllers\Admin\ClassesController::class, 'setpricing']);
    Route::post('/admin/classes/setcontent', [App\Http\Controllers\Admin\ClassesController::class, 'setcontent']);
    Route::post('/admin/classes/setevent', [App\Http\Controllers\Admin\ClassesController::class, 'setevent']);
    Route::post('/admin/classes/inputcertificatetemplate/{id}', [App\Http\Controllers\Admin\ClassesController::class, 'setcertificate']);
    Route::get('/admin/classes/createevent/{id}', [App\Http\Controllers\Admin\ClassesController::class, 'createevent']);
    Route::get('/admin/classes/previewcertificate/{id}', [App\Http\Controllers\Admin\ClassesController::class, 'previewcertificate']);
    Route::get('/admin/classes/createcertificate/{id}', [App\Http\Controllers\Admin\ClassesController::class, 'createcertificate']);
    Route::get('/admin/classes/activated/{id}/{status}', [App\Http\Controllers\Admin\ClassesController::class, 'activated']);
    Route::get('/admin/classes/open/{id}/{status}', [App\Http\Controllers\Admin\ClassesController::class, 'open']);
    Route::resource('/admin/instructor', InstructorController::class);
    Route::post('/admin/logininstructor', [InstructorController::class, 'logininstructor']);
    Route::resource('/admin/banner', BannerslideController::class);
    Route::post('/update-banner', [BannerslideController::class, 'updatebanner'])->name('updatebanner');
    Route::get('/admin/pembayaran', [App\Http\Controllers\Backend\PembayaranController::class, 'index']);
    Route::post('/admin/pembayaran/approved', [App\Http\Controllers\Backend\PembayaranController::class, 'approved']);
    Route::post('/admin/pembayaran/certificate', [App\Http\Controllers\Backend\PembayaranController::class, 'publish_certificate']);
    Route::post('/admin/pembayaran/updatebukti', [App\Http\Controllers\Backend\PembayaranController::class, 'update_bukti']);
    Route::get('/admin/partner', [App\Http\Controllers\Backend\PartnerController::class, 'index']);
    Route::post('/admin/partner', [App\Http\Controllers\Backend\PartnerController::class, 'input_partner']);
    Route::post('/admin/partner/delete', [App\Http\Controllers\Backend\PartnerController::class, 'delete_partner']);
    Route::get('/admin/peserta', [App\Http\Controllers\Backend\PesertaController::class, 'index']);
    Route::get('/admin/peserta/corporate', [App\Http\Controllers\Backend\PesertaController::class, 'corporate']);
    Route::get('/admin/peserta/change_existing/{id}/{exs}', [App\Http\Controllers\Backend\PesertaController::class, 'change_existing']);
    Route::get('/admin/classes/getreview/{id}', [App\Http\Controllers\Admin\ClassesController::class, 'getreview']);
    Route::get('/admin/classes/setreview/{id}/{review_active}', [App\Http\Controllers\Admin\ClassesController::class, 'setreview']);
    Route::resource('/admin/kupon', PromoController::class);
    Route::resource('/admin/fee', FeeController::class);
    Route::resource('/admin/corporate', CorporateController::class);
    Route::post('/admin/importcorporate', [CorporateController::class, 'importcorporate']);
    Route::get('/admin/downloadcorporate', [CorporateController::class, 'download']);

    //pages
    Route::delete("/admin/pages/delete/{id}", [App\Http\Controllers\Front\PagesController::class, "delete"]);
    Route::post("/admin/pages/update", [App\Http\Controllers\Front\PagesController::class, "update"]);
    Route::get("/admin/pages/edit/{id}", [App\Http\Controllers\Front\PagesController::class, "edit"]);
    Route::get("/admin/pages", [App\Http\Controllers\Front\PagesController::class, "index"]);
    Route::post("/admin/pages/kelas/{tipe}", [App\Http\Controllers\Front\PagesController::class, "setPageKelas"]);
    Route::get("/admin/pages/kelas/{tipe}", [App\Http\Controllers\Front\PagesController::class, "getPageKelas"]);
    Route::get("/admin/pages/getsdank", [App\Http\Controllers\Front\PagesController::class, "getsdank"]);
    Route::post("/admin/pages/setsdank", [App\Http\Controllers\Front\PagesController::class, "setsdank"]);
    Route::get("/admin/pages/getbantuan", [App\Http\Controllers\Front\PagesController::class, "getAbout"]); //Page Syarat Dan Ketentuan
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

    // Loker
    Route::get('/admin/loker', [App\Http\Controllers\Loker\BerandaLoker::class, 'index_admin']);

    // User
    Route::resource('/admin/user', App\Http\Controllers\Backend\UserController::class);

    // IP
    Route::resource('/admin/ipakses', App\Http\Controllers\Backend\IpController::class);

    // Member
    Route::resource('/admin/member', App\Http\Controllers\Backend\MembershipController::class);
    Route::post("/admin/member/delete", [App\Http\Controllers\Backend\MembershipController::class, "deletes"]);

    // Referral
    Route::resource('/admin/withdraw', App\Http\Controllers\Backend\WithdrawController::class);
    Route::get("/admin/referral", [App\Http\Controllers\Backend\RefferalController::class, "dashboard"]);
    Route::get("/admin/master/index", [App\Http\Controllers\Backend\RefferalController::class, "masterReff"]);
    Route::post("/admin/master/store", [App\Http\Controllers\Backend\RefferalController::class, "storeMasterReff"]);
    Route::delete("/admin/master/del/{id}", [App\Http\Controllers\Backend\RefferalController::class, "delMasterReff"]);
});
Route::middleware('auth')->group(function () {
    Route::post('/admin/inputlogopurusahaan', [App\Http\Controllers\HomeController::class, 'inputlogopurusahaan']);

    Route::post('/classes/biaya_certificate', [App\Http\Controllers\Admin\ClassesController::class, 'biayacertificate']);
    Route::get('/classes/getcertificate/{id}', [App\Http\Controllers\Admin\ClassesController::class, 'getcertificate']);
    Route::get('/classes/getinvoice/{id}', [App\Http\Controllers\Front\InvoiceController::class, 'getInvoice']);
    Route::post('/classes/multiinvoice', [App\Http\Controllers\Front\InvoiceController::class, 'multiInvoice']);
    Route::get('/classes/certificate/{id}', [App\Http\Controllers\Admin\ClassesController::class, 'getCertificate']);
    Route::post('/classes/review', [App\Http\Controllers\Admin\ClassesController::class, 'sendreview']);
    // 
    Route::post("/instructor/classes/store", [App\Http\Controllers\Backend\InstructorController::class, "classesStore"]);
    Route::get("/instructor/classes/create/{id}", [App\Http\Controllers\Backend\InstructorController::class, "classesCreate"]);
    Route::get("/instructor/classes", [App\Http\Controllers\Backend\InstructorController::class, "classes"]);
    Route::get("/instructor/profile", [App\Http\Controllers\Backend\InstructorController::class, "profile"]);
    Route::post("/instructor/profile", [App\Http\Controllers\Backend\InstructorController::class, "profileUpdate"]);
    Route::post("/addreviewinstructor", [App\Http\Controllers\Front\ProfileController::class, "addreviewinstructor"]);
    Route::post("/changestatusreview", [App\Http\Controllers\Front\ProfileController::class, "changestatusreview"]);
    Route::get('/instructor/peserta', [App\Http\Controllers\Backend\PesertaController::class, 'instructor']);

    // Rekening
    Route::post("/updatemember", [App\Http\Controllers\Front\ProfileController::class, "updatemember"]);
    Route::post("/updaterekening", [App\Http\Controllers\Front\ProfileController::class, "updaterekening"]);
    Route::post("/withdrawMember", [App\Http\Controllers\Backend\WithdrawController::class, "proses"]);

    // Prepotes
    Route::post('/prepotes/savejawaban', [App\Http\Controllers\Backend\PrepotestController::class, 'savejawaban']);

    // Lamaran Kerja
    Route::get('/datalamaran', [App\Http\Controllers\Front\ProfileController::class, 'datalamaran']);
    Route::get('/cetaklamaran', [App\Http\Controllers\Front\ProfileController::class, 'cetaklamaran']);
    Route::post('simpanlamaran', [App\Http\Controllers\Front\ProfileController::class, 'simpanlamaran']);

    // Profile
    Route::post('/updateprofile', [App\Http\Controllers\Front\ProfileController::class, 'updateprofile']);
    Route::post('/settingprofile', [App\Http\Controllers\Front\ProfileController::class, 'settingprofile']);
    Route::post('/rekeningprofile', [App\Http\Controllers\Front\ProfileController::class, 'rekeningprofile']);
    Route::get('/getbillingkelas/{type}', [App\Http\Controllers\Front\ProfileController::class, 'getbillingkelas']);
    Route::get('/getkelasanda/{type}', [App\Http\Controllers\Front\ProfileController::class, 'getkelasanda']);
});
Route::get('getBerkas', function (Request $r) {
    return Storage::download($r->rf);
})->middleware('auth');
Route::post('/bayar', [App\Http\Controllers\Front\OrderController::class, 'bayar']);
Route::post('/bayarv2', [App\Http\Controllers\Front\OrderController::class, 'bayarv2']);
Route::post('/multi-bayar', [App\Http\Controllers\Front\OrderController::class, 'multibayar']);
Route::post('/order', [App\Http\Controllers\Front\OrderController::class, 'order_class']);
Route::get('/ordernopost', [App\Http\Controllers\Front\OrderController::class, 'order_class']);
Route::get('/', [App\Http\Controllers\Front\HomeController::class, 'index']);
// Route::get('/index-custom', [App\Http\Controllers\Front\HomeController::class, 'index']);
Route::get('/class/{unique_id}/{title}', [App\Http\Controllers\Front\HomeController::class, 'detail_class']);
Route::post('/inputinstructor', [App\Http\Controllers\Front\HomeController::class, 'inputinstructor']);
Route::get('/u-laman/{slug}', [App\Http\Controllers\Front\HomeController::class, 'laman']);
Route::get('/all-laman', [App\Http\Controllers\Front\HomeController::class, 'getAllLaman']);
Route::post('/registerUser', [App\Http\Controllers\Front\HomeController::class, 'registerUser']);
Route::post('/registercorporate', [App\Http\Controllers\Front\HomeController::class, 'registercorporate']);

Route::get('/sdank', [App\Http\Controllers\Front\PagesController::class, 'showsdank']);
Route::get('/registerinstructor', function () {
    return view('front.registerinstructor');
});
Route::get('/registerc', function () {
    $data = [];
    $data['data'] = App\Models\CorporateModel::get();
    $data['lokasi'] = App\Models\CorporateModel::select('nama')->pluck('nama')->toArray();
    return view('front.register', $data);
});
Route::get('/detail-kelas', function () {
    return view('front.kelas.detail');
});

Route::post("/kode-promo", [App\Http\Controllers\Front\ProfileController::class, "setKodePromo"]);
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
Route::get('/join/referral/{iduser}/{referral}', [App\Http\Controllers\Backend\RefferalController::class, "joinRefAjax"]);

Route::get('/admin/corporates/{id}', [CorporateController::class, 'show']);

Route::get('/createSitemap', [App\Http\Controllers\HomeController::class, "createSitemap"]);
Auth::routes();
Route::get('tesapi', [App\Http\Controllers\Front\HomeController::class, 'tesapi']);
// Loker Apply
Route::resource('admin/apply', App\Http\Controllers\Backend\LokerApplyController::class);
// Loker
Route::resource('loker', App\Http\Controllers\Loker\BerandaLoker::class);
Route::get('/loker/{id}/detail', [App\Http\Controllers\Loker\BerandaLoker::class, "detail"]);
Route::post('/loker/apply', [App\Http\Controllers\Loker\BerandaLoker::class, "apply"]);
Route::get('/admin/loker/getkabupaten/{id}', [App\Http\Controllers\Loker\BerandaLoker::class, 'getkabupaten']);
Route::get('/admin/loker/getkecamatan/{id}', [App\Http\Controllers\Loker\BerandaLoker::class, 'getkecamatan']);
Route::get('/admin/loker/getkelurahan/{id}', [App\Http\Controllers\Loker\BerandaLoker::class, 'getkelurahan']);

Route::get('/template', function () {
    return view('front.cvtemplate.cv');
});
