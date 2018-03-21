<?php

namespace App\Providers;

use App\Repositories\Contracts\LocationRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\LocationRepositoryImpl;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(LocationRepository::class,LocationRepositoryImpl::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
