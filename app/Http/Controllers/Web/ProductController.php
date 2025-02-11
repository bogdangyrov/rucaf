<?php

namespace App\Http\Controllers\Web;

use App\Helper\Seo;
use App\Helpers\Filter;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductType;
use App\Services\RecentlyViewedService;

class ProductController extends Controller
{
    public function index(ProductType $productType)
    {
        $filter = new Filter(request()->query());

        $categories = $productType
            ->categories()
            ->with([
                'subcategories' => function ($query) use ($filter) {
                    $query->orderBy('name');
                    $query->withCount([
                        'products' => function ($query) use ($filter) {
                            $query->active();
                            $subcategories = $filter->subcategories->pluck('id');
                            if ($subcategories->count() > 0) {
                                $query->whereIn('sub_category_id', $subcategories);
                            }
                            $query->filterByAttributes($filter->attributes);
                            if ($filter->priceRange) {
                                $query->filterByPriceRange($filter->priceRange);
                            }
                        }
                    ]);
                }
            ])
            ->withProductsCount($filter)
            ->get();

        $attributes = $productType
            ->attributes()
            ->withUniqueValues($filter);

        $products = $productType
            ->products()
            ->active()
            ->with('productType')
            ->withCategory($filter->categories)
            ->withSubcategory($filter->subcategories)
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
            route('products.index', ['productType' => $productType->slug]),
            'website',
        );

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
                'seo' => $seo
            ]);
    }

    public function show(ProductType $productType, Product $product)
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

        $relatedProducts = $productType
            ->products()
            ->active()
            ->with('productType')
            ->where('id', '<>', $product->id)
            ->limit(5)
            ->get();

        $seo = new Seo(
            "{$product->name} — Купить промышленное оборудование в Rucaf",
            "{$product->name} от компании Rucaf. Высокое качество и надежность для промышленных нужд. Доставка по всей России.",
            "{$product->name} — Купить в Rucaf",
            "{$product->name} для промышленных приложений. Отличается высокой надежностью и долговечностью. Закажите с доставкой по всей России от компании Rucaf.",
            isset($product->images[0]) ? asset('storage/' . $product->images[0]) : asset(
                'storage/' . $productType->image
            ),
            route('products.show', ['productType' => $productType->slug, 'product' => $product->slug]),
            'product',
        );

        return view('products.show')
            ->with([
                'type' => $productType,
                'product' => $product,
                'relatedProducts' => $relatedProducts,
                'seo' => $seo
            ]);
    }
}
