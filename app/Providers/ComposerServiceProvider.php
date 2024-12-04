<?php

namespace App\Providers;

use App\Http\MainViewLinks;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['home', 'header'], function ($view) {
            $view->with('main_links', MainViewLinks::getLinks());
            // $view->with('main_links', ["hey" => "hello there"]);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
