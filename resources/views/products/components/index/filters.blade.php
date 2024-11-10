<div class="wrap-filters">
    <button class="filter-btn btn" type="button"><i class="icon-filter"></i><span>Фильтрация</span></button>
    <button class="filter-btn-second btn" type="button"><i class="icon-filter"></i><span>Фильтрация</span></button>
    <form class="w-filters scroll">
        <input type="text" hidden name="page-size" value="{{ $filter->pageSize }}">
        <input type="text" hidden name="sort-by" value="{{ $filter->sortBy }}">
        <input type="text" hidden name="show-products" value="{{ $filter->showProducts }}">
        @if (count($categories) > 0)
            <div class="filter-category filters">
                <div class="filter-category__title">Категория</div>
                <div class="filter-category__wrap-list wrap-category-list">
                    <div class="filter-category__list category-list">
                        @foreach ($categories as $category)
                            <label class="category-list__item">
                                <input type="checkbox" class="category-list__checkbox" name="category[]"
                                    value="{{ $category->slug }}" @checked($filter->inCategories($category->slug))
                                    @disabled($category->products_count === 0)>
                                <span class="category-list__txt">{{ $category->name }} <span
                                        class="category-list__numbs">({{ $category->products_count }})</span></span>
                            </label>
                        @endforeach
                    </div>
                    <button class="filter-category__btn-more" type="button">Показать все</button>
                </div>
            </div>
        @endif
        <div class="filters scroll">
            @foreach ($attributes as $attribute)
                <div class="filters__item {{ $filter->attributeExists($attribute->slug) ? 'active' : '' }}">
                    <div class="filters__title">{{ $attribute->name }}</div>
                    <div class="filters__list filters-list">
                        @foreach ($attribute->values as $value)
                            <label class="filters-list__item">
                                <input type="checkbox" class="filters-list__checkbox" name="{{ $attribute->slug }}[]"
                                    value="{{ $value->slug }}" id="filter-{{ $attribute->id }}"
                                    data-filter-id="{{ $value->slug }}" @checked($filter->inAttributeValues($attribute->slug, $value->slug))
                                    @disabled($value->products_count === 0)>
                                <span class="filters-list__txt">{{ $value->value }} <span
                                        class="filters-list__numbs">({{ $value->products_count }})</span></span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="filters__item filters__item--prices">
                <div class="filters__title">Цена, руб.</div>
                <div class="filters__block">
                    <div class="filters-range" id="slider-range" data-min="{{ $minPrice }}"
                        data-max="{{ $maxPrice }}"></div>
                    <div class="filters__prices prices-inputs">
                        <div class="prices-inputs__input">
                            <input type="number" class="slider-value" id="min-price" data-index="0" name="min-price"
                                min="{{ $minPrice }}" max="{{ $maxPrice }}"
                                value="{{ $filter->priceRange ? $filter->priceRange['0'] : $minPrice }}"
                                placeholder=" ">
                            <label for="min-price">От</label>
                        </div>
                        <div class="prices-inputs__input">
                            <input type="number" class="slider-value" id="max-price" data-index="1" name="max-price"
                                min="{{ $minPrice }}" max="{{ $maxPrice }}"
                                value="{{ $filter->priceRange ? $filter->priceRange['1'] : $maxPrice }}"
                                placeholder=" ">
                            <label for="max-price">До</label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="filters__item filters__item--mass">
                <div class="filters__title">Масса, кг</div>
                <div class="filters__block">
                    <div class="filters-range" id="slider-range-mass"></div>
                    <div class="filters__prices prices-inputs">
                        <div class="prices-inputs__input">
                            <input type="text" class="slider-value" id="min-mass" data-index="0" value="0"
                                placeholder=" ">
                            <label for="min-mass">От</label>
                        </div>
                        <div class="prices-inputs__input">
                            <input type="text" class="slider-value" id="max-mass" data-index="1" value="1000"
                                placeholder=" ">
                            <label for="max-mass">До</label>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>
        <button class="btn">Применить</button>
    </form>
</div>
