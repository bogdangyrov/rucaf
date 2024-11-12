<?php

namespace App\Http\Controllers\Web;

use App\Services\CartService;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        $products = CartService::get();
        $totalSum = $products->sum(function ($product) {
            return $product->discount_price ?? $product->price;
        });

        return view('cart')
            ->with([
                'products' => $products,
                'totalSum' => $totalSum
            ]);
    }
}
