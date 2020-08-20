<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
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
        //compose all the views....
        view()->composer('*', function ($view)
        {
            $currentUser = Auth::user();
            //...with this variable
            $view->with('currentUser', $currentUser );
        });
    }
}
