<?php

namespace App\Providers;

use App\Models\Product;
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
            $recentlyViewedProducts = session('products', []);

            if ($recentlyViewedProducts)
                $recentlyViewedProducts = Product::whereIn('id', $recentlyViewedProducts)
                    ->orderByRaw('FIELD(id, ' . implode(',', $recentlyViewedProducts) . ') DESC')
                    ->get();

            $view->with('recentlyViewedProducts', $recentlyViewedProducts);
        });
    }
}
