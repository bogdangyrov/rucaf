<?php

namespace App\Providers;

use App\Models\City;
use App\Models\Email;
use App\Models\Page;
use App\Models\PhoneNumber;
use App\Models\ProductType;
use App\Services\RecentlyViewedService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerProvider extends ServiceProvider
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
        View::composer('components.cities', function ($view) {
            $citiesGrouped = Cache::rememberForever('global_cities_grouped', function () {
                $cities = City::orderBy('name')->get();
                return City::groupByCapitalLetter($cities);
            });

            $view->with('citiesGrouped', $citiesGrouped);
        });

        View::composer('layouts.components.catalog-menu', function ($view) {
            $types = Cache::rememberForever('global_catalog_menu', function () {
                return ProductType::withWhereHas(
                    'categories',
                    function ($query) {
                        $query->orderBy('name')->with([
                            'subcategories' => function ($query) {
                                $query->orderBy('name');
                            }
                        ]);
                    }
                )->orderBy('name')->get();
            });

            $view->with('types', $types);
        });

        View::composer([
            'layouts.components.header',
            'layouts.components.footer',
            'products.components.why-choose-us',
            'products.components.show.product-info',
            'components.frequent-questions',
            'catalog',
            'components.catalog',
        ], function ($view) {
            static $sharedData;

            if (!$sharedData) {
                $sharedData = Cache::rememberForever('global_shared_data', function () {
                    return [
                        'pages'        => Page::orderBy('title')->get(),
                        'productTypes' => ProductType::withWhereHas('categories')->get(),
                        'phoneNumbers' => PhoneNumber::all(),
                        'emails'       => Email::all(),
                    ];
                });
            }

            $view->with($sharedData);
        });

        View::composer('products.components.recently-watched', function ($view) {
            $recentlyViewedProducts = RecentlyViewedService::getProducts();
            $view->with('recentlyViewedProducts', $recentlyViewedProducts);
        });
    }
}
