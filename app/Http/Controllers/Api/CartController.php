<?php

namespace App\Http\Controllers\Api;

use App\Services\CartService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductToCart;

class CartController extends Controller
{
    public function add(AddProductToCart $request)
    {
        $productId = $request->validated('product_id');
        $quantity = $request->validated('quantity');
        return CartService::add($productId, $quantity);
    }
}
