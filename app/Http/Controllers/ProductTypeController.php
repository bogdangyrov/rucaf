<?php

namespace App\Http\Controllers;

use App\Helpers\Filter;
use App\Models\Product;
use App\Models\ProductType;
use App\Http\Controllers\Controller;
use App\Helper\Seo;

class ProductTypeController extends Controller
{
    public function index(ProductType $productType)
    {
        $filter = new Filter($productType, requestQuery: request()->query());

        $categories = $productType->categories()->with('subcategories')->get();

        $subcategoriesIds = $categories->pluck('subcategories.*.id')->flatten()->toArray();

        $products = Product::whereIn('subcategory_id', $subcategoriesIds)
            ->with('subcategory')
            ->with(['category.productType'])
            ->active()
            ->sortBy($filter->sortBy)
            ->showProducts($filter->showProducts)
            ->paginate($filter->pageSize);

        $seo = new Seo(
            "{$productType->name} — Промышленное оборудование от Rucaf | rucaf.com",
            'Купить ' . mb_strtolower(
                $productType->name
            ) . ' для промышленных нужд от компании Rucaf. Надежное оборудование с доставкой по всей России.',
            "{$productType->name} — Промышленное оборудование от Rucaf",
            'Посмотрите наш ассортимент — ' . mb_strtolower(
                $productType->name
            ) . ' для различных промышленных нужд. Выбор качественного оборудования от Rucaf с доставкой по всей России.',
            asset('storage/' . $productType->image),
            route('product-types.index', ['productType' => $productType]),
            'website',
        );

        return view('product-types.index')->with([
            'type' => $productType,
            'categories' => $categories,
            'products' => $products,
            'filter' => $filter,
            'seo' => $seo,
            'quickFilters' => [],
        ]);
    }
}
