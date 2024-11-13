<?php

namespace App\Services;

use App\Models\Product;

class CartService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function add(int $productId, int $quantity)
    {
        $sessionCart = session('cart', []);

        $recordIndex = static::array_first_key($sessionCart, function ($value) use ($productId) {
            return $value['product_id'] == $productId;
        });

        if (is_null($recordIndex)) {
            session()->push('cart', ['product_id' => $productId, 'quantity' => $quantity]);
        } else {
            $sessionCart[$recordIndex]['quantity'] = $quantity;
            session(['cart' => $sessionCart]);
        }

        return ['product_id' => $productId, 'quantity' => $quantity];
    }

    public static function delete(int $productId)
    {
        $sessionCart = session('cart', []);

        $recordIndex = static::array_first_key($sessionCart, function ($value) use ($productId) {
            return $value['product_id'] == $productId;
        });

        if (!is_null($recordIndex)) {
            session()->pull("cart.$recordIndex");
        }
        return true;
    }

    public static function get()
    {
        $sessionCart = session('cart');
        if (empty($sessionCart)) {
            return collect();
        }

        $products_ids = array_column($sessionCart, 'product_id');

        $products = Product::whereIn('id', $products_ids)->get();

        foreach ($products as $product) {
            $product->quantity = current(array_filter(
                $sessionCart,
                function ($el) use ($product) {
                    return $el['product_id'] == $product->id;
                }
            ))['quantity'];
        }
        return $products;
    }

    public static function getQuantity($productId)
    {
        $sessionCart = session('cart', []);
        return current(array_filter(
            $sessionCart,
            function ($el) use ($productId) {
                return $el['product_id'] == $productId;
            }
        ))['quantity'] ?? 0;
    }

    private static function array_first_key(array $array, callable $callback)
    {
        foreach ($array as $key => $value) {
            if ($callback($value)) {
                return $key;
            }
        }
        return null;
    }
}
