<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="yandex-verification" content="f0f5e0c422ada7d3" />

    @include('layouts.components.seo')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('css')
    @livewireStyles
</head>

<body>
    <div class="wrapper wrapper--page">
        @include('layouts.components.header')

        @yield('content')

        @include('layouts.components.footer')
    </div>

    @include('layouts.components.catalog-menu')

    <div style="display: none;" class="modal modal--bottom" id="request-call">
        <livewire:modal-request-call />
    </div>

    <div class="overflow-bg"></div>

    @stack('js')
    @livewireScripts
</body>

</html>
