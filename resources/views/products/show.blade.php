@extends('layouts.master')

@section('content')
    <div class="wrap wrap--light-gray">
        <div class="content">
            <div class="bread">
                <a href="/" class="bread__link">Главная</a>
                <span class="bread__sep"><i class="icon-arrow1"></i></span>

                <a href="/catalog" class="bread__link">Каталог</a>
                <span class="bread__sep"><i class="icon-arrow1"></i></span>

                <a href="{{ route('products', ['productType' => $type->slug]) }}"
                    class="bread__link">{{ $type->name }}</a>
                <span class="bread__sep"><i class="icon-arrow1"></i></span>

                <a class="bread__link active">{{ $product->name }}</a>
            </div>
            <div class="title title--inline">
                <h1>{{ $product->name }}</h1>
                <span class="title__sale">Новинка</span>
            </div>
        </div>
    </div>
    <div class="wrap">
        <div class="page content">
            <div class="page-product">
                <div class="w-page-product">
                    <div class="goods-wrap-slider">
                        <div class="goods-slider">
                            <div class="goods-slider__item">
                                <a href="{{ asset('assets/img/content/product-1.jpg') }}" class="goods-slider__link"
                                    data-fancybox="goods"><img src="{{ asset('assets/img/content/product-1.jpg') }}"
                                        alt="" class="goods-slider__img"></a>
                            </div>
                            <div class="goods-slider__item">
                                <a href="{{ 'assets/img/content/img-18.png' }}" class="goods-slider__link"
                                    data-fancybox="goods"><img src="{{ 'assets/img/content/img-18.png' }}" alt=""
                                        class="goods-slider__img"></a>
                            </div>
                        </div>
                        <div class="thumbs-slider">
                            <div class="thumbs-slider__item"><img src="{{ asset('assets/img/content/product-1.jpg') }}"
                                    alt="" class="thumbs-slider__img"></div>
                            <div class="thumbs-slider__item"><img src="{{ 'assets/img/content/img-18.png' }}" alt=""
                                    class="thumbs-slider__img"></div>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="tabs">
                            <ul class="tabs__menu tabs-menu scroll">
                                <li class="tabs-menu__item"><a href="#desc" class="tabs-menu__link">Описание</a></li>
                                <li class="tabs-menu__item"><a href="#how-buy" class="tabs-menu__link">Как заказать</a></li>
                                <li class="tabs-menu__item"><a href="#pay" class="tabs-menu__link">Оплата</a></li>
                                <li class="tabs-menu__item"><a href="#delivery" class="tabs-menu__link">Доставка</a></li>
                                <li class="tabs-menu__item"><a href="#garanty" class="tabs-menu__link">Гарантия и
                                        возврат</a></li>
                            </ul>
                            <div id="desc" class="tabs__content tabs-content">
                                <div class="tabs-txt">
                                    <p>Предварительные выводы неутешительны: повышение уровня гражданского сознания говорит
                                        о возможностях модели развития. Внезапно, сделанные на базе интернет-аналитики
                                        выводы преданы социально-демократической анафеме.</p>
                                </div>
                                <div class="tabs-info">
                                    <div class="wrap-good-chars">
                                        <div class="good-chars-title">Технические характеристики</div>
                                        <table class="good-chars">
                                            @foreach ($product->attributeValues as $attributeValue)
                                                <tr>
                                                    <th><span>{{ $attributeValue->attribute->name }}</span></th>
                                                    <td><span>{{ $attributeValue->value->value }}</span></td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="docs">
                                        <a href="#" class="docs__item docs__item--pdf">
                                            <i class="docs__icon icon-list1"></i>
                                            <div class="docs__content">
                                                <div class="docs__title">Технический каталог</div>
                                                <div class="docs__format"><span>2,14 Мб</span><span>PDF</span></div>
                                            </div>
                                        </a>
                                        <a href="#" class="docs__item docs__item--pdf">
                                            <i class="docs__icon icon-list1"></i>
                                            <div class="docs__content">
                                                <div class="docs__title">Техническое описание и Инструкция по эксплуатации
                                                </div>
                                                <div class="docs__format"><span>0,70 Мб</span><span>PDF</span></div>
                                            </div>
                                        </a>
                                        <a href="#" class="docs__item docs__item--doc">
                                            <i class="docs__icon icon-list2"></i>
                                            <div class="docs__content">
                                                <div class="docs__title">Опросный лист</div>
                                                <div class="docs__format"><span>0,03 Мб</span><span>DOC</span></div>
                                            </div>
                                        </a>
                                        <a href="#" class="docs__item docs__item--jpg">
                                            <i class="docs__icon icon-list3"></i>
                                            <div class="docs__content">
                                                <div class="docs__title">Сертификат</div>
                                                <div class="docs__format"><span>0,27 Мб</span><span>JPG</span></div>
                                            </div>
                                        </a>
                                        <a href="#" class="docs__item docs__item--jpg">
                                            <i class="docs__icon icon-list3"></i>
                                            <div class="docs__content">
                                                <div class="docs__title">Сертификат соответствия</div>
                                                <div class="docs__format"><span>0,19 Мб</span><span>JPG</span></div>
                                            </div>
                                        </a>
                                        <a href="#" class="docs__item docs__item--jpg">
                                            <i class="docs__icon icon-list3"></i>
                                            <div class="docs__content">
                                                <div class="docs__title">Каталог электронных расцепителей для выключателей
                                                    пр-ва АО Контактор г. Ульяновск</div>
                                                <div class="docs__format"><span>0,39 Мб</span><span>JPG</span></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div id="how-buy" class="tabs__content tabs-content">
                                <div class="tabs-txt">
                                    <p>Как заказать</p>
                                    <p>Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты.
                                        Заглавных приставка продолжил она текстов, ручеек текст великий злых. Знаках,
                                        своего! Строчка реторический безопасную, рукописи взгляд скатился взобравшись власти
                                        послушавшись?</p>
                                </div>
                            </div>
                            <div id="pay" class="tabs__content tabs-content">
                                <div class="tabs-txt">
                                    <p>Оплата</p>
                                    <p>Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты.
                                        Заглавных приставка продолжил она текстов, ручеек текст великий злых. Знаках,
                                        своего! Строчка реторический безопасную, рукописи взгляд скатился взобравшись власти
                                        послушавшись?</p>
                                </div>
                            </div>
                            <div id="delivery" class="tabs__content tabs-content">
                                <div class="tabs-txt">
                                    <p>Доставка</p>
                                    <p>Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты.
                                        Заглавных приставка продолжил она текстов, ручеек текст великий злых. Знаках,
                                        своего! Строчка реторический безопасную, рукописи взгляд скатился взобравшись власти
                                        послушавшись?</p>
                                </div>
                            </div>
                            <div id="garanty" class="tabs__content tabs-content">
                                <div class="tabs-txt">
                                    <p>Гарантия и возврат</p>
                                    <p>Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты.
                                        Заглавных приставка продолжил она текстов, ручеек текст великий злых. Знаках,
                                        своего! Строчка реторический безопасную, рукописи взгляд скатился взобравшись власти
                                        послушавшись?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="good-info">
                    <div class="good-data">
                        <div class="good-data__title">Номинальный ток, А</div>
                        <div class="good-data__choice good-choice">
                            <label class="good-choice__item">
                                <input type="radio" class="good-choice__check" name="amperage">
                                <span class="good-choice__txt">1000</span>
                            </label>
                            <label class="good-choice__item">
                                <input type="radio" class="good-choice__check" name="amperage" checked>
                                <span class="good-choice__txt">1500</span>
                            </label>
                        </div>
                    </div>
                    <table class="good-chars">
                        @foreach ($product->attributeValues as $attributeValue)
                            <tr>
                                <th><span>{{ $attributeValue->attribute->name }}</span></th>
                                <td><span>{{ $attributeValue->value->value }}</span></td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="good-actions">
                        <a class="good-actions__btn-all" href="#desc" data-tab-index="0"><i
                                class="icon-arrow3"></i><span>Все характеристики</span></a>
                        <div class="good-actions__article">Артикул: <span>9957</span></div>
                    </div>
                    <div class="wrap-good-card theiaStickySidebar">
                        <div class="good-card">
                            <div class="good-card__prices">
                                <div class="good-card__price">{{ $product->price }}₽</div>
                                <div class="good-card__old-price">{{ $product->price }}₽</div>
                            </div>
                            <div class="good-card__wrap-actions">
                                <div class="good-card__actions">
                                    <input type="text" class="good-card__numb" value="1 шт">
                                    <button class="good-card__add-basket btn" type="button">В корзину</button>
                                </div>
                                <button class="good-card__one-click btn btn--gray" type="button">Заказать в 1
                                    клик</button>
                            </div>
                        </div>
                        <div class="good-card-actions">
                            <button class="good-card-actions__btn" type="button" name="add-wishlist__btn"
                                data-id="{{ $product->id }}"><i class="icon-fav"></i><span>В избранное</span></button>
                            <button class="good-card-actions__btn" type="button"><i
                                    class="icon-compare"></i><span>Сравнение</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wrap wrap--coop">
        <div class="coop faq content">
            <div class="coop__left">
                <div class="title">
                    <h2>С нами сотрудничают, <br>потому что выгодно</h2>
                </div>
                <div class="coop__txt">
                    <p>Имеется спорная точка зрения, гласящая примерно следующее: активно развивающиеся страны третьего
                        мира, вне зависимости от их уровня, должны быть описаны максимально подробно. В своём стремлении
                        улучшить пользовательский опыт мы упускаем, что некоторые особенности внутренней политики призваны к
                        ответу!</p>
                </div>
                <div class="faq__actions faq-actions">
                    <div class="faq-actions__item">
                        <button class="faq-actions__btn btn" type="button" data-fancybox data-src="#form-price">Звонок
                            специалиста</button>
                    </div>
                    <div class="faq-actions__item">
                        <div class="faq__info faq-info">
                            <div class="faq-info__icon"><i class="icon-phone"></i></div>
                            <div class="faq-info__content">
                                <a href="tel:88007700890" class="faq-info__title">8 (800) 770-08-90</a>
                                <div class="faq-info__data">с 09:00 до 20:00</div>
                            </div>
                        </div>
                        <div class="faq__hidden-info hidden-info faq-info" style="display: none;">
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
                                <button class="hidden-info__btn btn" type="button" data-fancybox=""
                                    data-src="#form-price">Звонок специалиста</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="coop__right">
                <div class="coop__img"><img src="./img/logo-big.svg" alt=""></div>
            </div>
        </div>
    </div>

    <section class="wrap wrap--hot">
        <div class="content">
            <div class="title">
                <h2>Сопутствующие товары</h2>
            </div>
            <div class="wrap-catalog scroll">
                <div class="catalog">
                    <div class="catalog__item">
                        <div class="catalog__wrap-img">
                            <a class="catalog__img" href="#"><img src="./img/content/img-7.png"
                                    alt=""></a>
                            <div class="catalog__wrap-actions">
                                <div class="catalog__stocks catalog-stocks">
                                    <div class="catalog-stocks__sale">-30%</div>
                                </div>
                                <div class="catalog__actions catalog-actions">
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn catalog-actions__btn--added"><i
                                                class="icon-fav"></i></div>
                                    </div>
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn"><i class="icon-compare"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="catalog__content" href="#">
                            <div class="catalog__price">340 000₽</div>
                            <div class="catalog__title">Электродвигатель MTF-311-8</div>
                        </a>
                        <div class="catalog__order catalog-order">
                            <button class="catalog-order__btn btn" type="button" data-fancybox="" data-src="#order">В
                                корзину</button>
                        </div>
                    </div>
                    <div class="catalog__item catalog__item--request">
                        <div class="catalog__wrap-img">
                            <a class="catalog__img" href="#"><img src="./img/content/img-16.png"
                                    alt=""></a>
                            <div class="catalog__wrap-actions">
                                <div class="catalog__actions catalog-actions">
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn"><i class="icon-fav"></i></div>
                                    </div>
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn catalog-actions__btn--added"><i
                                                class="icon-compare"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="catalog__content" href="#">
                            <div class="catalog__price">По запросу</div>
                            <div class="catalog__title">ВА55-43-344730-00УХЛ3 1600А 660В</div>
                        </a>
                        <div class="catalog__order catalog-order">
                            <button class="catalog-order__btn btn" type="button" data-fancybox=""
                                data-src="#form-price">Запросить стоимость</button>
                        </div>
                    </div>
                    <div class="catalog__item catalog__item--not-available">
                        <div class="catalog__wrap-img">
                            <a class="catalog__img" href="#"><img src="./img/content/img-10.png"
                                    alt=""></a>
                            <div class="catalog__wrap-actions">
                                <div class="catalog__stocks catalog-stocks">
                                    <div class="catalog-stocks__sale">-30%</div>
                                </div>
                                <div class="catalog__actions catalog-actions">
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn"><i class="icon-fav"></i></div>
                                    </div>
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn"><i class="icon-compare"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="catalog__content" href="#">
                            <div class="catalog__price">2 490₽</div>
                            <div class="catalog__title">Пульт управления XAC-A6913Y (6 кнопок, 2 скорости + СТОП + КЛЮЧ)
                            </div>
                        </a>
                        <div class="catalog__order catalog-order">
                            <button class="catalog-order__btn btn" type="button">Нет в наличии</button>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <div class="catalog__wrap-img">
                            <a class="catalog__img" href="#"><img src="./img/content/img-6.png"
                                    alt=""></a>
                            <div class="catalog__wrap-actions">
                                <div class="catalog__stocks catalog-stocks">
                                    <div class="catalog-stocks__sale catalog-stocks__sale--new">Новинка</div>
                                </div>
                                <div class="catalog__actions catalog-actions">
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn"><i class="icon-fav"></i></div>
                                    </div>
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn"><i class="icon-compare"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="catalog__content" href="#">
                            <div class="catalog__price">15 700₽</div>
                            <div class="catalog__title">Редуктор 1Ц2У-100 / Ц2У-100</div>
                        </a>
                        <div class="catalog__order catalog-order">
                            <button class="catalog-order__btn btn" type="button" data-fancybox="" data-src="#order2">В
                                корзину</button>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <div class="catalog__wrap-img">
                            <a class="catalog__img" href="#"><img src="./img/content/img-8.png"
                                    alt=""></a>
                            <div class="catalog__wrap-actions">
                                <div class="catalog__stocks catalog-stocks">
                                    <div
                                        class="catalog-stocks__sale catalog-stocks__sale--new catalog-stocks__sale--new-yellow">
                                        Новинка</div>
                                </div>
                                <div class="catalog__actions catalog-actions">
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn"><i class="icon-fav"></i></div>
                                    </div>
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn"><i class="icon-compare"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="catalog__content" href="#">
                            <div class="catalog__price">98 000₽</div>
                            <div class="catalog__title">Таль электрическая ТЭ 320-511 (3,2 тонны 6 метров)</div>
                        </a>
                        <div class="catalog__order catalog-order">
                            <button class="catalog-order__btn btn" type="button" data-fancybox=""
                                data-src="#form-price3">Запросить стоимость</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="wrap wrap--hot">
        <div class="content">
            <div class="title">
                <h2>Вы недавно смотрели</h2>
            </div>
            <div class="wrap-catalog scroll">
                <div class="catalog">
                    <div class="catalog__item">
                        <div class="catalog__wrap-img">
                            <a class="catalog__img" href="#"><img src="./img/content/img-7.png"
                                    alt=""></a>
                            <div class="catalog__wrap-actions">
                                <div class="catalog__stocks catalog-stocks">
                                    <div class="catalog-stocks__sale">-30%</div>
                                </div>
                                <div class="catalog__actions catalog-actions">
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn catalog-actions__btn--added"><i
                                                class="icon-fav"></i></div>
                                    </div>
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn"><i class="icon-compare"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="catalog__content" href="#">
                            <div class="catalog__price">340 000₽</div>
                            <div class="catalog__title">Электродвигатель MTF-311-8</div>
                        </a>
                        <div class="catalog__order catalog-order">
                            <button class="catalog-order__btn btn" type="button" data-fancybox="" data-src="#order">В
                                корзину</button>
                        </div>
                    </div>
                    <div class="catalog__item catalog__item--request">
                        <div class="catalog__wrap-img">
                            <a class="catalog__img" href="#"><img src="./img/content/img-16.png"
                                    alt=""></a>
                            <div class="catalog__wrap-actions">
                                <div class="catalog__actions catalog-actions">
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn"><i class="icon-fav"></i></div>
                                    </div>
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn catalog-actions__btn--added"><i
                                                class="icon-compare"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="catalog__content" href="#">
                            <div class="catalog__price">По запросу</div>
                            <div class="catalog__title">ВА55-43-344730-00УХЛ3 1600А 660В</div>
                        </a>
                        <div class="catalog__order catalog-order">
                            <button class="catalog-order__btn btn" type="button" data-fancybox=""
                                data-src="#form-price">Запросить стоимость</button>
                        </div>
                    </div>
                    <div class="catalog__item catalog__item--not-available">
                        <div class="catalog__wrap-img">
                            <a class="catalog__img" href="#"><img src="./img/content/img-10.png"
                                    alt=""></a>
                            <div class="catalog__wrap-actions">
                                <div class="catalog__stocks catalog-stocks">
                                    <div class="catalog-stocks__sale">-30%</div>
                                </div>
                                <div class="catalog__actions catalog-actions">
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn"><i class="icon-fav"></i></div>
                                    </div>
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn"><i class="icon-compare"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="catalog__content" href="#">
                            <div class="catalog__price">2 490₽</div>
                            <div class="catalog__title">Пульт управления XAC-A6913Y (6 кнопок, 2 скорости + СТОП + КЛЮЧ)
                            </div>
                        </a>
                        <div class="catalog__order catalog-order">
                            <button class="catalog-order__btn btn" type="button">Нет в наличии</button>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <div class="catalog__wrap-img">
                            <a class="catalog__img" href="#"><img src="./img/content/img-6.png"
                                    alt=""></a>
                            <div class="catalog__wrap-actions">
                                <div class="catalog__stocks catalog-stocks">
                                    <div class="catalog-stocks__sale catalog-stocks__sale--new">Новинка</div>
                                </div>
                                <div class="catalog__actions catalog-actions">
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn"><i class="icon-fav"></i></div>
                                    </div>
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn"><i class="icon-compare"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="catalog__content" href="#">
                            <div class="catalog__price">15 700₽</div>
                            <div class="catalog__title">Редуктор 1Ц2У-100 / Ц2У-100</div>
                        </a>
                        <div class="catalog__order catalog-order">
                            <button class="catalog-order__btn btn" type="button" data-fancybox="" data-src="#order2">В
                                корзину</button>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <div class="catalog__wrap-img">
                            <a class="catalog__img" href="#"><img src="./img/content/img-8.png"
                                    alt=""></a>
                            <div class="catalog__wrap-actions">
                                <div class="catalog__stocks catalog-stocks">
                                    <div
                                        class="catalog-stocks__sale catalog-stocks__sale--new catalog-stocks__sale--new-yellow">
                                        Новинка</div>
                                </div>
                                <div class="catalog__actions catalog-actions">
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn"><i class="icon-fav"></i></div>
                                    </div>
                                    <div class="catalog-actions__item">
                                        <div class="catalog-actions__btn"><i class="icon-compare"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="catalog__content" href="#">
                            <div class="catalog__price">98 000₽</div>
                            <div class="catalog__title">Таль электрическая ТЭ 320-511 (3,2 тонны 6 метров)</div>
                        </a>
                        <div class="catalog__order catalog-order">
                            <button class="catalog-order__btn btn" type="button" data-fancybox=""
                                data-src="#form-price3">Запросить стоимость</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="wrap">
        <div class="content">
            <div class="faq">
                <div class="faq__left">
                    <div class="faq__title title">
                        <h2>Частые вопросы</h2>
                    </div>
                    <div class="faq__content">
                        <p>Мы собрали частые вопросы от партнеров и покупателей. Если не нашли нужную информацию оставьте
                            заявку на звонок специалиста или обратитесь в службу поддержки.</p>
                    </div>
                    <div class="faq__actions faq-actions">
                        <div class="faq-actions__item">
                            <div class="faq__info faq-info">
                                <div class="faq-info__icon"><i class="icon-phone"></i></div>
                                <div class="faq-info__content">
                                    <a href="tel:88007700890" class="faq-info__title">8 (800) 770-08-90</a>
                                    <div class="faq-info__data">с 09:00 до 20:00</div>
                                </div>
                            </div>
                            <div class="faq__hidden-info hidden-info faq-info" style="display: none;">
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
                                    <button class="hidden-info__btn btn" type="button" data-fancybox=""
                                        data-src="#form-price">Звонок специалиста</button>
                                </div>
                            </div>
                        </div>
                        <div class="faq-actions__item">
                            <div class="faq__info faq-info">
                                <div class="faq-info__icon"><i class="icon-mail"></i></div>
                                <div class="faq-info__content">
                                    <a href="mailto:info-order@rucaf.ru" class="faq-info__title">info-order@rucaf.ru</a>
                                    <div class="faq-info__data">написать</div>
                                </div>
                            </div>
                            <div class="faq__hidden-info hidden-info faq-info" style="display: none;">
                                <div class="hidden-info__item">
                                    <div class="faq-info__icon"><i class="icon-mail"></i></div>
                                    <div class="faq-info__content">
                                        <a href="mailto:site-review@rucaf.ru"
                                            class="faq-info__title">site-review@rucaf.ru</a>
                                        <div class="faq-info__data">Вопросы по сайту</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="faq-actions__item">
                            <button class="faq-actions__btn btn btn--gray" type="button" data-fancybox=""
                                data-src="#form-price">Звонок специалиста</button>
                        </div>
                    </div>
                </div>
                <div class="faq__right">
                    <div class="q-a">
                        <div class="q-a__item">
                            <div class="q-a__title">Есть ли у вас акции для постоянных клиентов?</div>
                            <div class="q-a__content">
                                <p>Есть ли у вас акции для постоянных клиентов?</p>
                            </div>
                        </div>
                        <div class="q-a__item">
                            <div class="q-a__title">Вы можете доставить заказ в другую страну?</div>
                            <div class="q-a__content">
                                <p>Учитывая ключевые сценарии поведения, понимание сути ресурсосберегающих технологий не
                                    даёт нам иного выбора, кроме определения новых предложений. Внезапно, тщательные
                                    исследования конкурентов, вне зависимости от их уровня, должны быть разоблачены. Ясность
                                    нашей позиции очевидна: постоянное информационно-пропагандистское обеспечение нашей
                                    деятельности предопределяет высокую востребованность своевременного выполнения
                                    сверхзадачи.</p>
                            </div>
                        </div>
                        <div class="q-a__item">
                            <div class="q-a__title">Куда обращаться по вопросам сотрудничества?</div>
                            <div class="q-a__content">
                                <p>Куда обращаться по вопросам сотрудничества?</p>
                            </div>
                        </div>
                        <div class="q-a__item">
                            <div class="q-a__title">Есть ли скидки при заказе ОПТом?</div>
                            <div class="q-a__content">
                                <p>Есть ли скидки при заказе ОПТом?</p>
                            </div>
                        </div>
                        <div class="q-a__item">
                            <div class="q-a__title">Могу ли я самостоятельно забрать заказ?</div>
                            <div class="q-a__content">
                                <p>Могу ли я самостоятельно забрать заказ?</p>
                            </div>
                        </div>
                        <div class="q-a__item">
                            <div class="q-a__title">Можете ли выступить посредником в закупке оборудования?</div>
                            <div class="q-a__content">
                                <p>Можете ли выступить посредником в закупке оборудования?</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    {{--  <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#add-to-cart').click(function() {
                let productId = $(this).attr('data-id');
                let count = $('#items-count').val();

                $.ajax({
                    type: 'post',
                    url: '{{ route('cart.add') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        product_id: productId,
                        count: count
                    },
                    success: function(data) {
                        console.log(data);
                        $('#grid-include').html(data.html);
                    }
                });
            });

            $.ajax({
                type: 'get',
                url: '{{ route('favorites.check') }}',
                data: {
                    product_id: $('[name="add-wishlist__btn"]').attr('data-id'),
                },
                success: function(data) {
                    if (data.status == 'success') {
                        $('[name="add-wishlist__btn"] > i').addClass('favorites');
                        $('[name="add-wishlist__btn"] > span').text('В избранном');

                    }
                }
            });

            $('[name="add-wishlist__btn"]').click(function() {
                if ($('[name="add-wishlist__btn"] > i').hasClass('favorites') === true) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('favorites.remove') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            product_id: $(this).attr('data-id'),
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                $('[name="add-wishlist__btn"] > i').removeClass('favorites');
                                $('[name="add-wishlist__btn"] > span').text('В избранное');

                            }
                        }
                    });
                } else {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('favorites.add') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            product_id: $(this).attr('data-id'),
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                $('[name="add-wishlist__btn"] > i').addClass('favorites');
                                $('[name="add-wishlist__btn"] > span').text('В избранном');
                            }
                        }
                    });
                }
            });
        });
    </script> --}}
@endsection
