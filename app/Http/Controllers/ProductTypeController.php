<?php

namespace App\Http\Controllers;

use App\Helper\Seo;
use App\Helpers\Filter;
use App\Models\Product;
use App\Models\ProductType;

class ProductTypeController extends Controller
{
    public function index(ProductType $productType)
    {
        $filter = new Filter($productType, requestQuery: request()->query());

        $categories = $productType->categories()->with('subcategories')->get();

        $subcategoriesIds = $categories->pluck('subcategories.*.id')->flatten()->toArray();

        if ($categories->count() == 1 && $categories[0]->subcategories->count() == 1) {
            $category = $categories[0];
            $subcategory = $categories[0]->subcategories[0];

            return redirect()->route('products.index', [
                'productType' => $productType,
                'category' => $category,
                'subcategory' => $subcategory,
            ]);
        }

        $products = Product::whereIn('subcategory_id', $subcategoriesIds)
            ->with('subcategory')
            ->with(['category.productType'])
            ->active()
            ->sortBy($filter->sortBy)
            ->showProducts($filter->showProducts)
            ->paginate($filter->pageSize);

        $seoTitle = $productType->seo_title ?: "{$productType->name}, цена, купить";
        $seoDescription = $productType->seo_description ?: "Купить {$productType->name} для промышленных нужд от компании Rucaf.ru Надежное оборудование с доставкой по всей России.";

        $seo = new Seo(
            $seoTitle,
            $seoDescription,
            $productType->og_title ?: $seoTitle,
            $productType->og_description ?: $seoDescription,
            $productType->image ? asset('storage/' . $productType->image) : null,
            url('/catalog/' . $productType->slug),
            'website'
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
