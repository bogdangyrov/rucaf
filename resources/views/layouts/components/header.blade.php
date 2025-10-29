<header class="wrap-header">
    <div class="header">
        <div class="header__left">
            <a class="header__catalog-btn btn btn--white js-open-menu" href="#catalog-menu"
                data-menu="#catalog-menu">Каталог товаров</a>
            <div class="header__faq-actions faq-actions">
                <div class="faq-actions__item">
                    <div class="faq-actions__icon"><i class="icon-geo"></i></div>
                    <div class="faq-actions__content">
                        <div class="faq-actions__title">
                            <livewire:city-name />
                        </div>
                        <button class="faq-actions__data" type="button" data-fancybox=""
                            data-src="#city">изменить</button>
                    </div>
                </div>
                <div class="faq-actions__item">
                    <div class="faq-info">
                        <div class="faq-info__icon"><i class="icon-phone"></i></div>
                        <div class="faq-info__content">
                            <a href="tel:{{ $phoneNumbers->first()->formattedLinkNumber() }}"
                                class="faq-info__title">{{ $phoneNumbers->first()->formattedNumber() }}</a>
                            <div class="faq-info__data">{!! $phoneNumbers->first()->data !!}</div>
                        </div>
                    </div>
                    <div class="hidden-info faq-info">
                        @for ($i = 1; $i < count($phoneNumbers); $i++)
                            <div class="hidden-info__item">
                                <div class="faq-info__icon"><i class="icon-phone"></i></div>
                                <div class="faq-info__content">
                                    <a href="tel:{{ $phoneNumbers[$i]->formattedLinkNumber() }}"
                                        class="faq-info__title">{{ $phoneNumbers[$i]->formattedNumber() }}</a>
                                    <div class="faq-info__data">{!! $phoneNumbers[$i]->data !!}</div>
                                </div>
                            </div>
                        @endfor
                        <div class="hidden-info__item">
                            <button class="hidden-info__btn btn" type="button" data-fancybox
                                data-src="#request-call">Звонок специалиста</button>
                        </div>
                    </div>
                </div>
                <div class="faq-actions__item">
                    <div class="faq-info">
                        <div class="faq-info__icon"><i class="icon-mail"></i></div>
                        <div class="faq-info__content">
                            <a href="mailto:{{ $emails->first()->email }}"
                                class="faq-info__title">{{ $emails->first()->email }}</a>
                            <div class="faq-info__data">{{ $emails->first()->data }}</div>
                        </div>
                    </div>
                    <div class="hidden-info faq-info">
                        @for ($i = 1; $i < count($emails); $i++)
                            <div class="hidden-info__item">
                                <div class="faq-info__icon"><i class="icon-mail"></i></div>
                                <div class="faq-info__content">
                                    <a href="mailto:{{ $emails[$i]->email }}"
                                        class="faq-info__title">{{ $emails[$i]->email }}</a>
                                    <div class="faq-info__data">{{ $emails[$i]->data }}</div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('home') }}" class="header__logo logo">
            <picture class="logo__picture">
                <source srcset="{{ asset('img/logo.svg') }}" media="(min-width: 601px)">
                <img src="{{ asset('img/logo-mini.svg') }}" alt="ruCaf" class="logo__img">
            </picture>
        </a>
        <div class="header__right">
            <ul class="header__menu header-menu">
                @foreach ($pages as $page)
                    <li class="header-menu__item"><a href="{{ route('page', ['page' => $page->slug]) }}"
                            class="header-menu__link">{{ $page->title }}</a>
                    </li>
                @endforeach
            </ul>

            <livewire:header-actions />
        </div>

        <livewire:confirm-city />
    </div>
    <div class="header-bottom">
        <ul class="header-bottom__menu category-menu">
            @foreach ($productTypes->take(5) as $type)
                <li class="category-menu__item"><a href="{{ route('product-types.index', ['productType' => $type]) }}"
                        class="category-menu__link">{{ $type['name'] }}</a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="wrap-menu-mobile scroll">
        <div class="header-func">
            <div class="header-func__item">
                <div class="header-func__icon"><i class="icon-geo"></i></div>
                <div class="header-func__content">
                    <div class="header-func__title">
                        <livewire:city-name />
                    </div>
                    <button class="header-func__data" type="button" data-fancybox data-src="#city">изменить</button>
                </div>
            </div>
            <div class="header-func__item">
                <div class="header-func__icon"><i class="icon-phone"></i></div>
                <div class="header-func__content">
                    <a class="header-func__title"
                        href="tel:{{ $phoneNumbers->first()->formattedLinkNumber() }}">{{ $phoneNumbers->first()->formattedNumber() }}</a>
                    <div class="header-func__data">{!! $phoneNumbers->first()->data !!}</div>
                </div>
            </div>
            <div class="header-func__item">
                <div class="header-func__icon"><i class="icon-mail"></i></div>
                <div class="header-func__content">
                    <a class="header-func__title"
                        href="mailto:{{ $emails->first()->email }}">{{ $emails->first()->email }}</a>
                    <div class="header-func__data">{{ $emails->first()->data }}</div>
                </div>
            </div>
        </div>
        <a class="header-catalog-btn btn" href="#catalog-menu">Каталог</a>
        <nav class="wrap-header-menu">
            <ul class="header-menu">
                @foreach ($pages as $page)
                    <li class="header-menu__item"><a href="{{ route('page', ['page' => $page->slug]) }}"
                            class="header-menu__link">{{ $page->title }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>

</header>

<div style="display: none;" class="modal modal--no-price modal--bottom" id="city">
    <div class="modal-wrap">
        <div class="modal-title"><span>Изменить город</span><button class="modal-close-btn" type="button"
                data-fancybox-close><i class="icon-close1"></i></button></div>
        <livewire:city-search />
    </div>
</div>
