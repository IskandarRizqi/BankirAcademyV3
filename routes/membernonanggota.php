<?php

use App\Http\Controllers\Backend\MembershipController;
use App\Http\Controllers\Front\InvoiceController;
use App\Http\Controllers\Front\ProfileController;
use App\Http\Controllers\MemberNonAnggota\BillingController;
use App\Http\Controllers\MemberNonAnggota\DataEventKelasController;
use App\Http\Controllers\MemberNonAnggota\ListDaftarKelasController;
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
    Route::post('/detail-event/{unique_id}/order-iht', [DataEventKelasController::class, 'orderIht'])->name('membernonanggota.event.order-iht');
    Route::get('/detail-event/{unique_id}/{title}', [DataEventKelasController::class, 'detailevent']);
    Route::get('/pembayaran', [BillingController::class, 'databilling']);
    Route::post('/pembayaran/{payment}/expire', [BillingController::class, 'expirePayment']);
    Route::post('/membership/cancel', [BillingController::class, 'cancelMembership'])
        ->name('membernonanggota.membership.cancel');
    Route::post('/membership/continue-payment', [BillingController::class, 'continueMembershipPayment'])
        ->name('membernonanggota.membership.continue-payment');
    Route::post('/pembayaran/iht/{payment}', [PaymentController::class, 'paymentIht'])->name('membernonanggota.payment-iht');
    Route::get('/classes/cetakinvoicepending/{id}', [MembershipController::class, 'cetakinvoicepending']);
    Route::get('/classes/getinvoice/{id}', [InvoiceController::class, 'getInvoice']);
    Route::get('/kelas-event', [ListDaftarKelasController::class, 'kelasanda']);
    Route::post('/kelas-event/{classId}/participants', [ListDaftarKelasController::class, 'storeParticipants'])
        ->name('membernonanggota.class-participants.store');
    Route::get('/kelas-event/participants/template', [ListDaftarKelasController::class, 'downloadParticipantTemplate'])
        ->name('membernonanggota.class-participants.template');
    Route::post('/kelas-event/{classId}/participants/import', [ListDaftarKelasController::class, 'importParticipants'])
        ->name('membernonanggota.class-participants.import');
    Route::delete('/kelas-event/{classId}/participants', [ListDaftarKelasController::class, 'destroyParticipants'])
        ->name('membernonanggota.class-participants.destroy');
});
