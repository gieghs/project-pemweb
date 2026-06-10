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
                $cartItems = \App\Models\CartItem::with('product')->where('user_id', auth()->id())->get()
                    ->filter(function ($item) {
                        if (!$item->product || $item->product->status === 'sold') {
                            $item->delete(); // Auto clean up
                            return false;
                        }
                        return true;
                    });
                $view->with('globalCart', $cartItems);
            } else {
                $view->with('globalCart', collect([]));
            }
        });
    }
}