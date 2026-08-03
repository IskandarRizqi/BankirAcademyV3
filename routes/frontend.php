<?php

use App\Http\Controllers\Admin\ClassesController;
use App\Http\Controllers\Backend\LokerApplyController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\BankPageController;
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
Route::get("/pages/page/{id}", [PagesController::class, "showKelas"]);
Route::get("/pages/about", [PagesController::class, "showAbout"]);
Route::redirect('/pages/contact', '/kontak-kami', 301);
Route::get("/pages/blog", [PagesController::class, "showListBlog"]);
Route::get("/pages/blog/{id}/{slug}", [PagesController::class, "showBlog"]);
// Legacy marketing URLs remain available while the new template uses canonical URLs below.
Route::redirect('/pages/Banking-Solution', '/layanan/banking-solution', 301);
Route::redirect('/pages/Capacity-Building', '/layanan/capacity-building', 301);
Route::redirect('/pages/Talent-Solution', '/layanan/banking-talent-solution', 301);

$bankPages = [
    'frontend.service.banking-solution' => ['layanan/banking-solution', 'frontend.pages.layanan.bankingsolution', 'banking-solution'],
    'frontend.service.capacity-building' => ['layanan/capacity-building', 'frontend.pages.layanan.capacitysolution', 'capacity-building'],
    'frontend.service.banking-talent' => ['layanan/banking-talent-solution', 'frontend.pages.layanan.bankingtalent', 'banking-talent-solution'],
    'frontend.service.lms' => ['layanan/learning-management-system', 'frontend.pages.layanan.lms', 'learning-management-system'],
    'frontend.service.innovation' => ['layanan/inovasi-program', 'frontend.pages.layanan.inovasi', 'inovasi-program'],
    'frontend.service.csr' => ['layanan/program-csr', 'frontend.pages.layanan.csr', 'program-csr'],
    'frontend.talent.headhunting' => ['talent/headhunting', 'frontend.pages.talent.headhunting', 'headhunting'],
    'frontend.talent.outsourcing' => ['talent/outsourcing', 'frontend.pages.talent.outsourcing', 'outsourcing'],
    'frontend.talent.job-connect' => ['talent/job-connect', 'frontend.pages.talent.jobconnect', 'job-connect'],
    'frontend.foundation.education' => ['foundations/bakti-pendidikan', 'frontend.pages.foundations.baktipendidikan', 'bakti-pendidikan'],
    'frontend.foundation.umkm' => ['foundations/bakti-umkm', 'frontend.pages.foundations.baktiumkm', 'bakti-umkm'],
    'frontend.support.faq' => ['faq', 'frontend.pages.support.faq', 'tanya-jawab'],
    'frontend.support.terms' => ['syarat-dan-ketentuan', 'frontend.pages.support.terms', 'syarat-dan-ketentuan'],
    'frontend.support.privacy' => ['kebijakan-privasi', 'frontend.pages.support.privacy', 'kebijakan-privasi'],
    'frontend.support.contact' => ['kontak-kami', 'frontend.pages.support.contact', 'kontak-kami'],
    'frontend.curriculum' => ['kurikulum', 'frontend.pages.kurikulum.kurikulum', 'kurikulum'],
    'frontend.classes.index' => ['kelas-online', 'frontend.pages.event.bank-catalog', 'kelas-online'],
];

foreach ($bankPages as $name => [$uri, $view, $bankPage]) {
    Route::get('/' . $uri, [BankPageController::class, 'show'])
        ->defaults('bankView', $view)
        ->defaults('bankPage', $bankPage)
        ->name($name);
}

Route::get('/kelas/{slug}', [BankPageController::class, 'classPage'])
    ->whereIn('slug', [
        'kelas-ai-literacy-for-banking-professionals',
        'kelas-apu-ppt-untuk-pegawai-bpr-bprs',
        'kelas-dasar-analisis-kredit-perbankan',
        'kelas-dasar-tata-kelola-dan-audit-ti-perbankan',
        'kelas-digital-marketing-untuk-bpr-bprs',
        'kelas-first-time-manager-in-banking',
        'kelas-general-banking-fundamentals',
        'kelas-keuangan-praktis-untuk-pelaku-umkm',
        'kelas-kpi-dan-okr-untuk-organisasi-perbankan',
        'kelas-manajemen-risiko-operasional-perbankan',
        'kelas-persiapan-seleksi-dan-karier-perbankan',
        'kelas-service-excellence-dan-customer-experience',
    ])
    ->name('frontend.class.static');
// Class
Route::get('/list-class', [ClassesController::class, "listClass"]);
Route::post('/list-class', [ClassesController::class, "findClass"]);
// Loker Apply
Route::resource('admin/apply', LokerApplyController::class);
Route::get('admin/getdatacvpelamar', [LokerApplyController::class, 'getdatacvpelamar']);
Route::post('admin/approvecvpelamar', [LokerApplyController::class, 'approvecvpelamar']);
// Loker
Route::resource('loker', BerandaLoker::class);
Route::get('/loker/{id}/detail', [BerandaLoker::class, "detail"]);
Route::post('/loker/apply', [BerandaLoker::class, "apply"]);
Route::get('/admin/loker/getkabupaten/{id}', [BerandaLoker::class, 'getkabupaten']);
Route::get('/admin/loker/getkecamatan/{id}', [BerandaLoker::class, 'getkecamatan']);
Route::get('/admin/loker/getkelurahan/{id}', [BerandaLoker::class, 'getkelurahan']);

Route::get("/promo", [HomeController::class, "showAllPromo"]);
Route::get('/class/{unique_id}/{title}', [HomeController::class, 'detail_class']);


Route::get('/template', function () {
	return view('front.cvtemplate.cv');
});
Route::get('/live-purchase-toast', LivePurchaseToastController::class)
    ->middleware('throttle:60,1')
    ->name('live-purchase-toast');
