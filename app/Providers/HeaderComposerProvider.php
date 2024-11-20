<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\PhoneNumber;
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
            $types = ProductType::with(['categories' => function ($query) {
                $query->orderBy('name');
            }])->orderBy('name')->get();
            $view->with('types', $types);
        });
        View::composer('layouts.components.header', function ($view) {
            $pages = Page::orderBy('title')->get();
            $types = ProductType::orderBy('name')->limit(5)->get();
            $phoneNumbers = PhoneNumber::get();
            $view->with(['pages' => $pages, 'productTypes' => $types, 'phoneNumbers' => $phoneNumbers]);
        });
    }
}
