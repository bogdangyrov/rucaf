<?php

namespace App\Providers;

use App\Models\Product;
use App\Services\RecentlyViewedService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class RecentlyViewedProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('products.components.recently-watched', function ($view) {
            $recentlyViewedProducts = RecentlyViewedService::getProducts();
            $view->with('recentlyViewedProducts', $recentlyViewedProducts);
        });
    }
}
