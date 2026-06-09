<?php

namespace App\Http\Controllers\Web;

use App\Helper\Seo;
use App\Helpers\Filter;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Subcategory;
use App\Services\RecentlyViewedService;

class ProductController extends Controller
{
    public function index(ProductType $productType, Category $category, Subcategory $subcategory)
    {
        $filter = new Filter($productType, $category, $subcategory, request()->query());

        $categories = $productType->categories()->with(['subcategories' => function ($query) {
            $query->orderBy('name');
            $query->withCount('products');
        }])->get();

        $attributes = Attribute::getWithValues($filter);

        $products = $subcategory
            ->products()
            ->with('subcategory')
            ->with(['category.productType'])
            ->with('attributeValues.attribute', 'attributeValues.value')
            ->active()
            ->filterByAttributes($filter->attributes)
            ->sortBy($filter->sortBy)
            ->showProducts($filter->showProducts);

        $productsCopy = clone $products;
        $priceRange = $productsCopy->getPriceRange()->first();
        $minPrice = $priceRange->min_price;
        $maxPrice = $priceRange->max_price;

        if ($filter->priceRange) {
            $products->filterByPriceRange($filter->priceRange);
        }

        $products = $products->paginate($filter->pageSize);

        $quickFilters = $subcategory
            ->quickFilters()
            ->with('category', 'subcategory', 'attribute', 'value')
            ->get();

        $seoTitle = $subcategory->seo_title ?: "{$subcategory->name}, цена, купить";
        $seoDescription = $subcategory->seo_description ?: "Купить {$subcategory->name} для промышленных нужд от компании Rucaf.ru Надежное оборудование с доставкой по всей России.";

        $fallbackImage = ($subcategory->images[0] ?? null)
            ? asset('storage/' . $subcategory->images[0])
            : ($productType->image ? asset('storage/' . $productType->image) : null);

        $seo = new Seo(
            $seoTitle,
            $seoDescription,
            $subcategory->og_title ?: $seoTitle,
            $subcategory->og_description ?: $seoDescription,
            $fallbackImage,
            url('/catalog/' . $productType->slug . '/' . $category->slug . '/' . $subcategory->slug),
            'website',
        );

        $showProductTypeAndCategoryInBreadcrumbs = $categories->count() > 1 && $category->subcategories->count() > 1;
        $showProductTypeInBreadcrumbs = $categories->count() > 1 && $category->subcategories->count() == 1;

        return view('products.index')
            ->with([
                'type' => $productType,
                'products' => $products,
                'category' => $category,
                'subcategory' => $subcategory,
                'categories' => $categories,
                'attributes' => $attributes,
                'filter' => $filter,
                'quickFilters' => $quickFilters,
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice,
                'showProductTypeAndCategoryInBreadcrumbs' => $showProductTypeAndCategoryInBreadcrumbs,
                'showProductTypeInBreadcrumbs' => $showProductTypeInBreadcrumbs,
                'seo' => $seo,
            ]);
    }

    public function show(ProductType $productType, Category $category, Subcategory $subcategory, Product $product)
    {
        $product = $product->load(
            'category',
            'attributeValues.attribute',
            'attributeValues.value'
        );

        if (! RecentlyViewedService::inProducts($product)) {
            $product->update(['views' => $product->views + 1]);
        }

        RecentlyViewedService::addProduct($product);

        $relatedProducts = $subcategory
            ->products()
            ->active()
            ->with('category')
            ->where('id', '<>', $product->id)
            ->limit(5)
            ->get();

        $seoTitle = $product->seo_title ?: "{$product->name}, цена, купить";
        $seoDescription = $product->seo_description ?: "Купить {$product->name} для промышленных нужд от компании Rucaf.ru Надежное оборудование с доставкой по всей России.";

        $fallbackImage = ($product->image ?? null)
            ? asset('storage/' . $product->image)
            : (($subcategory->images[0] ?? null)
                ? asset('storage/' . $subcategory->images[0])
                : ($productType->image ? asset('storage/' . $productType->image) : null));

        $seo = new Seo(
            $seoTitle,
            $seoDescription,
            $product->og_title ?: $seoTitle,
            $product->og_description ?: $seoDescription,
            $fallbackImage,
            url('/catalog/' . $productType->slug . '/' . $category->slug . '/' . $subcategory->slug . '/' . $product->slug),
            'product',
        );

        $productType->load('categories.subcategories');

        $showProductTypeAndCategoryInBreadcrumbs = $productType->categories->count() > 1 && $category->subcategories->count() > 1;
        $showProductTypeInBreadcrumbs = $productType->categories->count() > 1 && $category->subcategories->count() == 1;

        return view('products.show')
            ->with([
                'type' => $productType,
                'category' => $category,
                'subcategory' => $subcategory,
                'product' => $product,
                'relatedProducts' => $relatedProducts,
                'showProductTypeAndCategoryInBreadcrumbs' => $showProductTypeAndCategoryInBreadcrumbs,
                'showProductTypeInBreadcrumbs' => $showProductTypeInBreadcrumbs,
                'seo' => $seo,
            ]);
    }
}
