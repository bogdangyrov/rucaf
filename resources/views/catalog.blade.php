@extends('layouts.master')

@section('content')
    <div class="wrap catalog-wrap--catalog wrap--light-gray">
        <div class="content">
            <div class="catalog-title title">
                <h2>Каталог</h2>
            </div>
            <div class="wrap-main-catalog">
                <div class="catalog-catalog">
                    @foreach ($productTypes as $type)
                        <a href="{{ route('product-types.index', ['productType' => $type]) }}" class="catalog-catalog__item">
                            <div class="catalog-catalog__img"><img src="{{ asset('storage/' . $type->image) }}"
                                    alt="Фото {{ $type->name }}">
                            </div>
                            <div class="catalog-catalog__title">{{ $type->name }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    @include('components.frequent-questions')
    @include('components.cities')
@endsection
