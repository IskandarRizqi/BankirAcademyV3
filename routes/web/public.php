<?php

use App\Http\Controllers\Admin\ClassesController;
use App\Http\Controllers\Admin\LokerApplicationController;
use App\Http\Controllers\Admin\LokerController as AdminLokerController;
use App\Http\Controllers\Front\BankPageController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PagesController;
use App\Http\Controllers\LivePurchaseToastController;
use App\Http\Controllers\Loker\BerandaLoker;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register frontend web routes for your application.
|
*/

Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
Route::get('/pages/page/{id}', [PagesController::class, 'showKelas']);
Route::get('/pages/about', [PagesController::class, 'showAbout']);
Route::redirect('/pages/contact', '/kontak-kami', 301);
Route::get('/pages/blog', [PagesController::class, 'showListBlog']);
Route::get('/pages/blog/{id}/{slug}', [PagesController::class, 'showBlog']);
// Legacy marketing URLs remain available while the new template uses canonical URLs below.
Route::redirect('/pages/Banking-Solution', '/layanan/banking-solution', 301);
Route::redirect('/pages/Capacity-Building', '/layanan/capacity-building', 301);
Route::redirect('/pages/Talent-Solution', '/layanan/banking-talent-solution', 301);

$frontendPages = [
    'frontend.service.banking-solution' => ['layanan/banking-solution', 'frontend.pages.layanan.bankingsolution'],
    'frontend.service.capacity-building' => ['layanan/capacity-building', 'frontend.pages.layanan.capacitysolution'],
    'frontend.service.banking-talent' => ['layanan/banking-talent-solution', 'frontend.pages.layanan.bankingtalent'],
    'frontend.service.lms' => ['layanan/learning-management-system', 'frontend.pages.layanan.lms'],
    'frontend.service.innovation' => ['layanan/inovasi-program', 'frontend.pages.layanan.inovasi'],
    'frontend.service.csr' => ['layanan/program-csr', 'frontend.pages.layanan.csr'],
    'frontend.talent.headhunting' => ['talent/headhunting', 'frontend.pages.talent.headhunting'],
    'frontend.talent.outsourcing' => ['talent/outsourcing', 'frontend.pages.talent.outsourcing'],
    'frontend.talent.job-connect' => ['talent/job-connect', 'frontend.pages.talent.jobconnect'],
    'frontend.foundation.education' => ['foundations/bakti-pendidikan', 'frontend.pages.foundations.baktipendidikan'],
    'frontend.foundation.umkm' => ['foundations/bakti-umkm', 'frontend.pages.foundations.baktiumkm'],
    'frontend.support.faq' => ['faq', 'frontend.pages.support.faq'],
    'frontend.support.terms' => ['syarat-dan-ketentuan', 'frontend.pages.support.terms'],
    'frontend.support.privacy' => ['kebijakan-privasi', 'frontend.pages.support.privacy'],
    'frontend.support.contact' => ['kontak-kami', 'frontend.pages.support.contact'],
    'frontend.curriculum' => ['kurikulum', 'frontend.pages.kurikulum.kurikulum'],
];

foreach ($frontendPages as $name => [$uri, $view]) {
    Route::get('/' . $uri, [BankPageController::class, 'show'])
        ->defaults('frontendView', $view)
        ->name($name);
}
// Route::get('/allclass', function () {
//     return view('frontend.pages.event.bank-catalog');
// })->name('frontend.classes.index');

Route::get('/kelas/{slug}', [BankPageController::class, 'classPage'])
    ->name('frontend.class.detail');
// Class
Route::get('/list-class', [ClassesController::class, 'listClass'])->name('frontend.classes.index');
Route::post('/list-class', [ClassesController::class, 'findClass']);
// Loker Apply
Route::get('admin/apply', [LokerApplicationController::class, 'index'])
    ->middleware('admin.panel')
    ->name('apply.index');
Route::get('admin/getdatacvpelamar', [LokerApplicationController::class, 'getdatacvpelamar'])
    ->middleware('admin.panel')
    ->name('admin.applications.cv');
Route::post('admin/approvecvpelamar', [LokerApplicationController::class, 'approvecvpelamar'])
    ->middleware('admin.panel')
    ->name('admin.applications.approve');
// Loker
Route::resource('loker', BerandaLoker::class);
Route::get('/loker/{id}/detail', [BerandaLoker::class, 'detail']);
Route::post('/loker/apply', [BerandaLoker::class, 'apply']);
Route::get('/admin/loker/getkabupaten/{id}', [AdminLokerController::class, 'getkabupaten'])->middleware('admin.panel');
Route::get('/admin/loker/getkecamatan/{id}', [AdminLokerController::class, 'getkecamatan'])->middleware('admin.panel');
Route::get('/admin/loker/getkelurahan/{id}', [AdminLokerController::class, 'getkelurahan'])->middleware('admin.panel');

Route::get('/promo', [HomeController::class, 'showAllPromo']);
Route::get('/class/{unique_id}/{title}', [HomeController::class, 'detail_class']);

// Disabled: the legacy `front.cvtemplate.cv` view is not present in source.
// Route::get('/template', fn () => view('front.cvtemplate.cv'));
Route::get('/live-purchase-toast', LivePurchaseToastController::class)
    ->middleware('throttle:60,1')
    ->name('live-purchase-toast');
