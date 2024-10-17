<nav id="catalog-menu" class="wrap-catalog-menu">
    <div class="w-catalog-menu">
        <ul class="catalog-menu catalog-menu--parent custom-scroll">
            @foreach ($types as $type)
                <li class="catalog-menu__item">
                    <a href="{{ route('products', ['productType' => $type->slug]) }}" class="catalog-menu__link">
                        {{ $type->name }}
                    </a>
                    @if (!empty($type->categories))
                        <ul class="catalog-menu catalog-menu--sub-menu catalog-menu--sub-menu-lvl1 custom-scroll">
                            @foreach ($type->categories as $category)
                                <li class="catalog-menu__item">
                                    <a href="{{ route('products', ['productType' => $type->slug, 'category' => $category->slug]) }}"
                                        class="catalog-menu__link">
                                        {{ $category->name }}
                                    </a>
                                    <!--ul class="catalog-menu catalog-menu--sub-menu catalog-menu--sub-menu-lvl2 custom-scroll">
                            <li class="catalog-menu__item"><span>Напряжение:</span></li>
                            <li class="catalog-menu__item"><a href="#" class="catalog-menu__link">Пункт 1</a></li>
                            <li class="catalog-menu__item"><a href="#" class="catalog-menu__link">Пункт 2</a></li>
                            <li class="catalog-menu__item"><a href="#" class="catalog-menu__link">Пункт 3</a></li>
                            <li class="catalog-menu__item"><a href="#" class="catalog-menu__link">Пункт 4</a></li>
                            <li class="catalog-menu__item"><a href="#" class="catalog-menu__link">Пункт 5</a></li>
                            <li class="catalog-menu__item"><span>Производитель:</span></li>
                            <li class="catalog-menu__item"><a href="#" class="catalog-menu__link">Пункт 6</a></li>
                            <li class="catalog-menu__item"><a href="#" class="catalog-menu__link">Пункт 7</a></li>
                            <li class="catalog-menu__item"><a href="#" class="catalog-menu__link">Пункт 8</a></li>
                            <li class="catalog-menu__item"><a href="#" class="catalog-menu__link">Пункт 9</a></li>
                        </ul-->
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
            <li class="catalog-menu__item"><a href="#" class="catalog-menu__link">Электрические тали и
                    тельферы</a></li>
        </ul>
    </div>
</nav>
