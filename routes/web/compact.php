<?php

use App\Http\Controllers\Admin\ClassesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Backend\PrepotestController;
use App\Http\Controllers\Backend\WithdrawController;
use App\Http\Controllers\Beasiswa\CertificateController;
use App\Http\Controllers\Beasiswa\KategoriController;
use App\Http\Controllers\Beasiswa\MateriController;
use App\Http\Controllers\Beasiswa\SiswaMateriController;
use App\Http\Controllers\Beasiswa\SubMateriController;
use App\Http\Controllers\Front\InvoiceController;
use App\Http\Controllers\Front\LokerController;
use App\Http\Controllers\Front\ProfileController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PhotoAlbumController;
use App\Http\Controllers\PrePostTestController;
use App\Http\Controllers\SiswaVerificationController;
use Illuminate\Support\Facades\Route;

Route::post('/siswa/resend-verification', [SiswaVerificationController::class, 'resend'])
    ->name('siswa.resend.verification');

Route::middleware('auth')->group(function () {
    Route::get('/users/sendemail', [UserController::class, 'resendEmail']);
    Route::get('/admin/classes/previewcertificate/{id}', [ClassesController::class, 'previewcertificate'])
        ->middleware('admin.panel');
    Route::post('/classes/biaya_certificate', [ClassesController::class, 'biayacertificate']);
    Route::get('/classes/getcertificate/{id}', [ClassesController::class, 'getcertificate']);
    Route::post('/classes/multiinvoice', [InvoiceController::class, 'multiInvoice']);
    Route::get('/classes/certificate/{id}', [ClassesController::class, 'getCertificate']);
    Route::post('/classes/review', [ClassesController::class, 'sendreview']);

    Route::post('/addreviewinstructor', [ProfileController::class, 'addreviewinstructor']);
    Route::post('/changestatusreview', [ProfileController::class, 'changestatusreview']);

    Route::post('/updatemember', [ProfileController::class, 'updatemember']);
    Route::post('/updaterekening', [ProfileController::class, 'updaterekening']);
    Route::post('/withdrawMember', [WithdrawController::class, 'proses']);
    Route::get('/datalamaran', [ProfileController::class, 'datalamaran']);
    Route::get('/cetaklamaran', [ProfileController::class, 'cetaklamaran']);
    Route::post('simpanlamaran', [ProfileController::class, 'simpanlamaran']);
    Route::post('simpancv', [ProfileController::class, 'simpancv']);

    Route::post('/updateprofile', [ProfileController::class, 'updateprofile']);
    Route::post('/settingprofile', [ProfileController::class, 'settingprofile']);
    Route::post('/rekeningprofile', [ProfileController::class, 'rekeningprofile']);
    Route::get('/getbillingkelas/{type}', [ProfileController::class, 'getbillingkelas']);
    Route::get('/getkelasanda/{type}', [ProfileController::class, 'getkelasanda']);
    Route::get('/cvats/pdf/{id?}', [LamaranController::class, 'downloadPdf'])->name('cvats.pdf');
    Route::resource('/loker-front', LokerController::class);
    Route::get('/siswa/verifikasi-email/{id}/{hash}', [SiswaVerificationController::class, 'verify'])
        ->name('siswa.verifikasi.email');

    Route::middleware(['is_root'])->group(function () {
        Route::resource('kategori-materi', KategoriController::class);
        Route::resource('materi', MateriController::class);
        Route::resource('sub-materi', SubMateriController::class);
        Route::resource('ppt', PrePostTestController::class);
        Route::resource('certificate-templates', CertificateController::class);
        Route::get('/album', [PhotoAlbumController::class, 'index'])->name('album.index');
        Route::post('/album', [PhotoAlbumController::class, 'store'])->name('album.store');
        Route::put('/album/{id}', [PhotoAlbumController::class, 'update'])->name('album.update');
        Route::post('/photos/upload-quick', [MateriController::class, 'uploadQuickPhoto']);
        Route::post('/photos/upload', [MateriController::class, 'uploadQuickPhotoEbook']);
        Route::get('/photos/list', [MateriController::class, 'getPhotosList']);
        // Route::delete('/album/batch-delete', [PhotoAlbumController::class, 'destroyBatch'])->name('album.destroyBatch');
        Route::post('/destroy-batch', [PhotoAlbumController::class, 'destroyBatch'])->name('album.destroy-batch');
        Route::post('/restore-batch', [PhotoAlbumController::class, 'restoreBatch'])->name('album.restore-batch');
        Route::post('/force-delete-batch', [PhotoAlbumController::class, 'forceDeleteBatch'])->name('album.force-delete-batch');
        Route::get('/activity', [ActivityLogController::class, 'index'])->name('activity.index');
        Route::resource('memberships', MembershipController::class)->except(['create', 'show', 'edit']);
    });

    Route::middleware(['role:4,5'])->group(function () {
        Route::get('users/download-template', [UserController::class, 'downloadTemplate'])->name('users.download_template');
        Route::post('users/import', [UserController::class, 'import'])->name('users.import');
        Route::get('users/beasiswa-approval', [UserController::class, 'beasiswaApprovalList'])->name('beasiswa.approval.list');
        Route::post('/users/send-bulk-wa', [UserController::class, 'sendBulkWhatsapp'])->name('users.send-bulk-wa');
        Route::post('users/beasiswa-approval/{id}/{action}', [UserController::class, 'beasiswaApprovalProcess'])->name('users.beasiswa.approval.process');
        Route::resource('users', UserController::class);
    });

    Route::middleware(['role:6', 'siswa.verified'])->group(function () {
        Route::get('/pelatihan', [SiswaMateriController::class, 'index'])->name('siswa.materi.index');
        Route::post('/pelatihan/simpan-test/{materi_id}/{quiz_id}', [SiswaMateriController::class, 'savejawaban'])->name('siswa.materi.simpan_test');
        Route::post('/pelatihan/simpan/{submateri_id}/{quiz_id}', [SiswaMateriController::class, 'savetest'])->name('siswa.umum.simpan_test');
        Route::get('/cvats', [LamaranController::class, 'index'])->name('cvats.index');
        Route::get('/lamaran/create', [LamaranController::class, 'create'])->name('lamaran.create');
        Route::post('/lamaran', [LamaranController::class, 'store'])->name('lamaran.store');
        Route::get('/lamaran/{id}/edit', [LamaranController::class, 'edit'])->name('lamaran.edit');
        Route::put('/lamaran/{id}', [LamaranController::class, 'update'])->name('lamaran.update');
        Route::delete('/lamaran/{id}', [LamaranController::class, 'destroy'])->name('lamaran.destroy');
        Route::post('/prepotes/savejawaban', [PrepotestController::class, 'savejawaban']);
    });

    Route::middleware(['role:4,5,6', 'siswa.verified'])->group(function () {
        Route::get('/siswa/materi/{materi_id}/report/{id}/{sub_materi_id?}', [SiswaMateriController::class, 'report'])->name('siswa.materi.report');
        Route::get('/siswa/materi/{materi_id}/report-latest', [SiswaMateriController::class, 'reportByClass'])->name('siswa.materi.report.latest');
        Route::get('/manajemen/report/user/{user_id}/materi/{materi_id}', [SiswaMateriController::class, 'reportOlehManajemen'])->name('manajemen.siswa.report');
        Route::get('/siswa/materi/{materi_id}/sertifikat/{id}/download', [SiswaMateriController::class, 'downloadSertifikat'])->name('siswa.materi.sertifikat.download');
        // Route::get('/materi-umum', [SiswaMateriController::class, 'kompetensiUmum'])->name('materi.umum');
        Route::get('/sertifikat', [SiswaMateriController::class, 'listSertifikat'])->name('sertifikat');
        Route::get('/manajemen/laporan-siswa', [SiswaMateriController::class, 'indexLaporanManajemen'])->name('manajemen.laporan.index');
        Route::get('/userprofile', [UserController::class, 'profile'])->name('profiless.index');
        Route::get('/materi-umum', [SiswaMateriController::class, 'umumIndex'])->name('siswa.umum.index');
        Route::get('/lowongan', [MembershipController::class, 'loker'])->name('lowongan');
        Route::get('/lowongan/{id}', [MembershipController::class, 'detil_loker'])->name('lowongan.show');
        Route::post('/materi-umum/ikuti/{sub_materi_id}', [SiswaMateriController::class, 'ikutiPelatihan'])->name('siswa.umum.ikuti');
        Route::get('/materi-umum/belajar/{sub_materi_id}', [SiswaMateriController::class, 'umumBelajar'])->name('siswa.umum.belajar');
        Route::get('download-certificate/materi/{id}', [CertificateController::class, 'downloadMateriCertificate'])->name('materi.sertifikat');
        Route::get('download-certificate/sub-materi/{id}', [CertificateController::class, 'downloadSubMateriCertificate'])->name('umum.sertifikat');
        Route::get('/materi-umum/history', [SiswaMateriController::class, 'historyPelatihan'])->name('siswa.umum.history');
        Route::post('/materi/proses-bayar-beasiswa/{id}', [SiswaMateriController::class, 'prosesBayarBeasiswa'])->name('siswa.materi.bayar_beasiswa');
        Route::post('/payment/order-material', [PaymentController::class, 'paymentordermaterial'])->name('payment.order.material');
        Route::post('/payment/order-ebook', [PaymentController::class, 'paymentorderebook'])->name('payment.order.ebook');
        Route::post('/pelatihan/{id}/ikuti', [SiswaMateriController::class, 'ikutiKelas'])->name('siswa.materi.ikuti');
        Route::get('/pelatihan/belajar/{materi_id}/{sub_materi_id?}', [SiswaMateriController::class, 'belajar'])->name('siswa.materi.belajar');
    });

    Route::post('/payment-membership', [PaymentController::class, 'paymentmembership']);
    Route::post('/payment-order-class', [PaymentController::class, 'paymentorderclass']);
});
