<?php

namespace App\Livewire;

use App\Models\City;
use App\Services\CustomerService;
use Livewire\Component;

class CityName extends Component
{
    public $city;


    public $listeners = [
        'cityUpdated' => 'render'
    ];

    public function render()
    {
        $this->city = CustomerService::getCity();
        return view('livewire.city-name');
    }
}
