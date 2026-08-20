<?php

use App\Http\Controllers\Backend\MembershipController;
use App\Http\Controllers\Front\InvoiceController;
use App\Http\Controllers\Front\ProfileController;
use App\Http\Controllers\MemberNonAnggota\BillingController;
use App\Http\Controllers\MemberNonAnggota\BonusAplikasiController;
use App\Http\Controllers\MemberNonAnggota\CompanyLocationController;
use App\Http\Controllers\MemberNonAnggota\CompanyProfileController;
use App\Http\Controllers\MemberNonAnggota\CvAtsController;
use App\Http\Controllers\MemberNonAnggota\DataEventKelasController;
use App\Http\Controllers\MemberNonAnggota\DetailKelasController;
use App\Http\Controllers\MemberNonAnggota\EbookController;
use App\Http\Controllers\MemberNonAnggota\ListDaftarKelasController;
use App\Http\Controllers\MemberNonAnggota\LokerController;
use App\Http\Controllers\MemberNonAnggota\LokerPostingController;
use App\Http\Controllers\MemberNonAnggota\SertifikatController;
use App\Http\Controllers\MemberNonAnggota\SopController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Member Non Anggota Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Member Non Anggota web routes for your application.
|
*/

Route::middleware('auth')->group(function () {
    Route::resource('dash-beranda', ProfileController::class);
    Route::get('/event-kelas', [DataEventKelasController::class, 'dataeventkelas']);
    Route::get('/ebook', [EbookController::class, 'indexPdf'])->name('ebook.index');
    Route::get('/video', [EbookController::class, 'indexVideo'])->name('video.index');
    Route::get('/ebook/detail/{sub_materi_id}', [EbookController::class, 'detailPdf'])->name('ebook.detail');
    Route::post('/ebook/claim-free/{sub_materi_id}', [EbookController::class, 'claimFreePdf'])->name('ebook.claim');
    Route::get('/ebook/belajar/{sub_materi_id}', [EbookController::class, 'belajarPdf'])->name('ebook.belajar');
    Route::get('/video/detail/{sub_materi_id}', [EbookController::class, 'detailVideo'])->name('video.detail');
    Route::post('/video/claim-free/{sub_materi_id}', [EbookController::class, 'claimFreeVideo'])->name('video.claim');
    Route::get('/video/belajar/{sub_materi_id}', [EbookController::class, 'belajarVideo'])->name('video.belajar');
    Route::post('/payment/order-ebook', [PaymentController::class, 'paymentorderebook'])->name('payment.order.ebook');
    Route::post('/payment/order-video', [PaymentController::class, 'paymentordervideo'])->name('payment.order.video');
    Route::post('/payment/order-video-manual', [PaymentController::class, 'paymentOrderVideoManual'])->name('payment.order.video.manual');
    Route::post('/payment/order-ebook-manual', [PaymentController::class, 'paymentOrderEbookManual'])->name('payment.order.ebook.manual');
    Route::post('/detail-event/{unique_id}/order-iht', [DataEventKelasController::class, 'orderIht'])->name('membernonanggota.event.order-iht');
    Route::post('/pembayaran/{id}/upload-bukti', [BillingController::class, 'uploadBuktiTransfer'])
        ->name('pembayaran.upload-bukti');
    Route::get('/detail-event/{unique_id}/{title}', [DataEventKelasController::class, 'detailevent']);
    Route::get('/pembayaran', [BillingController::class, 'databilling']);
    Route::post('/pembayaran/{payment}/expire', [BillingController::class, 'expirePayment']);
    Route::post('/membership/cancel', [BillingController::class, 'cancelMembership'])
        ->name('membernonanggota.membership.cancel');
    Route::post('/membership/continue-payment', [BillingController::class, 'continueMembershipPayment'])
        ->name('membernonanggota.membership.continue-payment');
    Route::post('/pembayaran/iht/{payment}', [PaymentController::class, 'paymentIht'])->name('membernonanggota.payment-iht');
    Route::get('/classes/cetakinvoicepending/{id}', [MembershipController::class, 'cetakinvoicepending']);
    Route::get('/materi/cetakinvoicepending/{id}', [InvoiceController::class, 'invoicemateri'])
        ->middleware('auth')
        ->name('invoice.pending');
    Route::get('/classes/getinvoice/{id}', [InvoiceController::class, 'getInvoice']);
    Route::get('/kelas-event', [ListDaftarKelasController::class, 'kelasanda']);
    Route::get('/sertifikat-kelas', [SertifikatController::class, 'index'])
        ->name('membernonanggota.certificates.index');
    Route::prefix('member/cv-ats')
        ->name('membernonanggota.cv-ats.')
        ->middleware('membership.type:individual')
        ->controller(CvAtsController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/buat', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/edit', 'edit')->name('edit');
            Route::put('/', 'update')->name('update');
            Route::get('/cetak', 'pdf')->name('pdf');
        });
    Route::middleware('role:2')->group(function () {
        Route::get('/member/loker', [LokerController::class, 'index'])
            ->name('membernonanggota.loker.index');
        Route::get('/member/loker/cities', [LokerController::class, 'cities'])
            ->name('membernonanggota.loker.cities');
        Route::get('/member/loker/riwayat', [LokerController::class, 'history'])
            ->middleware('membership.type:individual')
            ->name('membernonanggota.loker.history');
        Route::get('/member/loker/{id}', [LokerController::class, 'show'])
            ->whereNumber('id')
            ->name('membernonanggota.loker.show');
        Route::get('/member/loker/{id}/apply', [LokerController::class, 'applyPreview'])
            ->whereNumber('id')
            ->middleware('membership.type:individual')
            ->name('membernonanggota.loker.apply');
        Route::post('/member/loker/{id}/apply', [LokerController::class, 'submitApplication'])
            ->whereNumber('id')
            ->middleware(['membership.type:individual', 'throttle:apply-loker'])
            ->name('membernonanggota.loker.apply.store');
    });
    Route::middleware(['role:2', 'membership.type:company'])
        ->prefix('member/pasang-loker')
        ->name('membernonanggota.loker.manage.')
        ->group(function () {
            Route::get('/perusahaan', [CompanyProfileController::class, 'edit'])
                ->name('company.edit');
            Route::put('/perusahaan', [CompanyProfileController::class, 'update'])
                ->name('company.update');
            Route::get('/locations/cities', [CompanyLocationController::class, 'cities'])
                ->name('locations.cities');
            Route::get('/locations/districts', [CompanyLocationController::class, 'districts'])
                ->name('locations.districts');
            Route::get('/locations/villages', [CompanyLocationController::class, 'villages'])
                ->name('locations.villages');
            Route::get('/posting', [LokerPostingController::class, 'index'])
                ->name('index');
            Route::get('/posting/create', [LokerPostingController::class, 'create'])
                ->name('create');
            Route::post('/posting', [LokerPostingController::class, 'store'])
                ->name('store');
            Route::get('/posting/{id}/edit', [LokerPostingController::class, 'edit'])
                ->whereNumber('id')
                ->name('edit');
            Route::put('/posting/{id}', [LokerPostingController::class, 'update'])
                ->whereNumber('id')
                ->name('update');
            Route::delete('/posting/{id}', [LokerPostingController::class, 'destroy'])
                ->whereNumber('id')
                ->name('destroy');
        });
    Route::middleware(['role:2', 'membership.type:company'])
        ->prefix('member/sop')
        ->name('membernonanggota.sop.')
        ->controller(SopController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{id}', 'show')->whereNumber('id')->name('show');
            Route::get('/documents/{id}/download', 'downloadDocument')
                ->whereNumber('id')
                ->name('documents.download');
        });
    Route::middleware(['role:2', 'membership.type:company'])
        ->prefix('member/bonus-aplikasi')
        ->name('membernonanggota.bonus-aplikasi.')
        ->controller(BonusAplikasiController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{id}/access', 'access')
                ->whereNumber('id')
                ->name('access');
        });
    Route::get('/sertifikat-kelas/{classId}/cetak', [SertifikatController::class, 'show'])
        ->name('membernonanggota.certificates.show');
    Route::get('/sertifikat-kelas/{classId}/download', [SertifikatController::class, 'downloadZip'])
        ->name('membernonanggota.certificates.download');
    Route::get('/detail-kelas/content/{contentId}', [DetailKelasController::class, 'showContent'])
        ->name('membernonanggota.class.content');
    Route::get('/detail-kelas/{uniqueId}/{title}', [DetailKelasController::class, 'show'])
        ->name('membernonanggota.class.detail');
    Route::post('/kelas-event/{classId}/participants', [ListDaftarKelasController::class, 'storeParticipants'])
        ->name('membernonanggota.class-participants.store');
    Route::get('/kelas-event/participants/template', [ListDaftarKelasController::class, 'downloadParticipantTemplate'])
        ->name('membernonanggota.class-participants.template');
    Route::post('/kelas-event/{classId}/participants/import', [ListDaftarKelasController::class, 'importParticipants'])
        ->name('membernonanggota.class-participants.import');
    Route::delete('/kelas-event/{classId}/participants', [ListDaftarKelasController::class, 'destroyParticipants'])
        ->name('membernonanggota.class-participants.destroy');
});
