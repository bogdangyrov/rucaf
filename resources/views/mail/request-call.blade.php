@extends('layouts.mail')

@section('content')
    <div>
        <h1>Отправлен запрос на звонок специалиста</h1>

        <div class="email-content">
            <section>
                <p><b>Клиент:</b> {{ $name }}, <a
                        href="tel:+{{ $phone->formatE164() }}">+{{ $phone->formatNational() }}</a>
                </p>
            </section>

            @isset($comment)
                <section>
                    <p><b>Комментарий: </b></p>
                    <p>{{ $comment }}</p>
                </section>
            @endisset
        </div>
    </div>
@endsection
