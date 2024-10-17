@extends('layouts.master')

@section('content')
    <div class="wrap wrap--light-gray">
        <div class="content">
            @include('products.components.breadcrumb')
            <div class="title title--inline">
                <h1>{{ $type->name }}</h1>
                <span class="title__sum">{{ count($products) }} товаров</span>
            </div>
        </div>
    </div>
    <div class="wrap">
        <div class="page content">
            <div class="wrap-products">
                @include('products.components.filters')
                @include('products.components.products')
            </div>
        </div>
    </div>

    @include('products.components.why-choose-us')
    @include('products.components.recently-watched')
    @include('products.components.type-description')
    @include('components.frequent-questions')
@endsection

@section('js')
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
