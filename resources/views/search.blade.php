@extends('layouts.master')

@section('content')
    <div class="wrap">
        <div class="content">
            <div class="search-page">
                <div class="search-page__header title">
                    <h1>Поиск</h1>
                </div>

                <div class="wrap-main">
                    <div class="content content--main">
                        <div class="wrap-search">
                            <livewire:search />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('products.components.recently-watched')
    @include('components.frequent-questions')
    @include('components.cities')
@endsection
