<?php

namespace App\Providers;

use App\Models\ProductType;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class HeaderComposerProvider extends ServiceProvider
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
        View::composer('layouts.components.catalog-menu', function ($view) {
            $types = ProductType::with('categories')->get();
            $view->with('types', $types);
        });
    }
}
