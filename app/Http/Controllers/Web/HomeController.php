<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $hotProducts = Product::where('is_hit_of_sales', true)->limit(20)->get();
        return view('index')->with('hotProducts', $hotProducts);
    }

    public function catalog()
    {
        return view('catalog');
    }
}
