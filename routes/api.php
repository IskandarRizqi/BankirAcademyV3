<?php

use App\Http\Controllers\API\KelasController;
use App\Http\Controllers\API\LokerController;
use App\Http\Controllers\API\ScraperIngestionController;
use App\Http\Controllers\ArticleGeneratorController;
use App\Http\Controllers\Backend\PembayaranController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\RecentRegistrationController;
use App\Http\Middleware\AksesByIpAddress;
use App\Http\Middleware\VerifyScraperApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([AksesByIpAddress::class])->group(function () {
    Route::get('/loker', [LokerController::class, 'index']);
    Route::get('/kelas', [KelasController::class, 'index']);
});


Route::get('/apiberanda', [HomeController::class, 'apiberanda']);
Route::get('/tripay/create', [PembayaranController::class, 'tripaycreate']);
Route::middleware([VerifyScraperApiKey::class, 'throttle:60,1'])->group(function () {
    Route::post('/v1/scraper/loker-draft', [ScraperIngestionController::class, 'store']);
});
Route::post('/articles/store-n8n', [ArticleGeneratorController::class, 'storeFromN8n']);
Route::get('/tripay/ppob', [PembayaranController::class, 'tripayppob']);
Route::post('/c4/notifikasi', [CheckoutController::class, 'handleDokuTransactionNotification']);
Route::post('/doku/notification', [CheckoutController::class, 'handleNotification']);
Route::post('/doku/membership/notification', [CheckoutController::class, 'handleNotificationmembership']);
Route::get('/api/recent-registrations/random', [RecentRegistrationController::class, 'getRandomCustomer'])
    ->name('api.recent-registrations.random');
