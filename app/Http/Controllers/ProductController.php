<?php

namespace App\Http\Controllers;

use App\Helpers\Filter;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(ProductType $productType)
    {

        $filter = new Filter(request()->query());

        $categories = $productType
            ->categories()
            ->withProductsCount($filter)
            ->get();

        $attributes = $productType
            ->attributes()
            ->withUniqueValues($filter);

        $products = $productType
            ->products()
            ->withCategory($filter->categories)
            ->withAttributes()
            ->filterByAttributes($filter->attributes)
            ->sortBy($filter->sortBy)
            ->showProducts($filter->showProducts);


        $productsCopy = clone $products;
        $priceRange = $productsCopy->getPriceRange();
        $minPrice = $priceRange->value('min_price');
        $maxPrice = $priceRange->value('max_price');

        if ($filter->priceRange) {
            $products->filterByPriceRange($filter->priceRange);
        }

        $products = $products->paginate($filter->pageSize);

        $quickFilters = $productType
            ->quickFilters()
            ->with('attribute', 'value')
            ->get();

        return view('products.index')
            ->with([
                'type' => $productType,
                'products' => $products,
                'categories' => $categories,
                'attributes' => $attributes,
                'filter' => $filter,
                'quickFilters' => $quickFilters,
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice,
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
