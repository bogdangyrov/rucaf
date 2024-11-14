<?php

namespace App\Livewire;

use App\Service\ComparisonService;
use App\Services\CartService;
use Livewire\Component;

class Header extends Component
{
    public $listeners = [
        'cartUpdated' => 'render',
        'comparisonUpdated' => 'render',
    ];

    public $cartQuantity;
    public $comparisonQuantity;

    public function render()
    {
        $this->cartQuantity = CartService::getTotalQuantity();
        $this->comparisonQuantity = ComparisonService::getTotalQuantity();

        return view('livewire.header');
    }
}
