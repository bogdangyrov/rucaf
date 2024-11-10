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
                <p>{!! $product->description !!}</p>
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
