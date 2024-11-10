<div class="search-links">
    @foreach ($quickFilters as $quickFilter)
        <div class="search-links__item"><a
                href="{{ route('products.index', ['productType' => $type, $quickFilter->attribute->slug . '[]' => $quickFilter->value->slug]) }}"
                class="search-links__link
                {{ $filter->inAttributeValues($quickFilter->attribute->slug, $quickFilter->value->slug) ? 'active' : '' }}">
                {{ $quickFilter->name }}</a>
        </div>
    @endforeach
</div>
