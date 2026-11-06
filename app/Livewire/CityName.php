<?php

namespace App\Livewire;

use App\Services\CustomerService;
use Livewire\Component;

class CityName extends Component
{
    public $city;

    protected $listeners = [
        'cityUpdated' => '$refresh'
    ];

    public function render()
    {
        $this->city = CustomerService::getCityWithDetection();
        return view('livewire.city-name');
    }
}
