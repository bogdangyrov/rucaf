<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use App\Services\CartService;

class AddButtonFromCatalog extends Component
{
    public $product;
    public $quantity;

    public $listeners = ['quantity-updated' => 'render'];

    public function render()
    {
        $quantity = CartService::getQuantity($this->product->id);
        if ($quantity) {
            $this->quantity = $quantity;
        }
        return view('livewire.cart.add-button-from-catalog');
    }

    public function addToCart()
    {
        CartService::add($this->product->id, 1);
        $this->dispatch('quantity-updated');
    }
}
