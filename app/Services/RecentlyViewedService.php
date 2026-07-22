<?php

namespace App\Services;

use App\Models\Product;

class RecentlyViewedService
{
    public static function addProduct(Product $product)
    {
        $recentlyViewed = session('recently-viewed', []);
        $recentlyViewed = array_diff($recentlyViewed, [$product->id]);
        
        array_unshift($recentlyViewed, $product->id);
        $recentlyViewed = array_slice($recentlyViewed, 0, 10);

        session(['recently-viewed' => $recentlyViewed]);
    }

    public static function getProducts()
    {
        $recentlyViewedIds = array_values(array_unique(session('recently-viewed', [])));

        if (empty($recentlyViewedIds)) {
            return collect();
        }

        return Product::whereIn('id', $recentlyViewedIds)
            ->active()
            ->with('subcategory.category.productType')
            ->orderByRaw('FIELD(id, ' . implode(',', $recentlyViewedIds) . ') DESC')
            ->limit(5)
            ->get();
    }

    public static function inProducts(Product $product)
    {
        return in_array($product->id, session('products', []));
    }
}
