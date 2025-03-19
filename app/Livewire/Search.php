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
        $search = trim($this->search);

        if ($this->search) {
            $this->products = Product::active()
                ->fuzzySearch($search)
                ->with('category.productType', 'subcategory')
                ->limit(10)
                ->get();
        } else {
            $this->products = null;
        }

        return view('livewire.search');
    }
}
