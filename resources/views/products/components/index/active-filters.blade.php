<div class="filters-result scroll">
    @foreach ($filter->attributes as $attribute)
        @foreach ($attribute->values as $value)
            <div class="filters-result__item">
                <a href="{{ route('products.index', [
                    'productType' => $type->slug,
                    'category' => $filter->category,
                    'subcategory' => $filter->subcategory,
                    ...$filter->queryWithoutAttributeValue($attribute->slug, $value->slug),
                ]) }}"
                    class="filters-result__btn" type="button"><span>{{ $attribute->name }}: {{ $value->value }}
                    </span><i class="icon-close1"></i></a>
            </div>
        @endforeach
    @endforeach

    @if ($filter->priceRange)
        <div class="filters-result__item">
            <a href="{{ route('products.index', [
                'productType' => $type->slug,
                'category' => $filter->category,
                'subcategory' => $filter->subcategory,
                ...$filter->queryAttributes(),
            ]) }}"
                class="filters-result__btn" type="button"><span>Цена от {{ $filter->priceRange[0] }} до
                    {{ $filter->priceRange[1] }} руб.
                </span><i class="icon-close1"></i></a>
        </div>
    @endif

    @if ($filter->filtersExists())
        <div class="filters-result__item">
            <a class="filters-result__btn filters-result__btn--reset" type="button"
                href="{{ route('products.index', ['productType' => $type, 'category' => $filter->category, 'subcategory' => $filter->subcategory]) }}"><span>Сбросить
                    все</span><i class="icon-close1"></i></a>
        </div>
    @endif
</div>
