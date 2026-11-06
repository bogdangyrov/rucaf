<?php

namespace App\Livewire;

use App\Services\CustomerService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class ConfirmCity extends Component
{
    public ?string $city = null;
    public ?string $detectedCity = null;

    protected $listeners = [
        'cityUpdated' => 'mount'
    ];

    public function mount(): void
    {
        $this->city = CustomerService::getCity();

        if ($this->city) {
            return;
        }

        $this->detectedCity = CustomerService::getCityWithDetection();
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div></div>
        HTML;
    }

    public function confirm(): void
    {
        if (!$this->detectedCity) {
            return;
        }

        CustomerService::addCity($this->detectedCity);
        $this->city = $this->detectedCity;
        $this->dispatch('cityUpdated');
    }

    public function render()
    {
        return view('livewire.confirm-city');
    }
}
