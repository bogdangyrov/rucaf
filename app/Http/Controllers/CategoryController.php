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

        $seoTitle = $category->seo_title ?: "{$category->name}, цена, купить";
        $seoDescription = $category->seo_description ?: "Купить {$category->name} для промышленных нужд от компании Rucaf.ru Надежное оборудование с доставкой по всей России.";

        $seo = new Seo(
            $seoTitle,
            $seoDescription,
            $category->og_title ?: $seoTitle,
            $category->og_description ?: $seoDescription,
            $productType->image ? asset('storage/' . $productType->image) : null,
            url('/catalog/' . $productType->slug . '/' . $category->slug),
            'website'
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
