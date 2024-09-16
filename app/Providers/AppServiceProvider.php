<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\MenuController;

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
        view()->composer('layouts.main', function($view) {
            $view->with('menus_pedido', MenuController::menusPedidos());
        });

        view()->composer('layouts.app', function($view) {
            $view->with('menus_pedido', MenuController::menusPedidos());
        });        
    }
}
