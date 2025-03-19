<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\ComparisonService;

class ComparisonComponent extends Component
{
    public $subcategories;

    public function render()
    {
        return view('livewire.comparison-component');
    }

    public function mount()
    {
        $this->subcategories = ComparisonService::getSubcategories();
        $this->dispatch('comparisonUpdated');
    }

    public function delete($productId)
    {
        ComparisonService::delete($productId);
        $this->mount();
    }
}
