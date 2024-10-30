<div class="filters-result scroll">
    @foreach ($filter->categories as $category)
        <div class="filters-result__item">
            <a href="{{ route('products', [
                'productType' => $type->slug,
                'category' => $filter->queryWithoutCategory($category->slug),
                ...$filter->queryAttributes(),
            ]) }}"
                class="filters-result__btn" type="button"><span>Категории: {{ $category->name }}
                </span><i class="icon-close1"></i></a>
        </div>
    @endforeach

    @foreach ($filter->attributes as $attribute)
        @foreach ($attribute->values as $value)
            <div class="filters-result__item">
                <a href="{{ route('products', [
                    'productType' => $type->slug,
                    'category' => $filter->queryCategories(),
                    ...$filter->queryWithoutAttributeValue($attribute->slug, $value->slug),
                ]) }}"
                    class="filters-result__btn" type="button"><span>{{ $attribute->name }}: {{ $value->value }}
                    </span><i class="icon-close1"></i></a>
            </div>
        @endforeach
    @endforeach

    @if ($filter->filtersExists())
        <div class="filters-result__item">
            <a class="filters-result__btn filters-result__btn--reset" type="button"
                href="{{ route('products', ['productType' => $type]) }}"><span>Сбросить
                    все</span><i class="icon-close1"></i></a>
        </div>
    @endif
</div>
