@extends('layouts.master')

@section('content')
    <div class="wrap wrap--light-gray">
        <div class="content">

            <div class="bread">
                <a href="{{ route('home') }}" class="bread__link">Главная</a>
                <span class="bread__sep"><i class="icon-arrow1"></i></span>
                <a href="{{ route('catalog') }}" class="bread__link">Каталог</a>
                <span class="bread__sep"><i class="icon-arrow1"></i></span>
                <a href="{{ route('products.index', ['productType' => $type->slug]) }}"
                    class="bread__link">{{ $type->name }}</a>
            </div>

            <div class="title title--inline">
                <h1>{{ $type->name }}</h1>
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
    @include('products.components.index.description')
    @include('components.frequent-questions')
@endsection

@section('js')
    <script>
        $(function() {
            $('form.w-filters').submit(function(e) {
                if (!$('#slider-range').hasClass('changed')) {
                    $('input.slider-value').remove();
                }
            });
        })
    </script>
    {{-- <script>
        $(document).ready(function() {
            $('.filters-list__checkbox').on('click', function(e) {
                sendRequest();
            });

            $('#search-button').on('click', function(e) {
                e.preventDefault();
                sendRequest();
            });

            $('.price-range-field').on('change', function(e) {
                e.preventDefault();
                sendRequest();
            });

            $('.price-filter-range').on('slidestop', function(e) {
                sendRequest();
            });

            function sendRequest() {
                let selectedFilters = getFilters();
                console.log(selectedFilters);
                $.ajax({
                    type: 'get',
                    url: '{{ route('category.filter', ['category' => $category->slug]) }}',
                    data: selectedFilters,
                    success: function(data) {
                        console.log(data.status);
                        console.log(data.request);
                        $('#grid-include').html(data.html);
                    }
                });
            }

            function getFilters() {
                let filters = {};
                $('.filters-list__checkbox').each(function() {
                    if (this.checked === true && this.value !== 'null') {
                        let filterId = $(this).attr('data-filter-id');

                        if (filters.hasOwnProperty(filterId) === false) {
                            filters[filterId] = [];
                        }

                        filters[filterId].push(this.value)
                    }
                });

                return {
                    "filters": filters,
                    "minPrice": Number($('#min_price').val()),
                    "maxPrice": Number($('#max_price').val())
                };
            }
        });
    </script> --}}
@endsection
