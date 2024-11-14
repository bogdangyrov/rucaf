<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;

class ProductItem extends Component
{
    public $product;
    public $quantity;

    public $listeners = ['cartUpdated' => 'render'];

    public function render()
    {
        $quantity = CartService::getQuantity($this->product->id);
        if ($quantity) {
            $this->quantity = $quantity;
        }
        return view('livewire.product-item');
    }

    public function addToCart()
    {
        CartService::add($this->product->id, 1);
        $this->dispatch('cartUpdated');
    }
}
