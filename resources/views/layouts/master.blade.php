<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.components.seo')
    <link rel="stylesheet" href="{{ asset('assets/libs/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/jScrollPane/jquery.jscrollpane.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/mmenu/mmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/fancybox/dist/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
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

    <script src="{{ asset('assets/libs/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/libs/slick/slick.min.js') }}"></script>
    <script src="{{ asset('assets/libs/mmenu/mmenu.js') }}"></script>
    <script src="{{ asset('assets/libs/jScrollPane/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('assets/libs/jScrollPane/jquery.jscrollpane.min.js') }}"></script>
    <script src="{{ asset('assets/libs/fancybox/dist/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sticky/ResizeSensor.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sticky/theia-sticky-sidebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/my/common.js') }}"></script>
    @yield('js')
    @livewireScripts
</body>

</html>
