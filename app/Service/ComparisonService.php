<?php

namespace App\Service;

use App\Models\ProductType;

class ComparisonService
{
    public static function add($productId)
    {
        if (in_array($productId, session('comparison', []))) {
            return false;
        }

        session()->push('comparison', $productId);
        return true;
    }

    public static function getProductTypes()
    {
        $sessionComparison = session('comparison');

        if (empty($sessionComparison)) {
            return collect();
        }

        $productTypes = ProductType::withWhereHas('products', function ($query) use ($sessionComparison) {
            $query->whereIn('id', $sessionComparison)->with('attributeValues.attribute', 'attributeValues.value');
        })
            ->with('attributes')
            ->get();

        return $productTypes;
    }
}
