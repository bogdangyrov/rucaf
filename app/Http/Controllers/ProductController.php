<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\ProductType;

class ProductController extends Controller
{
    public function index(ProductType $productType)
    {
        $categories = $productType->categories()->get();
        $attributes = $productType->attributes()->withUniqueValues();

        $filterCategories = request()->query('category');
        $filters = static::filtersFromQuery($attributes->pluck('slug')->toArray());

        $products = $productType
            ->products()
            ->withCategory($filterCategories)
            ->withAttributes()
            ->filterByAttributes($filters)
            ->get();

        return view('products.index')->with([
            'type' => $productType,
            'products' => $products,
            'categories' => $categories,
            'attributes' => $attributes
        ]);
    }

    public function show(ProductType $productType, Product $product)
    {
        $product = $product->load(
            'category',
            'attributeValues.attribute',
            'attributeValues.value'
        );
        return view('products.show')->with(['type' => $productType,  'product' => $product]);
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
