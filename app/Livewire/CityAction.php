<?php

namespace App\Livewire;

use App\Models\City;
use App\Service\CustomerService;
use Livewire\Component;

class CityAction extends Component
{
    public $city;


    public $listeners = [
        'cityUpdated' => 'render'
    ];

    public function render()
    {
        $this->city = CustomerService::getCity();

        return view('livewire.city-action');
    }
}
