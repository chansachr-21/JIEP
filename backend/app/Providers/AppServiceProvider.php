<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Pastikan JSON response di semua API
        \Illuminate\Support\Facades\Response::macro('apiSuccess', function ($data, $message = 'Berhasil', $code = 200) {
            return response()->json(['success' => true, 'message' => $message, 'data' => $data], $code);
        });
    }
}
