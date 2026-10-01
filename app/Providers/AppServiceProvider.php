<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\City;
use App\Models\Email;
use App\Models\Page;
use App\Models\PhoneNumber;
use App\Models\ProductType;
use App\Models\Subcategory;
use App\Observers\GlobalCacheObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        Paginator::defaultView('vendor.pagination.custom');
        Model::unguard();

        PhoneNumber::observe(GlobalCacheObserver::class);
        Email::observe(GlobalCacheObserver::class);
        Page::observe(GlobalCacheObserver::class);
        City::observe(GlobalCacheObserver::class);
        ProductType::observe(GlobalCacheObserver::class);
        Category::observe(GlobalCacheObserver::class);
        Subcategory::observe(GlobalCacheObserver::class);
    }
}
