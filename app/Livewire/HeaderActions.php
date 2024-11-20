<?php

namespace App\Livewire;

use App\Service\ComparisonService;
use App\Service\FavoritesService;
use App\Services\CartService;
use Livewire\Component;

class HeaderActions extends Component
{
    public $listeners = [
        'cartUpdated' => 'render',
        'comparisonUpdated' => 'render',
        'favoritesUpdated' => 'render',
    ];

    public $cartQuantity;
    public $comparisonQuantity;
    public $favoritesQuantity;

    public function render()
    {
        $this->cartQuantity = CartService::getTotalQuantity();
        $this->comparisonQuantity = ComparisonService::getTotalQuantity();
        $this->favoritesQuantity = FavoritesService::getTotalQuantity();

        return view('livewire.header-actions');
    }
}
