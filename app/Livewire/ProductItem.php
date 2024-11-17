<?php

namespace App\Livewire;

use App\Service\ComparisonService;
use App\Service\FavoritesService;
use Livewire\Component;
use App\Services\CartService;
use League\Csv\Query\Constraint\Comparison;

class ProductItem extends Component
{
    public $product;
    public $quantity;
    public $inComparison;
    public $inFavorites;

    public $listeners = ['cartUpdated' => 'render'];

    public function render()
    {
        $quantity = CartService::getQuantity($this->product->id);
        if ($quantity) {
            $this->quantity = $quantity;
        }

        $this->inComparison = ComparisonService::inComparison($this->product->id);
        $this->inFavorites = FavoritesService::inFavorites($this->product->id);
        return view('livewire.product-item');
    }

    public function addToCart()
    {
        CartService::add($this->product->id, 1);
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
