@extends('layouts.master')

@section('css')
    @vite('resources/css/pages/cart.css')
@endsection

@section('content')
    <div class="wrap">
        <div class="content">
            <div class="cart-page">
                <div class="cart-page__header title">
                    <h1>Корзина</h1>
                </div>

                <livewire:cart.cart-component />
            </div>
        </div>
    </div>

    <div style="display: none;" class="modal modal--bottom" id="request-cart">
        <livewire:modal-request-cart />
    </div>

    @include('products.components.recently-watched')
    @include('components.frequent-questions')
    @include('components.cities')
@endsection
