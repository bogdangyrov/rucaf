<div class="w-products">
    <div class="sorting">
        @include('products.components.index.search-links')
        <div class="filters-wrap">
            @include('products.components.index.active-filters')
            @include('products.components.index.sort-list-wrap')
        </div>
    </div>

    <div class="wrap-catalog">
        <div class="catalog">
            @if ($products->count() > 0)
                @foreach ($products as $product)
                    <livewire:product-item :product="$product" />
                @endforeach
            @else
                <p>Нечего не найдено. Возможно вы выбрали слишком много фильтров.
                    @php
                        switch (Route::currentRouteName()) {
                            case 'product-types.index':
                                $clearFiltersRoute = route(Route::currentRouteName(), [
                                    'productType' => $filter->productType,
                                ]);
                                break;
                            case 'categories.index':
                                $clearFiltersRoute = route(Route::currentRouteName(), [
                                    'productType' => $filter->productType,
                                    'category' => $filter->category,
                                ]);
                                break;
                            case 'products.index':
                                $clearFiltersRoute = route(Route::currentRouteName(), [
                                    'productType' => $filter->productType,
                                    'category' => $filter->category,
                                    'subcategory' => $filter->subcategory,
                                ]);
                                break;
                            default:
                                $clearFiltersRoute = '#';
                                break;
                        }
                    @endphp
                    <a href="{{ $clearFiltersRoute }}">Очистить фильтры.</a>
                </p>
            @endif
        </div>
        @include('products.components.index.pagination')
    </div>
</div>
