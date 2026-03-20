<div class="wrap-catalog-menu">
    <div class="w-catalog-menu">
        <div class="catalog-mega-menu">
            <ul class="catalog-types custom-scroll">
                @foreach ($types as $type)
                    <li class="catalog-type-item @if ($loop->first) active @endif"
                        data-type-id="{{ $type->id }}">
                        <a href="{{ route('product-types.index', ['productType' => $type]) }}" class="catalog-type-link">
                            @isset($type->image)
                                <img src="{{ asset('storage/' . $type->image) }}" alt="{{ $type->name }}"
                                    class="catalog-type-link__thumb">
                            @endisset
                            <span>{{ $type->name }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="catalog-details-panel custom-scroll">
                @foreach ($types as $type)
                    @if (!empty($type->categories))
                        <div class="catalog-detail @if ($loop->first) active @endif"
                            data-for="{{ $type->id }}">
                            @foreach ($type->categories as $category)
                                <div class="catalog-category">
                                    <div class="catalog-category__title">{{ $category->name }}</div>
                                    @if (!empty($category->subcategories))
                                        <ul class="catalog-subcategories">
                                            @foreach ($category->subcategories as $subcategory)
                                                <li>
                                                    <a
                                                        href="{{ route('products.index', ['productType' => $type['slug'], 'category' => $category->slug, 'subcategory' => $subcategory['slug']]) }}">
                                                        {{ $subcategory->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="catalog-mobile-panel">
            <button type="button" class="catalog-mobile-panel__back js-catalog-mobile-close">
                <span class="icon-arrow1"></span>
                <span>Назад</span>
            </button>
            <ul class="catalog-mobile-menu custom-scroll">
                @foreach ($types as $type)
                    <li class="catalog-mobile-type">
                        <button type="button" class="catalog-mobile-type__btn js-catalog-mobile-toggle">
                            <span style="display: flex;  align-items: center;">
                                @isset($type->image)
                                    <img src="{{ asset('storage/' . $type->image) }}" alt="{{ $type->name }}"
                                        class="catalog-mobile-type__thumb">
                                @endisset
                                {{ $type->name }}</span>
                            <span class="catalog-mobile-type__arrow icon-arrow1"></span>
                        </button>
                        @if (!empty($type->categories))
                            <div class="catalog-mobile-type__body">
                                @foreach ($type->categories as $category)
                                    <div class="catalog-mobile-category">
                                        @if (!empty($category->subcategories))
                                            <button type="button"
                                                class="catalog-mobile-category__btn js-catalog-mobile-toggle">
                                                <span>{{ $category->name }}</span>
                                                <span class="catalog-mobile-type__arrow icon-arrow1"></span>
                                            </button>
                                            <div class="catalog-mobile-category__body">
                                                @foreach ($category->subcategories as $subcategory)
                                                    <a href="{{ route('products.index', ['productType' => $type['slug'], 'category' => $category->slug, 'subcategory' => $subcategory['slug']]) }}"
                                                        class="catalog-mobile-subcategory">
                                                        {{ $subcategory->name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="catalog-mobile-category__title">{{ $category->name }}</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
