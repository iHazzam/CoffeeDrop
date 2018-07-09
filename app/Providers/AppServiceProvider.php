<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\LoggingObserver;
use App\User;
use App\Location;
use App\Opening;
use App\Price;
use App\Product;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
