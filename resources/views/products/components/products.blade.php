<div class="w-products">
    <div class="sorting">
        @include('products.components.search-links')

        <div class="filters-wrap">
            @include('products.components.active-filters')
            @include('products.components.sort-list-wrap')
        </div>
    </div>

    <div class="wrap-catalog">
        <div class="catalog">
            @if ($products->count() > 0)
                @foreach ($products as $product)
                    @include('products.components.product-item')
                @endforeach
            @else
                <p>Нечего не найдено. Возможно вы выбрали слишком много фильтров. <a
                        href="{{ route('products', ['productType' => $type]) }}">Очистить фильтры.</a></p>
            @endif
        </div>

        @include('products.components.pagination')

    </div>
</div>
