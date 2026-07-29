@extends('layouts.master')

@section('content')
    <div class="wrap wrap--light-gray">
        <div class="content">

            @include('components.breadcrumbs', ['items' => [
                ['label' => 'Главная', 'url' => route('home')],
                ['label' => 'Каталог', 'url' => route('catalog')],
                ['label' => $type->name, 'url' => route('product-types.index', ['productType' => $type])],
                ['label' => $category->name],
            ]])

            <div class="title title--inline">
                <h1>{{ $category->h1 ?: $category->name }}</h1>
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
        'shortText' => $category->short_text,
        'longText' => $category->long_text,
    ])
    @include('components.frequent-questions')
@endsection
