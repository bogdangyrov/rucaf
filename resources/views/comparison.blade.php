@extends('layouts.master')

@section('content')
    <style>
        /* Основной контейнер */
        .comparison-page {
            padding: 20px;
            display: flex;
            flex-direction: column;
            border-bottom: 1px solid #E4E4E4;

            .tabs {
                padding-top: 20px !important;
            }
        }

        .comparison-page__header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #E4E4E4;
        }

        /* Навигация по категориям */
        .comparison-categories {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .category-btn {
            background: #F3F3F3;
            border-radius: 4px;
            color: #000;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.3s, color 0.3s;
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
                height: 25px;
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

        .comparicom-header__close-btn {
            position: relative;
            top: -140px;
            left: 112px;
            color: #EAEAEA;
        }

        .comparicom-header__close-btn:hover,
        .comparicom-header__close-btn:active {
            color: #E4B900
        }

        .comparison-empty-comparison {
            text-align: center;
            padding: 40px;
            font-size: 30px;
        }

        .tabs__content:not(:first-of-type) {
            display: none;
        }
    </style>

    <div class="wrap">
        <div class="content">
            <div class="comparison-page">

                <div class="comparison-page__header title">
                    <h1>Сравнение товаров</h1>
                </div>

                <livewire:comparison-component>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Livewire.hook('commit', ({
                component,
                commit,
                respond,
                succeed,
                fail
            }) => {
                succeed(({
                    snapshot,
                    effect
                }) => {
                    console.log('commit.succeed');
                    $('.tabs__content').hide();
                    $('.tabs__content:first').show();
                    $('.tabs-menu__item:first').addClass('active');

                    $('.tabs-menu__link').click(function(e) {
                        e.preventDefault();

                        $('.tabs-menu__item').removeClass('active');
                        $(this).parent().addClass('active');

                        $('.tabs__content').hide();
                        var activeTab = $(this).attr('href');
                        $(activeTab).show();
                    });
                })
            })
        });
    </script>

    @include('products.components.recently-watched')
    @include('components.frequent-questions')
    @include('components.cities')
@endsection
