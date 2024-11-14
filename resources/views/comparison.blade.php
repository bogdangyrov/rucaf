@extends('layouts.master')

@section('content')
    <style>
        /* Основной контейнер */
        .comparison-page {
            padding: 20px;
            background: #FAFAFA;
            display: flex;
            flex-direction: column;
        }

        .comparison-page__header {
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        /* Навигация по категориям */
        .comparison-categories {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .category-btn {
            padding: 10px 20px;
            background: #F3F3F3;
            border-radius: 4px;
            color: #000;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.3s, color 0.3s;
        }

        .category-btn.active,
        .category-btn:hover {
            background: #E4B900;
            color: #fff;
        }

        /* Обертка таблицы для сравнения */
        .comparison-table-wrapper {
            overflow-x: auto;
            padding-bottom: 20px;
        }

        .comparison-table {
            display: table;
            width: 100%;
            border-spacing: 0;
            min-width: 600px;
        }

        /* Заголовок таблицы */
        .comparison-header {
            display: table-row;
            background: #6B6B76;
            color: #fff;
            font-weight: bold;
        }

        .comparison-header-item {
            display: table-cell;
            padding: 15px;
            border-right: 1px solid #EAEAEA;
            min-width: 150px;

            p {
                color: #EAEAEA;
            }

            img {
                max-width: 110px;
            }
        }

        .comparison-header-item:last-child {
            border-right: none;
        }

        /* Строки характеристик */
        .comparison-row {
            display: table-row;
            background: #FFFFFF;
        }

        .comparison-row:nth-child(even) {
            background: #F9F9F9;
        }

        .comparison-cell {
            display: table-cell;
            padding: 15px;
            border-right: 1px solid #EAEAEA;
            font-size: 14px;
        }

        .comparison-cell:last-child {
            border-right: none;
        }

        .characteristic {
            font-weight: bold;
            color: #464654;
        }

        /* Адаптивный дизайн для мобильных устройств */
        @media (max-width: 768px) {

            .comparison-header-item,
            .comparison-cell {
                display: block;
                width: 100%;
            }

            /* .comparison-row {
                                                                            display: flex;
                                                                            flex-direction: column;
                                                                        } */

            .comparison-header,
            .comparison-row {
                display: flex;
                justify-content: space-between;
                padding: 10px 0;
            }
        }

        /* Кнопка добавления товаров */
        .comparison-add-product {
            text-align: center;
            margin-top: 20px;
        }

        .add-product-btn {
            padding: 12px 24px;
            font-size: 16px;
            color: #fff;
            background: #6B6B76;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .add-product-btn:hover {
            background: #E4B900;
        }

        .tabs-info {
            flex-direction: row;
        }
    </style>
    <div class="wrap">
        <div class="content">
            <div class="comparison-page">
                <div class="comparison-page__header title">
                    <h1>Сравнение товаров</h1>
                </div>

                <div class="tabs">
                    <ul class="tabs__menu tabs-menu scroll">
                        @foreach ($productTypes as $type)
                            <li class="tabs-menu__item category-btn">
                                <a href="#type-{{ $type->slug }}" class="tabs-menu__link">{{ $type->name }}</a>
                            </li>
                        @endforeach
                    </ul>

                    @foreach ($productTypes as $type)
                        <div id="type-{{ $type->slug }}" class="tabs__content tabs-content">
                            <div class="tabs-info">

                                <div class="comparison-table-wrapper" id="comparison-table-1">
                                    <div class="comparison-table">

                                        <div class="comparison-header">
                                            <div class="comparison-header-item">{{ $type->name }}</div>
                                            @foreach ($type->products as $product)
                                                <a class="comparison-header-item"
                                                    href="{{ route('products.show', ['productType' => $type->slug, 'product' => $product->slug]) }}">
                                                    <img src="{{ asset(isset($product->images[0]) ? "storage/{$product->images[0]}" : 'assets/img/content/product-1.jpg') }}"
                                                        alt="">
                                                    <p>{{ $product->name }}</p>
                                                </a>
                                            @endforeach
                                        </div>

                                        @foreach ($type->attributes as $attribute)
                                            <div class="comparison-row">
                                                <div class="comparison-cell characteristic">{{ $attribute->name }}</div>
                                                @foreach ($type->products as $product)
                                                    <div class="comparison-cell">
                                                        {{ $product->attributeValues->where('attribute.id', $attribute->id)->first()->value->value ?? '-' }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach

                                        <div class="comparison-row">
                                            <div class="comparison-cell characteristic">Цена</div>
                                            @foreach ($type->products as $product)
                                                <div class="comparison-cell">
                                                    @isset($product->price)
                                                        @isset($product->discount_price)
                                                            {!! $product->getFormattedDiscountPrice() !!}₽
                                                            <div class="catalog__old-price">
                                                                {!! $product->getFormattedPrice() !!}₽
                                                            </div>
                                                        @else
                                                            {!! $product->getFormattedPrice() !!}₽
                                                        @endisset
                                                    @else
                                                        По запросу
                                                    @endisset
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        @include('products.components.recently-watched')
        @include('components.frequent-questions')
    @endsection
</div>
