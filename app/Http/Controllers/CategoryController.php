<?php

namespace App\Http\Controllers;

use App\Helper\Seo;
use App\Helpers\Filter;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductType;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(ProductType $productType, Category $category)
    {
        $filter = new Filter($productType, $category, requestQuery: request()->query());

        $categories = $productType->categories()->with(['subcategories' => function ($query) {
            $query->orderBy('name');
            $query->withCount('products');
        }])->get();

        $subcategories = $category->subcategories()->withCount('products')->get();
        $subcategoriesIds = $subcategories->pluck('id')->toArray();

        if ($subcategories->count() === 1) {
            return redirect()->route('products.index', [
                'productType' => $productType,
                'category' => $category,
                'subcategory' => $subcategories->first(),
            ]);
        }

        $products = Product::whereIn('subcategory_id', $subcategoriesIds)
            ->with('subcategory')
            ->with(['category.productType'])
            ->active()
            ->sortBy($filter->sortBy)
            ->showProducts($filter->showProducts)
            ->paginate($filter->pageSize);

        $seo = new Seo(
            "{$category->name} — Промышленное оборудование от Rucaf | rucaf.com",
            'Купить ' . mb_strtolower(
                $category->name
            ) . ' для промышленных нужд от компании Rucaf. Надежное оборудование с доставкой по всей России.',
            "{$category->name} — Промышленное оборудование от Rucaf",
            'Посмотрите наш ассортимент — ' . mb_strtolower(
                $category->name
            ) . ' для различных промышленных нужд. Выбор качественного оборудования от Rucaf с доставкой по всей России.',
            asset('storage/' . $productType->image),
            route('categories.index', ['productType' => $productType, 'category' => $category]),
            'website',
        );

        return view('categories.index')->with([
            'type' => $productType,
            'categories' => $categories,
            'category' => $category,
            'subcategories' => $subcategories,
            'products' => $products,
            'filter' => $filter,
            'seo' => $seo,
            'quickFilters' => [],
        ]);
    }
}
