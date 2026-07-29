@extends('layouts.master')

@section('content')
    <div class="wrap">
        <div class="content custom-page">
            @include('components.breadcrumbs', [
                'items' => [
                    ['label' => 'Главная', 'url' => route('home')],
                    ['label' => $page->title],
                ],
            ])
            {!! $page->html !!}
        </div>
    </div>
@endsection
