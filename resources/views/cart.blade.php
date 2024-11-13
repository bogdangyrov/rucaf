@extends('layouts.master')

@section('content')
    <style>
        .cart-page {
            padding: 20px;
            font-family: 'Source Sans 3';
        }

        .cart-page__header {
            text-align: center;
            margin-bottom: 20px;
        }

        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #E4E4E4;
            padding: 16px 0;
        }

        .cart-item__image img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
        }

        .cart-item__details {
            flex: 1;
            margin-left: 16px;
        }

        .cart-item__title {
            font-size: 18px;
            font-weight: 600;
        }

        .cart-item__price {
            display: flex;
            color: #666;
            font-size: 16px;
        }

        .cart-item__quantity {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
        }

        .cart-item__quantity-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-item__quantity-input {
            width: 50px;
            text-align: center;
            font-size: 16px;
            padding: 4px;
            border: 1px solid #E4E4E4;
            border-radius: 4px;
        }

        .cart-item__remove {
            margin-left: auto;
        }

        .cart-summary {
            margin-top: 20px;
            text-align: center;
        }

        .cart-summary__total {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .cart__old-price {
            margin-left: 10px;
            color: #B8B8B8;
            text-decoration: line-through;
        }

        /* Адаптация для мобильных устройств */
        @media (max-width: 768px) {
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .cart-item__details {
                margin-left: 0;
                margin-top: 12px;
            }

            .cart-item__remove {
                margin-top: 12px;
            }
        }
    </style>
    <div class="wrap-main">
        <div class="content">

            <div class="cart-page">
                <div class="cart-page__header title">
                    <h1>Корзина</h1>
                </div>

                <div class="cart-items">
                    <!-- Пример товара в корзине -->
                    @foreach ($products as $product)
                        <div class="cart-item">
                            <div class="cart-item__image">
                                <img src="{{ asset(isset($product->images[0]) ? "storage/{$product->images[0]}" : 'assets/img/content/product-1.jpg') }}"
                                    alt="{{ $product->name }}">
                            </div>
                            <div class="cart-item__details">
                                <h2 class="cart-item__title">{{ $product->name }}</h2>
                                <div class="cart-item__price">
                                    Цена:
                                    @isset($product->discount_price)
                                        {!! $product->getFormattedDiscountPrice() !!}₽
                                        <div class="cart__old-price">
                                            {!! $product->getFormattedPrice() !!}₽
                                        </div>
                                    @else
                                        {!! $product->getFormattedPrice() !!}₽
                                    @endisset
                                </div>
                                @livewire(Cart\Counter::class, ['quantity' => $product->quantity, 'product' => $product])
                            </div>
                            <div class="cart-item__remove">
                                <button class="btn btn--gray">Удалить</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="cart-summary">
                    <p class="cart-summary__total">Всего: {!! \App\Models\Product::formatPrice($totalSum) !!}₽</p>
                    <button class="btn">Оставить заявку</button>
                </div>
            </div>
        </div>
    @endsection
