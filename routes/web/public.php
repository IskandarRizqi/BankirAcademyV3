<?php

use App\Http\Controllers\Admin\ClassesController;
use App\Http\Controllers\ArticleGeneratorController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\Front\BankPageController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\NewsController;
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

Route::get('/', [HomeController::class, 'index'])
    ->middleware('visitor')
    ->name('frontend.home');
Route::get('/robots.txt', function () {
    return response(
        "User-agent: *\nDisallow:\n\nSitemap: ".rtrim(config('app.url'), '/')."/sitemap.xml\n",
        200,
        ['Content-Type' => 'text/plain']
    );
});
Route::get('/artikel', [ArticleGeneratorController::class, 'publicIndex'])
    ->middleware('visitor')
    ->name('frontend.articles.index');
Route::get('/artikel/{slug}', [ArticleGeneratorController::class, 'publicShow'])
    ->middleware('visitor')
    ->name('frontend.articles.show');
Route::get('/berita', [NewsController::class, 'index'])
    ->middleware('visitor')
    ->name('frontend.news.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])
    ->middleware('visitor')
    ->name('frontend.news.show');
Route::get('/pages/page/{id}', [PagesController::class, 'showKelas'])->middleware('visitor');
Route::get('/pages/about', [PagesController::class, 'showAbout'])->middleware('visitor');
Route::redirect('/pages/contact', '/kontak-kami', 301);
Route::get('/pages/blog', [PagesController::class, 'showListBlog'])->middleware('visitor');
Route::post('/kontak/kirim', [ContactController::class, 'send'])->name('contact.send');
Route::get('/pages/blog/{id}/{slug}', [PagesController::class, 'showBlog'])->middleware('visitor');
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
    Route::get('/'.$uri, [BankPageController::class, 'show'])
        ->middleware('visitor')
        ->defaults('frontendView', $view)
        ->name($name);
}
// Route::get('/allclass', function () {
//     return view('frontend.pages.event.bank-catalog');
// })->name('frontend.classes.index');

Route::get('/kelas/{slug}/landing', [BankPageController::class, 'landingPage'])
    ->middleware('visitor')
    ->name('frontend.class.landing');
Route::post('/kelas/{slug}/checkout', [BankPageController::class, 'checkout'])
    ->name('frontend.class.checkout');
Route::get('/kelas/{slug}', [BankPageController::class, 'classPage'])
    ->middleware('visitor')
    ->name('frontend.class.detail');
Route::get('/exam/{token}/selesai', [ExamController::class, 'thanks'])
    ->middleware('visitor')
    ->where('token', '[A-Za-z0-9]+')
    ->name('exam.thanks');
Route::get('/exam/{token}', [ExamController::class, 'show'])
    ->middleware('visitor')
    ->where('token', '[A-Za-z0-9]+')
    ->name('exam.show');
Route::post('/exam/{token}', [ExamController::class, 'submit'])
    ->where('token', '[A-Za-z0-9]+')
    ->middleware('throttle:10,1')
    ->name('exam.submit');
// Class
Route::get('/list-class', [ClassesController::class, 'listClass'])
    ->middleware('visitor')
    ->name('frontend.classes.index');
Route::post('/list-class', [ClassesController::class, 'findClass']);
// Loker
Route::resource('loker', BerandaLoker::class)->middleware('visitor');
Route::get('/loker/{id}/detail', [BerandaLoker::class, 'detail'])->middleware('visitor');
Route::post('/loker/apply', [BerandaLoker::class, 'apply'])->middleware('auth');

Route::get('/promo', [HomeController::class, 'showAllPromo'])->middleware('visitor');
Route::get('/class/{unique_id}/{title}', [HomeController::class, 'detail_class'])->middleware('visitor');

// Disabled: the legacy `front.cvtemplate.cv` view is not present in source.
// Route::get('/template', fn () => view('front.cvtemplate.cv'));
Route::get('/live-purchase-toast', LivePurchaseToastController::class)
    ->middleware('throttle:60,1')
    ->name('live-purchase-toast');
