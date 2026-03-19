<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;
use App\Services\ComparisonService;
use App\Services\FavoritesService;

class ProductActions extends Component
{
    public $product;
    public $quantity;
    public $inComparison;
    public $inFavorites;
    public $subcategory;

    public function render()
    {
        $quantity = CartService::getQuantity($this->product->id);
        if ($quantity) {
            $this->quantity = $quantity;
        }
        $this->subcategory = $this->product->subcategory;

        $this->inComparison = ComparisonService::inComparison($this->product->id);
        $this->inFavorites = FavoritesService::inFavorites($this->product->id);

        return view('livewire.product-actions');
    }

    public function addToCart()
    {
        if (is_null($this->quantity) || !is_numeric($this->quantity) || $this->quantity < 1 || $this->quantity > 100) {
            $this->quantity = 1;
        }
        CartService::add($this->product->id, $this->quantity);
        $this->dispatch('cartUpdated');
    }

    public function addToComparison()
    {
        ComparisonService::add($this->product->id);
        $this->dispatch('comparisonUpdated');
    }

    public function addToFavorites()
    {
        FavoritesService::add($this->product->id);
        $this->dispatch('favoritesUpdated');
    }
}
