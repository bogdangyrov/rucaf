<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use App\Services\CartService;

class CartComponent extends Component
{
    public $products;
    public $totalSum;
    public $totalQuantity;

    protected $listeners = ['refreshCounter' => 'refreshCart'];

    public function mount()
    {
        $this->refreshCart();
    }

    public function increment($productId)
    {
        $quantity = CartService::getQuantity($productId);
        if ($quantity >= 100) {
            return;
        }
        CartService::update($productId, $quantity + 1);
        $this->refreshCart();
    }

    public function decrement($productId)
    {
        $product = $this->products->firstWhere('id', $productId);
        $quantity = CartService::getQuantity($productId);
        if ($quantity <= 1) {
            CartService::delete($productId, $product->quantity);
        } else {
            CartService::update($productId, $quantity - 1);
        }
        $this->refreshCart();
    }

    public function delete($productId)
    {
        CartService::delete($productId, 0);
        $this->refreshCart();
    }

    public function refreshCart()
    {
        $this->products = CartService::get();
        $this->totalSum = $this->products
            ->sum(fn($product) => ($product->discount_price ?? $product->price) * $product->quantity);
        $this->totalQuantity = CartService::getTotalQuantity();
        $this->dispatch('quantity-updated');
    }

    public function render()
    {
        return view('livewire.cart.cart-component');
    }
}
