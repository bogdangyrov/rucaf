@extends('layouts.mail')

@section('content')
    <div>
        <h1>Отправлен запрос на звонок специалиста</h1>

        <div class="email-content">
            @include('mail.components.client')
            @include('mail.components.comment')
        </div>
    </div>
@endsection
