<?php

namespace App\Livewire;

use App\Models\City;
use App\Services\CustomerService;
use Livewire\Component;

class CitySearch extends Component
{
    public $groupedCities;
    public $search = '';

    public function render()
    {
        $cities = City::where('name', 'LIKE', '%' . $this->search . '%')->orderBy('name')->get();
        $this->groupedCities = City::groupByCapitalLetter($cities);
        return view('livewire.city-search');
    }

    public function chooseCity($cityId)
    {
        $city = City::findOrFail($cityId);
        CustomerService::addCity($city->name);
        $this->dispatch('cityUpdated');
    }
}
