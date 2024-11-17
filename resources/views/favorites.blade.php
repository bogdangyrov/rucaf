@extends('layouts.master')

@section('content')
    <style>
        .favorites-page {
            font-family: 'Source Sans 3';
            border-bottom: 1px solid #E4E4E4;

            .catalog {
                display: block;
            }

            @media only screen and (min-width: 601px) {
                .catalog {
                    display: flex;
                }
            }
        }

        .favorites-page__header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #E4E4E4;
        }
    </style>
    <div class="wrap">
        <div class="wrap">
            <div class="content">
                <div class="favorites-page">
                    <div class="favorites-page__header title">
                        <h1>Избранные</h1>
                    </div>

                    <livewire:favorites-component />
                </div>
            </div>
        </div>

        @include('products.components.recently-watched')
        @include('components.frequent-questions')
    @endsection
</div>
