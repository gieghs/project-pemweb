<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $view->with('globalCart', \App\Models\CartItem::with('product')->where('user_id', auth()->id())->get());
            } else {
                $view->with('globalCart', collect([]));
            }
        });
    }
}