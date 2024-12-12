<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class Search extends Component
{
    public $search = '';
    public $products;

    public function render()
    {
        $search = $this->search;

        if ($this->search) {
            $this->products = Product::active()
                ->fuzzySearch($search)
                ->with('productType')
                ->limit(10)
                ->get();
        } else {
            $this->products = null;
        }

        return view('livewire.search');
    }
}
