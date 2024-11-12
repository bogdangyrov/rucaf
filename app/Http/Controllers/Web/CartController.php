<?php

namespace App\Http\Controllers\Web;

use App\Services\CartService;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        $products = CartService::get();
        return view('cart')
            ->with([
                'products' => $products
            ]);
    }
}
