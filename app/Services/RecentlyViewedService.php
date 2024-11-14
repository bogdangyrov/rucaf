<?php

namespace App\Services;

use App\Models\Product;

class RecentlyViewedService
{
    public static function addProduct(Product $product)
    {
        if (in_array($product->id, session('products', []))) {
            $productIndex = array_search($product->id, session('products'));
            session()->pull('recently-viewed.' .  $productIndex);
        }
        session()->push('recently-viewed', $product->id);
    }

    public static function getProducts()
    {
        $recentlyViewedProducts = session('recently-viewed', []);

        if ($recentlyViewedProducts) {
            $recentlyViewedProducts = Product::whereIn('id', $recentlyViewedProducts)
                ->active()
                ->orderByRaw('FIELD(id, ' . implode(',', $recentlyViewedProducts) . ') DESC')
                ->with('productType')
                ->limit(5)
                ->get();
        }

        return $recentlyViewedProducts;
    }
}
