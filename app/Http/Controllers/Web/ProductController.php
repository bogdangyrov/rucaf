<?php

namespace App\Http\Controllers\Web;

use App\Helper\Seo;
use App\Helpers\Filter;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductType;
use App\Models\Subcategory;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
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
        $priceRange = $productsCopy->getPriceRange();
        $minPrice = $priceRange->value('min_price');
        $maxPrice = $priceRange->value('max_price');

        if ($filter->priceRange) {
            $products->filterByPriceRange($filter->priceRange);
        }

        $products = $products->paginate($filter->pageSize);

        $quickFilters = $subcategory
            ->quickFilters()
            ->with('category', 'subcategory', 'attribute', 'value')
            ->get();

        $seo = new Seo(
            "{$subcategory->name} — Промышленное оборудование от Rucaf | rucaf.com",
            'Купить ' . mb_strtolower(
                $subcategory->name
            ) . ' для промышленных нужд от компании Rucaf. Надежное оборудование с доставкой по всей России.',
            "{$subcategory->name} — Промышленное оборудование от Rucaf",
            'Посмотрите наш ассортимент — ' . mb_strtolower(
                $subcategory->name
            ) . ' для различных промышленных нужд. Выбор качественного оборудования от Rucaf с доставкой по всей России.',
            asset('storage/' . $productType->image),
            route('products.index', ['productType' => $productType->slug, 'category' => $category, 'subcategory' => $subcategory]),
            'website',
        );

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
                'seo' => $seo
            ]);
    }

    public function show(ProductType $productType, Category $category, Subcategory $subcategory, Product $product)
    {
        $product = $product->load(
            'category',
            'attributeValues.attribute',
            'attributeValues.value'
        );

        if (!RecentlyViewedService::inProducts($product)) {
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

        $seo = new Seo(
            "{$product->name} — Купить промышленное оборудование в Rucaf",
            "{$product->name} от компании Rucaf. Высокое качество и надежность для промышленных нужд. Доставка по всей России.",
            "{$product->name} — Купить в Rucaf",
            "{$product->name} для промышленных приложений. Отличается высокой надежностью и долговечностью. Закажите с доставкой по всей России от компании Rucaf.",
            isset($subcategory->images[0]) ? asset('storage/' . $subcategory->images[0]) : asset(
                'storage/' . $productType->image
            ),
            route('products.show', ['productType' => $productType->slug, 'category' => $category->slug, 'subcategory' => $subcategory->slug, 'product' => $product->slug]),
            'product',
        );

        return view('products.show')
            ->with([
                'type' => $productType,
                'category' => $category,
                'subcategory' => $subcategory,
                'product' => $product,
                'relatedProducts' => $relatedProducts,
                'seo' => $seo
            ]);
    }
}
