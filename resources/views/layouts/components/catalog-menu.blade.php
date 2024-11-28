<nav id="catalog-menu" class="wrap-catalog-menu">
    <div class="w-catalog-menu">
        <ul class="catalog-menu catalog-menu--parent custom-scroll">
            @foreach ($types as $type)
                <li class="catalog-menu__item">
                    <a href="{{ route('products.index', ['productType' => $type->slug]) }}" class="catalog-menu__link">
                        {{ $type->name }}
                    </a>
                    @if (!empty($type->categories))
                        <ul class="catalog-menu catalog-menu--sub-menu catalog-menu--sub-menu-lvl1 custom-scroll">
                            @foreach ($type->categories as $category)
                                <li class="catalog-menu__item">
                                    <a href="{{ route('products.index', ['productType' => $type->slug, 'category' => [$category->slug]]) }}"
                                        class="catalog-menu__link">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</nav>
