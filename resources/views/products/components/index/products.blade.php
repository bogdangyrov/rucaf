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
                    @include('products.components.index.product-item')
                @endforeach
            @else
                <p>Нечего не найдено. Возможно вы выбрали слишком много фильтров. <a
                        href="{{ route('products.index', ['productType' => $type]) }}">Очистить фильтры.</a></p>
            @endif
        </div>

        @include('products.components.index.pagination')

    </div>
</div>
