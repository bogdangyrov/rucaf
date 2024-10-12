<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $type = 1;
        $products = Product::where('product_type_id', $type)->with('attributeValues.attribute', 'category')->get();
        $categories = Category::where('product_type_id', $type)->get();
        $attributes = Attribute::with('attributeValues')->get();
        foreach ($attributes as $attribute) {
            $attribute->attributeValues = $attribute->attributeValues->unique('value');
        }
        return view('products.index')->with(['products' => $products, 'categories' => $categories, 'attributes' => $attributes]);
    }
}
