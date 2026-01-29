<?php

use App\Http\Controllers\API\KelasController;
use App\Http\Controllers\API\LokerController;
use App\Http\Controllers\Backend\PembayaranController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Middleware\AksesByIpAddress;
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
    // API Loker
    Route::get('/loker', [LokerController::class, 'index']);

    // API Kelas
    Route::get('/kelas', [KelasController::class, 'index']);
});


Route::get('/apiberanda', [HomeController::class, 'apiberanda']);
Route::get('/tripay/create', [PembayaranController::class, 'tripaycreate']);
Route::get('/tripay/ppob', [PembayaranController::class, 'tripayppob']);
Route::post('/doku/notification', [CheckoutController::class, 'handleNotification']);
