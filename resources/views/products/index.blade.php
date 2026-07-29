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
                $breadcrumbs[] = ['label' => $subcategory->name];
            @endphp
            @include('components.breadcrumbs', ['items' => $breadcrumbs])

            <div class="title title--inline">
                <h1>{{ $subcategory->h1 ?: $subcategory->name }}</h1>
                <span class="title__sum">{{ $products->total() }} товаров</span>
            </div>

        </div>
    </div>

    <div class="wrap">
        <div class="page content">
            <div class="wrap-products">
                @include('products.components.index.filters')
                @include('products.components.index.products')
            </div>
        </div>
    </div>

    @include('products.components.why-choose-us')
    @include('products.components.recently-watched')
    @include('products.components.index.description', [
        'shortText' => $subcategory->short_text,
        'longText' => $subcategory->long_text,
    ])
    @include('components.frequent-questions')
@endsection

@push('js')
    @vite('resources/js/pages/products.js')
@endpush
