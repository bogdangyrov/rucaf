<?php

namespace App\Services;

use App\Models\ProductType;
use App\Models\Subcategory;

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

    public static function getSubcategories()
    {
        $sessionComparison = session('comparison');

        if (empty($sessionComparison)) {
            return collect();
        }

        $subcategories = Subcategory::withWhereHas('products', function ($query) use ($sessionComparison) {
            $query->whereIn('id', $sessionComparison)->with('attributeValues.attribute', 'attributeValues.value');
        })
            ->with('attributes', 'category.productType')
            ->get();

        return $subcategories;
    }

    public static function inComparison($productId)
    {
        return in_array($productId, session('comparison', []));
    }

    public static function getTotalQuantity()
    {
        return count(session('comparison', []));
    }

    public static function delete($productId)
    {
        $sessionComparison = session('comparison', []);
        if (empty($sessionComparison)) {
            return false;
        }

        $productIndex = array_search($productId, $sessionComparison);

        if ($productIndex === false) {
            return false;
        }

        session()->pull('comparison.' . $productIndex);
        return true;
    }
}
