<?php

namespace App\Service;

use App\Models\Product;
use Symfony\Component\CssSelector\Node\FunctionNode;

class FavoritesService
{
    public static function add($productId)
    {
        if (in_array($productId, session('favorites', []))) {
            return false;
        }

        session()->push('favorites', $productId);
        return true;
    }

    public static function getProducts()
    {
        $sessionFavorites = session('favorites', []);

        if (empty($sessionFavorites)) {
            return collect();
        }
        $products = Product::whereIn('id', $sessionFavorites)
            ->with('productType')
            ->get();

        return $products;
    }

    public static function getTotalQuantity()
    {
        return count(session('favorites', []));
    }

    public static function inFavorites(int $productId)
    {
        return in_array($productId, session('favorites', []));
    }
}
