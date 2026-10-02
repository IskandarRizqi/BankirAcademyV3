<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\KelasController;
use App\Http\Controllers\API\LokerController;
use App\Http\Controllers\API\ManualPaymentController;
use App\Http\Controllers\API\PublicCatalogController;
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

Route::prefix('v1/auth')->name('api.v1.auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me'])->name('me');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});

Route::get('/getloker', [LokerController::class, 'get_data']);
Route::prefix('v1/public')->name('api.v1.public.')->group(function () {
    Route::get('/classes', [PublicCatalogController::class, 'classes'])->name('classes.index');
    Route::get('/ebooks', [PublicCatalogController::class, 'ebooks'])->name('ebooks.index');
    Route::get('/interactive-videos', [PublicCatalogController::class, 'interactiveVideos'])->name('interactive-videos.index');
});

Route::middleware('auth:sanctum')->prefix('v1/payments')->name('api.v1.payments.')->group(function () {
    Route::post('/class/manual', [ManualPaymentController::class, 'storeClass'])->name('class.manual');
    Route::post('/ebook/manual', [ManualPaymentController::class, 'storeEbook'])->name('ebook.manual');
    Route::post('/video/manual', [ManualPaymentController::class, 'storeVideo'])->name('video.manual');
    Route::get('/', [ManualPaymentController::class, 'index'])->name('index');
    Route::post('/{payment}/proof', [ManualPaymentController::class, 'uploadProof'])->name('proof');
    Route::get('/{payment}', [ManualPaymentController::class, 'show'])->name('show');
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
Route::post('/upload-article-image', [ArticleGeneratorController::class, 'upload']);
Route::get('/keywords/next', [ArticleGeneratorController::class, 'getNextKeyword']);
Route::post('/articles/store-n8n', [ArticleGeneratorController::class, 'storeFromN8n']);
Route::get('/articles', [ArticleGeneratorController::class, 'apiIndex']);
Route::get('/tripay/ppob', [PembayaranController::class, 'tripayppob']);
Route::post('/c4/notifikasi', [CheckoutController::class, 'handleDokuTransactionNotification']);
Route::post('/doku/notification', [CheckoutController::class, 'handleNotification']);
Route::post('/doku/membership/notification', [CheckoutController::class, 'handleNotificationmembership']);
Route::get('/api/recent-registrations/random', [RecentRegistrationController::class, 'getRandomCustomer'])
    ->name('api.recent-registrations.random');
