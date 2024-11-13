<?php

namespace App\Livewire\Cart;

use App\Services\CartService;
use Livewire\Component;

class Header extends Component
{
    public $listeners = [
        'quantity-updated' => 'render',
    ];

    public function render()
    {
        $totalQuantity = CartService::getTotalQuantity();
        return view('livewire.cart.header')
            ->with('totalQuantity', $totalQuantity);
    }
}
