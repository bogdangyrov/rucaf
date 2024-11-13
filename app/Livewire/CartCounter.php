<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;

class CartCounter extends Component
{
    public $quantity;
    public $product;

    public function render()
    {
        return view('livewire.cart-counter');
    }

    public function increment()
    {
        $this->quantity++;
        CartService::add($this->product->id, $this->quantity);
    }

    public function decrement()
    {
        $this->quantity--;
        if ($this->quantity <= 0) {
            CartService::delete($this->product->id);
        } else {
            CartService::add($this->product->id, $this->quantity);
        }
    }
}
