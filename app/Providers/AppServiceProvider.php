<?php

namespace App\Providers;

use DB;
use Illuminate\Support\Facades\Log;
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
        if (config('app.debug'))
        {
            Log::info(request()->fullUrl());

            DB::listen(function ($query) {
                Log::debug($query->time . 's to execute ' . $query->sql);
            });
        }
    }
}
