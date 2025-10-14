<footer class="wrap-footer">
    <div class="wrap-footer-top">
        <div class="footer-content footer-top">
            <a class="footer-top__logo logo" href="{{ route('home') }}"><img src="{{ asset('img/logo.svg') }}"
                    alt="ruCaf"></a>
            <div class="footer-top__info info">
                @foreach ($phoneNumbers as $phoneNumber)
                    <div class="info__item">
                        <div class="info__icon"><i class="icon-phone"></i></div>
                        <div class="info__content">
                            <a href="tel:{{ $phoneNumber->formattedLinkNumber() }}"
                                class="info__title">{{ $phoneNumber->formattedNumber() }}</a>
                            <div class="info__data">{!! $phoneNumber->data !!}</div>
                        </div>
                    </div>
                @endforeach
                <div class="info__item">
                    <button class="info__btn btn" type="button" data-fancybox data-src="#form-price">Звонок
                        специалиста</button>
                </div>
            </div>
            <nav class="footer-top__footer-menu footer-wrap-menu">
                <button class="footer-menu-btn btn footer-menu-btn--menu" type="button"><i
                        class="icon-menu1"></i><span>Меню</span></button>
                <a class="footer-menu-btn btn footer-menu-btn--catalog" data-menu="#catalog-menu"><span>Каталог
                        товаров</span></a>
                <ul class="footer-menu">
                    <li class="footer-menu__item"><a href="{{ route('catalog') }}" class="footer-menu__link">Каталог</a>
                    </li>
                    @foreach ($pages as $page)
                        <li class="footer-menu__item"><a href="{{ route('page', ['page' => $page->slug]) }}"
                                class="footer-menu__link">{{ $page->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
    <div class="wrap-footer-bottom">
        <div class="footer-content footer-bottom">
            <div class="footer-bottom__copy footer-copy">
                <a href="{{ route('privacy') }}" class="footer-copy__link"><i class="icon-form"></i><span>Обработка
                        данных</span></a>
                <div class="footer-copy__copy">Copyright <br>&copy;2022</div>
            </div>
            <nav class="footer-bottom__wrap-footer-bottom-menu">
                <ul class="footer-bottom-menu">
                    @foreach ($productTypes as $type)
                        <li class="footer-bottom-menu__item">
                            <a href="{{ route('product-types.index', ['productType' => $type]) }}"
                                class="footer-bottom-menu__link">
                                {{ $type->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
</footer>
