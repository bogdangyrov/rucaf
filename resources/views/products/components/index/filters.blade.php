<div class="wrap-filters">
    <button class="filter-btn btn" type="button"><i class="icon-filter"></i><span>Фильтрация</span></button>
    <button class="filter-btn-second btn" type="button"><i class="icon-filter"></i><span>Фильтрация</span></button>
    <form class="w-filters scroll">
        <input type="text" hidden name="page-size" value="{{ $filter->pageSize }}">
        <input type="text" hidden name="sort-by" value="{{ $filter->sortBy }}">
        <input type="text" hidden name="show-products" value="{{ $filter->showProducts }}">
        @if (count($categories) > 0)
            <div class="filter-category">
                <div class="filter-category__title">Категория</div>
                <div class="filter-category__wrap-list wrap-category-list">
                    <div class="filter-category__list category-list open filters">
                        @foreach ($categories as $category)
                            <div class="filters__item {{ $filter->category->slug === $category->slug ? 'active' : '' }}"
                                style="margin-inline-start: 10px">
                                <label class="category-list__item filters__title"
                                    style="font-weight: 500; margin-bottom: 10px">
                                    <a class="category-list__link"
                                        href="{{ route('categories.index', ['productType' => $type, 'category' => $category]) }}">
                                        {{ $category->name }}
                                    </a>
                                </label>
                                <div class="category-list__subcategories">
                                    @foreach ($category->subcategories as $subcategory)
                                        <a class="category-list__item"
                                            href="{{ route('products.index', ['productType' => $type, 'category' => $category, 'subcategory' => $subcategory]) }}">
                                            <input type="checkbox" class="category-list__checkbox"
                                                @checked($subcategory->slug === $filter->subcategory?->slug) @disabled($subcategory->products_count === 0)>
                                            <span class="category-list__txt">{{ $subcategory->name }}
                                                <span
                                                    class="category-list__numbs">({{ $subcategory->products_count }})</span>
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @isset($attributes)
            <div class="filters scroll">
                @foreach ($attributes as $attribute)
                    @if (count($attribute->values) > 1)
                        <div class="filters__item" id="filter-item-{{ $attribute->id }}" data-loaded="0">
                            <div class="filters__title">
                                <div style="width:90%">{{ $attribute->name }}</div>
                            </div>
                            <div class="filters__list filters-list">
                                @foreach ($attribute->values as $index => $value)
                                    <label class="filters-list__item">
                                        <input type="checkbox" class="filters-list__checkbox"
                                            name="{{ $attribute->slug }}[]" value="{{ $value->slug }}"
                                            id="filter-{{ $attribute->id }}" data-filter-id="{{ $value->slug }}"
                                            @checked($filter->inAttributeValues($attribute->slug, $value->slug)) @disabled($value->products_count === 0)>
                                        <span class="filters-list__txt">{{ $value->value }}
                                            <span class="filters-list__numbs">({{ $value->products_count }})</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach


                @if ($maxPrice && $maxPrice !== $minPrice)
                    <div class="filters__item filters__item--prices">
                        <div class="filters__title">Цена, руб.</div>
                        <div class="filters__block">
                            <div class="filters-range" id="slider-range" data-min="{{ $minPrice }}"
                                data-max="{{ $maxPrice }}"></div>
                            <div class="filters__prices prices-inputs">
                                <div class="prices-inputs__input">
                                    <input type="number" class="slider-value" id="min-price" data-index="0"
                                        name="min-price" min="{{ $minPrice }}" max="{{ $maxPrice }}"
                                        value="{{ $filter->priceRange ? $filter->priceRange['0'] : $minPrice }}"
                                        placeholder=" ">
                                    <label for="min-price">От</label>
                                </div>
                                <div class="prices-inputs__input">
                                    <input type="number" class="slider-value" id="max-price" data-index="1"
                                        name="max-price" min="{{ $minPrice }}" max="{{ $maxPrice }}"
                                        value="{{ $filter->priceRange ? $filter->priceRange['1'] : $maxPrice }}"
                                        placeholder=" ">
                                    <label for="max-price">До</label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            <button class="btn">Применить</button>
        @endisset
    </form>
</div>
<script>
    window.currentProductTypeId = {{ $filter->productType->id }};
    window.currentCategoryId = {{ $filter->category?->id ?? 'null' }};
    window.currentSubcategoryId = {{ $filter->subcategory?->id ?? 'null' }};
</script>
