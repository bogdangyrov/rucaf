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
                            <a href="tel:88007700890" class="faq-info__title">8 (800) 770-08-90</a>
                            <div class="faq-info__data">с 09:00 до 20:00</div>
                        </div>
                    </div>
                    <div class="hidden-info faq-info">
                        <div class="hidden-info__item">
                            <div class="faq-info__icon"><i class="icon-phone"></i></div>
                            <div class="faq-info__content">
                                <a href="tel:88127003376" class="faq-info__title">8 (812) 700-33-76</a>
                                <div class="faq-info__data"><span>Офис</span> с 10:00 до 18:00</div>
                            </div>
                        </div>
                        <div class="hidden-info__item">
                            <div class="faq-info__icon"><i class="icon-phone"></i></div>
                            <div class="faq-info__content">
                                <a href="tel:84954300243" class="faq-info__title">8 (495) 430-02-43</a>
                                <div class="faq-info__data"><span>Главный склад</span> с 08:00 до 18:00</div>
                            </div>
                        </div>
                        <div class="hidden-info__item">
                            <button class="hidden-info__btn btn" type="button" data-fancybox
                                data-src="#form-price">Звонок специалиста</button>
                        </div>
                    </div>
                </div>
                <div class="faq-actions__item">
                    <div class="faq-info">
                        <div class="faq-info__icon"><i class="icon-mail"></i></div>
                        <div class="faq-info__content">
                            <a href="mailto:info-order@rucaf.ru" class="faq-info__title">info-order@rucaf.ru</a>
                            <div class="faq-info__data">Общие вопросы</div>
                        </div>
                    </div>
                    <div class="hidden-info faq-info">
                        <div class="hidden-info__item">
                            <div class="faq-info__icon"><i class="icon-mail"></i></div>
                            <div class="faq-info__content">
                                <a href="mailto:site-review@rucaf.ru" class="faq-info__title">site-review@rucaf.ru</a>
                                <div class="faq-info__data">Вопросы по сайту</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="/" class="header__logo logo">
            <picture class="logo__picture">
                <source srcset="{{ asset('assets/img/logo.svg') }}" media="(min-width: 601px)">
                <img src="{{ asset('assets/img/logo-mini.svg') }}" alt="ruCaf" class="logo__img">
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
            @foreach ($productTypes as $type)
                <li class="category-menu__item"><a href="{{ route('products.index', ['productType' => $type->slug]) }}"
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
                    <a class="header-func__title" href="tel:88007700890">8 (800) 770-08-90</a>
                    <div class="header-func__data"><span>Поддержка</span> с 09:00 до 20:00</div>
                </div>
            </div>
            <div class="header-func__item">
                <div class="header-func__icon"><i class="icon-mail"></i></div>
                <div class="header-func__content">
                    <a class="header-func__title" href="mailto:info-order@rucaf.ru">info-order@rucaf.ru</a>
                    <div class="header-func__data">Общие вопросы</div>
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
