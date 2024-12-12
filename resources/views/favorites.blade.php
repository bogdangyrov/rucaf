@extends('layouts.master')

@section('css')
    @vite('resources/css/pages/favorites.css')
@endsection

@section('content')
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
    @include('components.cities')
@endsection
