@extends('layouts.master')

@section('content')
    <div class="wrap">
        <div class="content custom-page">
            {!! $page->html !!}
        </div>
    </div>
@endsection
