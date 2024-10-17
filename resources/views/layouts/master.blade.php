<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seo->title ?? '' }}</title>
    <meta name="description" content="{{ $seo->description ?? '' }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/jScrollPane/jquery.jscrollpane.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/mmenu/mmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/fancybox/dist/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @yield('css')
</head>

<body>
    <div class="wrapper wrapper--page">
        @include('layouts.components.header')

        @yield('content')

        @include('layouts.components.footer')
    </div>

    @include('layouts.components.catalog-menu')

    <div style="display: none;" class="modal modal--bottom" id="form-price-ok2">
        <div class="modal-wrap">
            <div class="modal-title"><span>Звонок специалиста</span><button class="modal-close-btn" type="button"
                    data-fancybox-close><i class="icon-close1"></i></button></div>
            <div class="modal-content scroll">
                <div class="msg-ok">
                    <div class="msg-ok__icon"><i class="icon-check1"></i></div>
                    <div class="msg-ok__content">
                        <p><b>Заявка отправлена</b></p>
                        <p>Вам перезвонят в рабочее время <br>(Вт с 09:00).</p>
                    </div>
                </div>
                <div class="msg-actions">
                    <button class="msg-actions__btn btn btn--gray" type="button" data-fancybox-close>Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <div style="display: none;" class="modal modal--bottom" id="form-price-ok">
        <div class="modal-wrap">
            <div class="modal-title"><span>Звонок специалиста</span><button class="modal-close-btn" type="button"
                    data-fancybox-close><i class="icon-close1"></i></button></div>
            <div class="modal-content scroll">
                <div class="msg-ok">
                    <div class="msg-ok__icon"><i class="icon-check1"></i></div>
                    <div class="msg-ok__content">
                        <p><b>Заявка отправлена</b></p>
                        <p>Вам перезвонят в течение 15 минут.</p>
                    </div>
                </div>
                <div class="msg-actions">
                    <button class="msg-actions__btn btn btn--gray" type="button" data-fancybox-close>Закрыть</button>
                </div>
            </div>
        </div>
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
</body>

</html>
