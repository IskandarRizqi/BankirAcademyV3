<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        RateLimiter::for('apply-loker', function (Request $request) {
            return Limit::perMinute(1)
                ->by($request->user()?->id . '-' . $request->route('id'))
                ->response(function () {
                    return redirect()->back()->with('error', 'Mohon tunggu sejenak sebelum mencoba lagi.');
                });
        });
    }
}
