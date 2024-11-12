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
        session()->push('cart', ['product_id' => $productId, 'quantity' => $quantity]);
        return true;
    }

    public static function get()
    {
        $sessionCart = session()->get('cart');
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
}
