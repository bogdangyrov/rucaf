<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\ProductType;

class ProductController extends Controller
{

    public function index()
    {
        $types = ProductType::get();
        return view('products.index')->with('types', $types);
    }

    public function type(ProductType $productType)
    {

        $categories = $productType->categories()->get();
        $attributes = $productType->attributes()->withUniqueValues();

        $category = request()->query('category');
        $filters = static::filtersFromQuery($attributes->toArray());

        $products = $productType
            ->products()
            ->withAttributes()
            ->withCategory($category)
            ->filterByAttributes($filters)
            ->get();

        return view('products.type')->with([
            'type' => $productType,
            'products' => $products,
            'categories' => $categories,
            'attributes' => $attributes
        ]);
    }

    private static function filtersFromQuery($attributes)
    {
        $filter = [];
        foreach (request()->query() as $name => $value) {
            if (in_array($name, $attributes)) {
                $filter[$name] = $value;
            }
        }
        return $filter;
    }
}
