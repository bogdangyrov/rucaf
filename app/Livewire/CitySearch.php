<?php

namespace App\Livewire;

use App\Models\City;
use App\Services\CustomerService;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class CitySearch extends Component
{
    public array $groupedCities = [];
    public bool $isLoaded = false;

    public function loadCities()
    {
        $this->groupedCities = Cache::remember('all_cities_grouped', 86400, function () {
            $cities = City::orderBy('name')->get();
            return City::groupByCapitalLetter($cities);
        });

        $this->isLoaded = true;
    }

    public function chooseCity(int $cityId)
    {
        $cityName = City::where('id', $cityId)->value('name');

        if ($cityName) {
            CustomerService::addCity($cityName);
            $this->dispatch('cityUpdated');
        }
    }

    public function render()
    {
        return view('livewire.city-search');
    }
}