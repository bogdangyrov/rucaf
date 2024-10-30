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

        debugbar()->info($filter);

        $categories = $productType->categories()->withCount(['products' => function ($query) use ($filter) {
            $query->filterByAttributes($filter->attributes);
        }])->get();

        $attributes = $productType->attributes()->withUniqueValues($filter);

        /*
        1. Получаем из query attributes и categories
        2. Получаем список всех доступных attributes и categories с количеством products
        3. Получаем products согласно attributes и categories из query + pagination
        */


        $products = $productType
            ->products()
            ->withCategory($filter->categories)
            ->withAttributes()
            ->filterByAttributes($filter->attributes)
            ->get();

        return view('products.index')->with([
            'type' => $productType,
            'products' => $products,
            'categories' => $categories,
            'attributes' => $attributes,
            'filter' => $filter
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
