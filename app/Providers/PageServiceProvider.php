<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider; 

class PageServiceProvider extends ServiceProvider
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
        $this->app->bind('page', function () {
            return new \App\Utils\Page;
        });
    }
}
