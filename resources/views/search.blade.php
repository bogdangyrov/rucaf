@extends('layouts.master')

@section('content')
    <style>
        .search-page {
            font-family: 'Source Sans 3';
            border-bottom: 1px solid #E4E4E4;
        }

        .search-page__header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #E4E4E4;
        }

        .search-empty {
            text-align: center;
            padding: 40px;
            font-size: 30px;
        }
    </style>
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
