<div class="w-sort-list">
    <div class="sort-list-title">{{ $sortTitle }}:</div>
    <div class="sort-list">
        @foreach ($sortList as $name => $slug)
            @php
                $query = $originalQuery;
                $query['page'] = 1;
                $query[$sortSlug] = $slug;
            @endphp
            @php
                switch (Route::currentRouteName()) {
                    case 'product-types.index':
                        $sortUrl = route(
                            Route::currentRouteName(),
                            array_merge(['productType' => $filter->productType], $query),
                        );
                        break;
                    case 'categories.index':
                        $sortUrl = route(
                            Route::currentRouteName(),
                            array_merge(
                                ['productType' => $filter->productType, 'category' => $filter->category],
                                $query,
                            ),
                        );
                        break;
                    case 'products.index':
                        $sortUrl = route(
                            Route::currentRouteName(),
                            array_merge(
                                [
                                    'productType' => $filter->productType,
                                    'category' => $filter->category,
                                    'subcategory' => $filter->subcategory,
                                ],
                                $query,
                            ),
                        );
                        break;
                    default:
                        $sortUrl = '#';
                        break;
                }
            @endphp
            <a class="sort-list__item {{ $filter->$attr == $slug ? 'sort-list__item--active' : '' }}"
                href="{{ $sortUrl }}">
                <span class="sort-list__txt">{{ $name }}</span>
            </a>
        @endforeach
    </div>
</div>
