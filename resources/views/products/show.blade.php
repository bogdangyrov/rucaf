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
                    $breadcrumbs[] = ['label' => $type->name, 'url' => route('product-types.index', ['productType' => $type])];
                    $breadcrumbs[] = ['label' => $category->name, 'url' => route('categories.index', ['productType' => $type, 'category' => $category])];
                } elseif ($showProductTypeInBreadcrumbs) {
                    $breadcrumbs[] = ['label' => $type->name, 'url' => route('product-types.index', ['productType' => $type])];
                }
                $breadcrumbs[] = ['label' => $subcategory->name, 'url' => route('products.index', ['productType' => $type, 'category' => $category, 'subcategory' => $subcategory])];
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
