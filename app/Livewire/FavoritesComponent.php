<?php

namespace App\Livewire;

use App\Service\FavoritesService;
use Livewire\Component;

class FavoritesComponent extends Component
{
    public $products;

    public function render()
    {
        return view('livewire.favorites-component');
    }

    public function mount()
    {
        $this->products = FavoritesService::getProducts();
    }
}
