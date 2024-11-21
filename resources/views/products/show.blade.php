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
                <span class="bread__sep"><i class="icon-arrow1"></i></span>
                <a class="bread__link active">{{ $product->name }}</a>
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
            <div class="page-product">
                @if ($product->is_active)
                    <div class="w-page-product">
                        @include('products.components.show.slider')
                        @include('products.components.show.product-info')
                    </div>

                    @include('products.components.show.good-info')
                @else
                    <p class="product-not-available">К сожалению сейчас этот товар не доступен. С его аналогами можете
                        ознакомиться в
                        <a href="{{ route('products.index', ['productType' => $type]) }}">нашем каталоге</a>!
                    </p>
                @endif
            </div>
        </div>
    </div>

    @include('products.components.why-choose-us')
    @include('products.components.show.related-products')
    @include('products.components.recently-watched')
    @include('components.frequent-questions')
@endsection

@section('js')
    {{-- <script>
        $(function() {
            $('#add-to-cart').click(function() {
                const $this = $(this);
                const productId = $this.attr('data-id');

                let quantity = $this.closest('.good-card__actions').find('input.good-card__numb').val();
                if (quantity == '') {
                    quantity = 1;
                }
                $.ajax({
                    type: 'post',
                    url: '{{ route('cart.add') }}',
                    data: {
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function(data) {
                        console.log(data);
                    }
                });

            });
        })
    </script> --}}

    {{--  <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#add-to-cart').click(function() {
                let productId = $(this).attr('data-id');
                let count = $('#items-count').val();

                $.ajax({
                    type: 'post',
                    url: '{{ route('cart.add') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        product_id: productId,
                        count: count
                    },
                    success: function(data) {
                        console.log(data);
                        $('#grid-include').html(data.html);
                    }
                });
            });

            $.ajax({
                type: 'get',
                url: '{{ route('favorites.check') }}',
                data: {
                    product_id: $('[name="add-wishlist__btn"]').attr('data-id'),
                },
                success: function(data) {
                    if (data.status == 'success') {
                        $('[name="add-wishlist__btn"] > i').addClass('favorites');
                        $('[name="add-wishlist__btn"] > span').text('В избранном');

                    }
                }
            });

            $('[name="add-wishlist__btn"]').click(function() {
                if ($('[name="add-wishlist__btn"] > i').hasClass('favorites') === true) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('favorites.remove') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            product_id: $(this).attr('data-id'),
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                $('[name="add-wishlist__btn"] > i').removeClass('favorites');
                                $('[name="add-wishlist__btn"] > span').text('В избранное');

                            }
                        }
                    });
                } else {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('favorites.add') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            product_id: $(this).attr('data-id'),
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                $('[name="add-wishlist__btn"] > i').addClass('favorites');
                                $('[name="add-wishlist__btn"] > span').text('В избранном');
                            }
                        }
                    });
                }
            });
        });
    </script> --}}
@endsection
