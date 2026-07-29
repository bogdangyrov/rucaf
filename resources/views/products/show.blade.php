@extends('layouts.master')

@section('content')
    <div class="wrap wrap--light-gray">
        <div class="content">
            @php
                $breadcrumbs = [
                    ['label' => 'Главная', 'url' => route('home')],
                    ['label' => 'Каталог', 'url' => route('catalog')],
                ];
                if ($showProductTypeAndCategoryInBreadcrumbs) {
                    $breadcrumbs[] = [
                        'label' => $type->name,
                        'url' => route('product-types.index', ['productType' => $type]),
                    ];
                    $breadcrumbs[] = [
                        'label' => $category->name,
                        'url' => route('categories.index', ['productType' => $type, 'category' => $category]),
                    ];
                } elseif ($showProductTypeInBreadcrumbs) {
                    $breadcrumbs[] = [
                        'label' => $type->name,
                        'url' => route('product-types.index', ['productType' => $type]),
                    ];
                }
                $breadcrumbs[] = [
                    'label' => $subcategory->name,
                    'url' => route('products.index', [
                        'productType' => $type,
                        'category' => $category,
                        'subcategory' => $subcategory,
                    ]),
                ];
            @endphp
            @include('components.breadcrumbs', ['items' => $breadcrumbs])
            <div class="title title--inline">
                <h1>{{ $product->h1 ?: $product->name }}</h1>
                @if ($product->is_new)
                    <span class="title__sale">Новинка</span>
                @endif
            </div>
        </div>
    </div>

    <div class="wrap">
        <div class="page content">
            @if ($product->is_active)
                <div class="page-product">
                    <div class="w-page-product">
                        @include('products.components.show.slider')
                        @include('products.components.show.product-info')
                    </div>

                    @include('products.components.show.good-info')
                </div>

                @php
                    $schemaProperties = [];
                    foreach ($product->attributeValues as $attributeValue) {
                        $schemaProperties[] = [
                            '@type' => 'PropertyValue',
                            'name' => $attributeValue->attribute->name,
                            'value' => $attributeValue->value->value,
                        ];
                    }
                    if (isset($product->dimensions)) {
                        $schemaProperties[] = [
                            '@type' => 'PropertyValue',
                            'name' => 'Габариты ШхВхГ, мм',
                            'value' => $product->dimensions,
                        ];
                    }
                    if (isset($product->mass)) {
                        $schemaProperties[] = [
                            '@type' => 'PropertyValue',
                            'name' => 'Масса, кг',
                            'value' => $product->mass,
                        ];
                    }

                    $schemaImages = [];
                    foreach ($subcategory->images ?? [] as $img) {
                        $schemaImages[] = asset('storage/' . $img);
                    }
                    foreach ($product->images ?? [] as $img) {
                        $schemaImages[] = asset('storage/' . $img);
                    }
                    if (empty($schemaImages)) {
                        $schemaImages[] = asset('img/content/product-1.jpg');
                    }

                    $rawDescription = strip_tags(
                        str_replace(
                            '{NAME}',
                            explode(' ', $product->name)[1] ?? '',
                            $product->description ?? ($subcategory->description ?? ''),
                        ),
                    );
                @endphp

                @php
                    $schemaProperties = [];
                    foreach ($product->attributeValues as $attributeValue) {
                        $schemaProperties[] = [
                            '@type' => 'PropertyValue',
                            'name' => $attributeValue->attribute->name,
                            'value' => $attributeValue->value->value,
                        ];
                    }
                    if (isset($product->dimensions)) {
                        $schemaProperties[] = [
                            '@type' => 'PropertyValue',
                            'name' => 'Габариты ШхВхГ, мм',
                            'value' => $product->dimensions,
                        ];
                    }
                    if (isset($product->mass)) {
                        $schemaProperties[] = [
                            '@type' => 'PropertyValue',
                            'name' => 'Масса, кг',
                            'value' => $product->mass,
                        ];
                    }

                    $schemaImages = [];
                    foreach ($subcategory->images ?? [] as $img) {
                        $schemaImages[] = asset('storage/' . $img);
                    }
                    foreach ($product->images ?? [] as $img) {
                        $schemaImages[] = asset('storage/' . $img);
                    }
                    if (empty($schemaImages)) {
                        $schemaImages[] = asset('img/content/product-1.jpg');
                    }

                    $rawDescription = $product->description ?? ($subcategory->description ?? '');
                    $cleanDescription = strip_tags(
                        str_replace(['{NAME}', "\r", "\n", "\t"], ['', ' ', ' ', ' '], $rawDescription),
                    );
                    $cleanDescription = preg_replace('/\s+/', ' ', trim($cleanDescription));

                    $schemaData = [
                        '@context' => 'https://schema.org/',
                        '@type' => 'Product',
                        'name' => $product->name,
                        'image' => $schemaImages,
                        'description' => $cleanDescription,
                        'brand' => [
                            '@type' => 'Brand',
                            'name' => $product->brand->name ?? 'Промтеплострой',
                        ],
                        'offers' => [
                            '@type' => 'Offer',
                            'url' => url()->current(),
                            'priceCurrency' => 'RUB',
                            'price' => (string) ($product->price ?? 0),
                            'priceValidUntil' => now()->addYear()->format('Y-m-d'),
                            'itemCondition' => 'https://schema.org/NewCondition',
                            'availability' =>
                                $product->in_stock ?? true
                                    ? 'https://schema.org/InStock'
                                    : 'https://schema.org/OutOfStock',
                            'seller' => [
                                '@type' => 'Organization',
                                'name' => 'Промтеплострой',
                            ],
                        ],
                    ];

                    if (!empty($product->article)) {
                        $schemaData['sku'] = $product->article;
                        $schemaData['mpn'] = $product->article;
                    }

                    if (!empty($schemaProperties)) {
                        $schemaData['additionalProperty'] = $schemaProperties;
                    }
                @endphp

                <script type="application/ld+json">
                {!! json_encode($schemaData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
                </script>
            @else
                <div class="page-product">
                    <p class="product-not-available">К сожалению сейчас этот товар не доступен. С его аналогами можете
                        ознакомиться в
                        <a
                            href="{{ route('products.index', ['productType' => $type, 'category' => $type->categories[0], 'subcategory' => $type->categories[0]->subcategories[0]]) }}">нашем
                            каталоге</a>!
                    </p>
                </div>
            @endif
        </div>
    </div>

    @include('products.components.modal-request-price')
    @include('products.components.show.modal-one-click-order')

    @include('products.components.why-choose-us')
    @include('products.components.show.related-products')
    @include('products.components.recently-watched')
    @include('components.frequent-questions')
@endsection
