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
        if ($this->search) {
            $this->products = Product::where('name', 'LIKE', "%{$this->search}%")
                ->with('productType')
                ->limit(5)
                ->get();
        } else {
            $this->products = null;
        }
        return view('livewire.search');
    }
}
