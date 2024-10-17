<div class="w-products">
    <div class="sorting">
        @include('products.components.search-links')

        <div class="filters-wrap">
            @include('products.components.active-filters')
            @include('products.components.sort-list')
        </div>
    </div>

    <div class="wrap-catalog">
        <div class="catalog">
            @foreach ($products as $product)
                @include('products.components.product-item')
            @endforeach
        </div>

        @include('products.components.pagination')

    </div>
</div>
