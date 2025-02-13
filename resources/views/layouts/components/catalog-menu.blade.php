<nav id="catalog-menu" class="wrap-catalog-menu">
    <div class="w-catalog-menu">
        <ul class="catalog-menu catalog-menu--parent custom-scroll">
            @foreach ($types as $type)
                <li class="catalog-menu__item">
                    <span class="catalog-menu__link">
                        {{ $type->name }}
                        <span class="submenu-toggle icon-arrow1"></span>
                    </span>
                    @if (!empty($type->categories))
                        <ul class="catalog-menu catalog-menu--sub-menu catalog-menu--sub-menu-lvl1 custom-scroll">
                            @foreach ($type->categories as $category)
                                <li class="catalog-menu__item">
                                    <span class="catalog-menu__link">
                                        {{ $category->name }}
                                        <span class="submenu-toggle  icon-arrow1"></span>
                                    </span>
                                    @if (!empty($category->subcategories))
                                        <ul
                                            class="catalog-menu catalog-menu--sub-menu catalog-menu--sub-menu-lvl2 custom-scroll">
                                            @foreach ($category->subcategories as $subcategory)
                                                <li class="catalog-menu__item">
                                                    <a href="{{ route('products.index', ['productType' => $type['slug'], 'category' => [$category->slug], 'subcategory' => [$subcategory['slug']]]) }}"
                                                        class="catalog-menu__link">
                                                        {{ $subcategory->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</nav>
