<?php

use App\Http\Controllers\ActivationController;
use App\Http\Controllers\ActivationDispatchController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider'])
    ->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])
    ->name('social.callback');
Route::get('/instructor/{provider}', [HomeController::class, 'redirectToProvider']);
Route::get('/instructor/{provider}/callback', [HomeController::class, 'handleProviderCallback']);

Auth::routes();

// Disabled: HomeController::tesapi does not exist and this route has no caller.
// Route::get('tesapi', [HomeController::class, 'tesapi']);
Route::get('authentikasi/login', [HomeController::class, 'getlayoutauth'])->name('login.new');

Route::get(
    '/admin/users/{user}/send-activation-email',
    [ActivationDispatchController::class, 'sendFromLink']
)
    ->middleware([
        'auth',
        'signed',
        'throttle:5,1',
    ])
    ->name('activation.email.send-link');

Route::middleware(['auth'])->group(function () {
    Route::post(
        '/admin/user-activations',
        [ActivationDispatchController::class, 'store']
    )->name('activation.dispatch');
});

Route::get(
    '/aktivasi/{activation}',
    [ActivationController::class, 'show']
)->name('activation.show');

// Endpoint integrasi legacy, dipertahankan sampai caller eksternal diaudit.
Route::post('/sendfonnte', [ActivationDispatchController::class, 'send']);

Route::post(
    '/aktivasi/{activation}',
    [ActivationController::class, 'consume']
)->middleware([
    'signed',
    'throttle:5,1',
])->name('activation.consume');
