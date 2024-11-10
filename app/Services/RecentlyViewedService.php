<?php

namespace App\Services;

use App\Models\Product;

class RecentlyViewedService
{
    public static function addProduct(Product $product)
    {
        if (in_array($product->id, session('products', []))) {
            $productIndex = array_search($product->id, session('products'));
            session()->pull('products.' .  $productIndex);
        }
        session()->push('products', $product->id);
    }

    public static function getProducts()
    {
        $recentlyViewedProducts = session('products', []);

        if ($recentlyViewedProducts)
            $recentlyViewedProducts = Product::whereIn('id', $recentlyViewedProducts)
                ->orderByRaw('FIELD(id, ' . implode(',', $recentlyViewedProducts) . ') DESC')
                ->get();

        return $recentlyViewedProducts;
    }
}
