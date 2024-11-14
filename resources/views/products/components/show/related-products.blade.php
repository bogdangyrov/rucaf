<section class="wrap wrap--hot">
    <div class="content">
        <div class="title">
            <h2>Сопутствующие товары</h2>
        </div>
        <div class="wrap-catalog scroll">
            <div class="catalog">
                @foreach ($relatedProducts as $product)
                    @include('products.components.index.product-item')
                @endforeach
            </div>
        </div>
    </div>
</section>
