@extends('layouts.master')

@section('css')
    @vite('resources/css/pages/comparison.css')
@endsection

@section('content')
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

    @include('products.components.recently-watched')
    @include('components.frequent-questions')
    @include('components.cities')
@endsection

@section('js')
    @vite('resources/js/pages/comparison.js')
@endsection
