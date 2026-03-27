@extends('layouts.master')

@section('content')
    <div class="wrap wrap--light-gray">
        <div class="content">
            <div class="bread">
                <a href="{{ route('home') }}" class="bread__link">Главная</a>
                <span class="bread__sep"><i class="icon-arrow1"></i></span>

                <a href="{{ route('catalog') }}" class="bread__link">Каталог</a>
                <span class="bread__sep"><i class="icon-arrow1"></i></span>

                @if ($showProductTypeAndCategoryInBreadcrumbs)
                    <a class="bread__link"
                        href="{{ route('product-types.index', ['productType' => $type]) }}">{{ $type->name }}</a>
                    <span class="bread__sep"><i class="icon-arrow1"></i></span>

                    <a class="bread__link"
                        href="{{ route('categories.index', ['productType' => $type, 'category' => $category]) }}">{{ $category->name }}</a>
                    <span class="bread__sep"><i class="icon-arrow1"></i></span>
                @endif

                @if ($showProductTypeInBreadcrumbs)
                    <a class="bread__link"
                        href="{{ route('product-types.index', ['productType' => $type]) }}">{{ $type->name }}</a>
                    <span class="bread__sep"><i class="icon-arrow1"></i></span>
                @endif

                <a href="{{ route('products.index', ['productType' => $type, 'category' => $category, 'subcategory' => $subcategory]) }}"
                    class="bread__link">{{ $subcategory->name }}</a>
                {{--  <span class="bread__sep"><i class="icon-arrow1"></i></span>

                <a class="bread__link active">{{ $product->name }}</a> --}}
            </div>
            <div class="title title--inline">
                <h1>{{ $product->name }}</h1>
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
                <div class="product-specs" id="chars">
                    <h2 style="padding-bottom: 10px">Технические характеристики</h2>
                    @php
                        $specs = [];
                        foreach ($product->attributeValues as $attributeValue) {
                            $specs[] = [
                                'name' => $attributeValue->attribute->name,
                                'value' => $attributeValue->value->value,
                            ];
                        }
                        if (isset($product->dimensions)) {
                            $specs[] = ['name' => 'Габариты ШхВхГ, мм', 'value' => $product->dimensions];
                        }
                        if (isset($product->mass)) {
                            $specs[] = ['name' => 'Масса, кг', 'value' => $product->mass];
                        }
                    @endphp
                    <div class="specs-grid">
                        @foreach ($specs as $spec)
                            <div class="spec-item">
                                <span class="spec-name">{{ $spec['name'] }}</span>
                                <span class="spec-dots"></span>
                                <span class="spec-value">{{ $spec['value'] }}</span>
                            </div>
                        @endforeach
                    </div>
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
