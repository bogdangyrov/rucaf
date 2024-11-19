<?php

namespace App\Providers;

use App\Models\City;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CitiesProvider extends ServiceProvider
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
            $cities = City::orderBy('name')->get();
            $citiesGrouped = [];
            foreach ($cities as $city) {
                $capitalLetter = mb_substr($city['name'], 0, 1, 'UTF-8');
                $citiesGrouped[$capitalLetter][] = $city;
            }

            $view->with('citiesGrouped', $citiesGrouped);
        });
    }
}
