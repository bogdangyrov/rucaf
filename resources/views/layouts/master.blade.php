<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="yandex-verification" content="f0f5e0c422ada7d3" />
    <link rel="icon" href="{{ asset('favicon.ico')}}" type="image/x-icon">

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

    <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function(m,e,t,r,i,k,a){
                m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();
                for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
                k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
            })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=110258181',
        'ym');
            ym(110258181, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", referrer: document.referrer, url: location.href, accurateTrackBounce:true, trackLinks:true});
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/110258181"
        style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
</body>

</html>
