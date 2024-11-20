<?php

namespace App\Livewire;

use App\Service\CustomerService;
use Livewire\Component;

class ConfirmCity extends Component
{
    public $city;

    public function render()
    {
        $this->city = CustomerService::getCity();
        debugbar()->info(session('city', 'Не задано'));
        return view('livewire.confirm-city');
    }

    public function confirm()
    {
        CustomerService::addCity('Санкт-Петербург');
        $this->dispatch('cityUpdated');
    }
}
