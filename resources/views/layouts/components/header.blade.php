<header class="wrap-header">
    <div class="header">
        <div class="header__left">
            <a class="header__catalog-btn btn btn--white js-open-menu" href="#catalog-menu"
                data-menu="#catalog-menu">Каталог товаров</a>
            <div class="header__faq-actions faq-actions">
                <div class="faq-actions__item">
                    <div class="faq-actions__icon"><i class="icon-geo"></i></div>
                    <div class="faq-actions__content">
                        <div class="faq-actions__title">Санкт-Петербург</div>
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
                <li class="header-menu__item"><a href="#" class="header-menu__link">О компании</a></li>
                <li class="header-menu__item"><a href="#" class="header-menu__link">Доставка и оплата</a>
                </li>
                <li class="header-menu__item"><a href="#" class="header-menu__link">Контакты</a></li>
            </ul>
            <div class="header__actions actions">
                <button class="actions__item actions__item--white actions__item--search" type="button" data-fancybox
                    data-src="#search">
                    <span class="actions__btn"><i class="icon-search"></i></span>
                </button>
                <a href="#" class="actions__item">
                    <span class="actions__btn"><i class="icon-compare"></i></span>
                    <span class="actions__numbs">99</span>
                </a>
                <a href="#" class="actions__item">
                    <span class="actions__btn"><i class="icon-fav"></i></span>
                    <span class="actions__numbs">11</span>
                </a>
                <a href="#" class="actions__item">
                    <span class="actions__btn"><i class="icon-basket"></i></span>
                    <span class="actions__numbs">3</span>
                </a>
                <a class="actions__item actions__item--white actions__item--menu">
                    <span class="actions__btn"><i class="icon-menu1"></i></span>
                </a>
            </div>
        </div>
        <div class="wrap-msg-city">
            <div class="w-msg-city">
                <div class="msg-city">
                    <div class="msg-city__icon"><i class="icon-geo"></i></div>
                    <div class="msg-city__content">
                        <div class="msg-city__title">Санкт-Петербург</div>
                        <div class="msg-city__data">Это ваш город?</div>
                    </div>
                </div>
                <div class="msg-city__actions">
                    <button class="msg-city__btn btn" type="button">Подтвердить</button>
                    <button class="msg-city__link" type="button" data-fancybox data-src="#city">Изменить</button>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <ul class="header-bottom__menu category-menu">
            <li class="category-menu__item"><a href="#" class="category-menu__link">Автоматические
                    выключатели</a></li>
            <li class="category-menu__item"><a href="#" class="category-menu__link">Вакуумные
                    контакторы</a></li>
            <li class="category-menu__item"><a href="#" class="category-menu__link">Тельферы
                    электрические</a></li>
            <li class="category-menu__item"><a href="#" class="category-menu__link">Радиоуправление</a>
            </li>
            <li class="category-menu__item"><a href="#" class="category-menu__link">Лебедки
                    электрические</a></li>
        </ul>
    </div>
    <div class="wrap-menu-mobile scroll">
        <div class="header-func">
            <div class="header-func__item">
                <div class="header-func__icon"><i class="icon-geo"></i></div>
                <div class="header-func__content">
                    <div class="header-func__title">Санкт-Петербург</div>
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
                <li class="header-menu__item"><a href="#" class="header-menu__link">О компании</a></li>
                <li class="header-menu__item"><a href="#" class="header-menu__link">Доставка и
                        оплата</a></li>
                <li class="header-menu__item"><a href="#" class="header-menu__link">Контакты</a></li>
            </ul>
        </nav>
    </div>
</header>
