<?php

use App\Http\Controllers\Admin\ClassesController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\InstructorController as AdminInstructorController;
use App\Http\Controllers\Admin\LokerController as AdminLokerController;
use App\Http\Controllers\Admin\LokerApplicationController;
use App\Http\Controllers\Admin\LokerDraftController;
use App\Http\Controllers\Admin\ManualClassOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ScraperApiKeyController;
use App\Http\Controllers\Admin\SopController;
use App\Http\Controllers\ArticleGeneratorController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\IsAdminRoot;
use Illuminate\Support\Facades\Route;

Route::middleware([IsAdminRoot::class])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/admin', function () {
        return redirect('/home');
    })->middleware('admin.panel');

    Route::resource('/admin/classes', ClassesController::class)
        ->except(['show'])
        ->middleware('admin.panel');
    Route::post('/admin/classes/setadditional', [ClassesController::class, 'setadditional'])->middleware('admin.panel');
    Route::post('/admin/classes/setpricing', [ClassesController::class, 'setpricing'])->middleware('admin.panel');
    Route::post('/admin/classes/setcontent', [ClassesController::class, 'setcontent'])->middleware('admin.panel');
    Route::get('/admin/classes/previewcertificate/{id}/{nama}/{instansi}', [ClassesController::class, 'previewcertificateAdmin']);
    Route::post('/admin/classes/setevent', [ClassesController::class, 'setevent'])->middleware('admin.panel');
    Route::post('/admin/classes/inputcertificatetemplate/{id}', [ClassesController::class, 'setcertificate'])->middleware('admin.panel');
    Route::get('/admin/classes/createevent/{id}', [ClassesController::class, 'createevent'])->middleware('admin.panel');
    Route::get('/admin/classes/createcertificate/{id}', [ClassesController::class, 'createcertificate'])->middleware('admin.panel');
    Route::get('/admin/classes/activated/{id}/{status}', [ClassesController::class, 'activated'])->middleware('admin.panel');
    Route::get('/admin/classes/open/{id}/{status}', [ClassesController::class, 'open'])->middleware('admin.panel');
    Route::get('/admin/classes/getreview/{id}', [ClassesController::class, 'getreview'])->middleware('admin.panel');
    Route::get('/admin/classes/setreview/{id}/{review_active}', [ClassesController::class, 'setreview'])->middleware('admin.panel');
    Route::post('/admin/classes/setupcoming', [ClassesController::class, 'setupcoming'])->middleware('admin.panel');

    Route::get('/admin/instructor', [AdminInstructorController::class, 'index'])
        ->middleware('admin.panel')
        ->name('instructor.index');
    Route::post('/admin/instructor', [AdminInstructorController::class, 'store'])
        ->middleware('admin.panel')
        ->name('instructor.store');
    Route::get('/admin/instructor/{id}', [AdminInstructorController::class, 'show'])
        ->middleware('admin.panel')
        ->name('instructor.show');
    Route::delete('/admin/instructor/{id}', [AdminInstructorController::class, 'destroy'])
        ->middleware('admin.panel')
        ->name('instructor.destroy');
    Route::post('/admin/logininstructor', [AdminInstructorController::class, 'logininstructor'])->middleware('admin.panel');

    Route::get('/admin/pembayaran', [AdminPaymentController::class, 'index'])
        ->middleware('admin.panel')
        ->name('admin.payments.index');
    Route::get('/docs/api/loker', [ScraperApiKeyController::class, 'index'])->name('scraper-keys.index');
    Route::get('/loker-drafts', [LokerDraftController::class, 'index'])->name('lokerdraft.index');
    Route::post('/loker-drafts/import', [LokerDraftController::class, 'import'])->name('loker-draft.import');
    Route::patch('/loker-drafts/{id}', [LokerDraftController::class, 'update'])->name('lokerdraft.update');
    Route::post('/loker-drafts/{id}/publish', [LokerDraftController::class, 'publish'])->name('lokerdraft.publish');
    Route::delete('/loker-drafts/{id}', [LokerDraftController::class, 'destroy'])->name('lokerdraft.destroy');
    Route::post('/loker-drafts/bulk-delete', [LokerDraftController::class, 'bulkDestroy'])->name('lokerdraft.bulk-destroy');
    Route::get('/loker-drafts/template', [LokerDraftController::class, 'downloadTemplate'])->name('loker-draft.download-template');
    Route::post('/scraper-keys', [ScraperApiKeyController::class, 'store'])->name('scraper-keys.store');
    Route::patch('/scraper-keys/{apiKey}/toggle', [ScraperApiKeyController::class, 'toggleStatus'])->name('scraper-keys.toggle');
    Route::delete('/scraper-keys/{apiKey}', [ScraperApiKeyController::class, 'destroy'])->name('scraper-keys.destroy');
    Route::post('/admin/pembayaran/approved', [AdminPaymentController::class, 'approved'])->middleware('admin.panel');
    Route::post('/admin/pembayaran/certificate', [AdminPaymentController::class, 'publish_certificate'])->middleware('admin.panel');
    Route::post('/admin/pembayaran/setsudahcetak', [AdminPaymentController::class, 'setsudahcetak'])->middleware('admin.panel');
    Route::post('/admin/pembayaran/updatebukti', [AdminPaymentController::class, 'update_bukti'])->middleware('admin.panel');
    Route::get('/articles/generate', [ArticleGeneratorController::class, 'index'])->name('articles.index');
    Route::post('/articles/generate', [ArticleGeneratorController::class, 'generate'])->name('articles.generate');
    Route::put('/articles/publish/{article}', [ArticleGeneratorController::class, 'publish'])->name('articles.publish');
    Route::get('/articles/{slug}', [ArticleGeneratorController::class, 'publicShow'])->name('articles.publicShow');
    // Route::get('/articles/{slug}', [ArticleGeneratorController::class, 'show'])->name('articles.show');
    Route::get('/articles/{article}/edit', [ArticleGeneratorController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleGeneratorController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleGeneratorController::class, 'destroy'])->name('articles.destroy');
    Route::get('/articles/{article}/export-html', [ArticleGeneratorController::class, 'exportHtml'])->name('articles.exportHtml');
    Route::get('/articles/{article}/export-pdf', [ArticleGeneratorController::class, 'exportPdf'])->name('articles.exportPdf');

    // Export semua artikel ke CSV/Excel
    Route::get('/articles-export/csv', [ArticleGeneratorController::class, 'exportCsv'])->name('articles.exportCsv');


    Route::get('/admin/order-kelas-manual', [ManualClassOrderController::class, 'index'])
        ->middleware('admin.panel')
        ->name('admin.manual-class-orders.index');
    Route::post('/admin/order-kelas-manual', [ManualClassOrderController::class, 'store'])
        ->middleware('admin.panel')
        ->name('admin.manual-class-orders.store');
    Route::get('/admin/order-kelas-manual/{id}/edit', [ManualClassOrderController::class, 'edit'])
        ->middleware('admin.panel')
        ->name('admin.manual-class-orders.edit');
    Route::put('/admin/order-kelas-manual/{id}', [ManualClassOrderController::class, 'update'])
        ->middleware('admin.panel')
        ->name('admin.manual-class-orders.update');
    Route::delete('/admin/order-kelas-manual/{id}', [ManualClassOrderController::class, 'destroy'])
        ->middleware('admin.panel')
        ->name('admin.manual-class-orders.destroy');


    Route::get('/admin/loker', [AdminLokerController::class, 'index_admin'])
        ->middleware('admin.panel')
        ->name('admin.loker.index');
    Route::get('/admin/loker/{id}', [AdminLokerController::class, 'show'])
        ->middleware('admin.panel')
        ->name('admin.loker.show');
    Route::post('/admin/loker', [AdminLokerController::class, 'store'])
        ->middleware('admin.panel')
        ->name('admin.loker.store');
    Route::delete('/admin/loker/{id}', [AdminLokerController::class, 'destroy'])
        ->middleware('admin.panel')
        ->name('admin.loker.destroy');
    Route::get('/admin/loker/getkabupaten/{id}', [AdminLokerController::class, 'getkabupaten'])
        ->middleware('admin.panel');
    Route::get('/admin/loker/getkecamatan/{id}', [AdminLokerController::class, 'getkecamatan'])
        ->middleware('admin.panel');
    Route::get('/admin/loker/getkelurahan/{id}', [AdminLokerController::class, 'getkelurahan'])
        ->middleware('admin.panel');
    Route::get('/admin/perusahaan', [CompanyController::class, 'index'])
        ->middleware('admin.panel')
        ->name('perusahaan.index');
    Route::post('/admin/perusahaan', [CompanyController::class, 'store'])
        ->middleware('admin.panel')
        ->name('perusahaan.store');
    Route::delete('/admin/perusahaan/{id}', [CompanyController::class, 'destroy'])
        ->middleware('admin.panel')
        ->name('perusahaan.destroy');
    Route::get('/admin/apply', [LokerApplicationController::class, 'index'])
        ->middleware('admin.panel')
        ->name('apply.index');
    Route::get('/admin/getdatacvpelamar', [LokerApplicationController::class, 'getdatacvpelamar'])
        ->middleware('admin.panel')
        ->name('admin.applications.cv');
    Route::post('/admin/approvecvpelamar', [LokerApplicationController::class, 'approvecvpelamar'])
        ->middleware('admin.panel')
        ->name('admin.applications.approve');

    Route::middleware(['admin.panel'])->group(function () {
        Route::get('/admin/sop/dokumen/{id}/download', [SopController::class, 'downloadDocument'])
            ->name('admin.sop.documents.download');
        Route::delete('/admin/sop/dokumen/{id}', [SopController::class, 'destroyDocument'])
            ->name('admin.sop.documents.destroy');
        Route::resource('/admin/sop', SopController::class)
            ->except(['show'])
            ->names('admin.sop');
    });
});
