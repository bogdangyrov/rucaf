<?php

namespace App\Livewire\Cart;

use App\Livewire\CartCounter;
use App\Services\CartService;
use Livewire\Component;

class AddButton extends Component
{
    public $product;
    public $quantity;

    public function render()
    {
        $quantity = CartService::getQuantity($this->product->id);
        if ($quantity) {
            $this->quantity = $quantity;
        }
        return view('livewire.cart.add-button');
    }

    public function addToCart()
    {
        if (is_null($this->quantity) || !is_numeric($this->quantity) || $this->quantity < 1 || $this->quantity > 100) {
            $this->quantity = 1;
        }
        CartService::add($this->product->id, $this->quantity);
        $this->dispatch('quantity-updated');
    }
}
