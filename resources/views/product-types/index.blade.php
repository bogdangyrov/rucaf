@extends('layouts.master')

@section('content')
    <div class="wrap wrap--light-gray">
        <div class="content">

            @include('components.breadcrumbs', ['items' => [
                ['label' => 'Главная', 'url' => route('home')],
                ['label' => 'Каталог', 'url' => route('catalog')],
                ['label' => $type->name],
            ]])

            <div class="title title--inline">
                <h1>{{ $type->h1 ?: $type->name }}</h1>
            </div>

        </div>
    </div>

    <div class="wrap">
        <div class="page content">
            <div class="wrap-products">
                @include('product-types.components.index.filters')
                @include('products.components.index.products')
            </div>
        </div>
    </div>

    @include('products.components.why-choose-us')
    @include('products.components.recently-watched')
    @include('products.components.index.description', [
        'shortText' => $type->short_text,
        'longText' => $type->long_text,
    ])
    @include('components.frequent-questions')
@endsection
