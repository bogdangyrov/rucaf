<?php

namespace App\Http\Controllers;

use App\Helpers\Filter;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    public function index(ProductType $productType)
    {

        $filter = new Filter(request()->query());

        $categories = $productType->categories()->withCount(['products' => function ($query) use ($filter) {
            $query->filterByAttributes($filter->attributes);
        }])->get();

        $attributes = $productType->attributes()->withUniqueValues($filter);

        $products = $productType
            ->products()
            ->withCategory($filter->categories)
            ->withAttributes()
            ->filterByAttributes($filter->attributes)
            ->get();

        $quickFilters = $productType->quickFilters()->with('attribute', 'value')->get();

        return view('products.index')->with([
            'type' => $productType,
            'products' => $products,
            'categories' => $categories,
            'attributes' => $attributes,
            'filter' => $filter,
            'quickFilters' => $quickFilters
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
}
