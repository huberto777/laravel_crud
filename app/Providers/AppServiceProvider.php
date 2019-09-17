<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use View;
use App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Interfaces\BaseRepositoryInterface', 'App\Repositories\BaseRepository');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        View::composer('*', function ($view) {
            $view->with('placeholder', asset('images/placeholder.jpg'));
        });

        if (App::environment('local')) {
            View::composer('*', function ($view) {
                $view->with('novalidate', 'novalidate');
            });
        } else {
            View::composer('*', function ($view) {
                $view->with('novalidate', null);
            });
        }
    }
}
