<?php

namespace App\Livewire;

use Livewire\Component;
use App\Service\ComparisonService;

class ComparisonComponent extends Component
{
    public $productTypes;

    public function render()
    {
        return view('livewire.comparison-component');
    }

    public function mount()
    {
        $this->productTypes = ComparisonService::getProductTypes();
        $this->dispatch('comparisonUpdated');
    }

    public function delete($productId)
    {
        ComparisonService::delete($productId);
        $this->mount();
    }
}
