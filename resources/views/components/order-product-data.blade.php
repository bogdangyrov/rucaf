<div class="order__data order-data">
    <div class="order-data__title">{{ $product->name }}</div>
    <div class="order-data__product-data product-data">
        @isset($product->article)
            <div class="product-data__item">
                <div class="product-data__title">Артикул:</div>
                <div class="product-data__content">{{ $product->article }}</div>
            </div>
        @endisset

        @isset($product->dimensions)
            <div class="product-data__item">
                <div class="product-data__title">Габариты ШхВхГ, мм:</div>
                <div class="product-data__content">{{ $product->dimensions }}</div>
            </div>
        @endisset

        @isset($product->mass)
            <div class="product-data__item">
                <div class="product-data__title">Масса, кг:</div>
                <div class="product-data__content">{{ $product->mass }}</div>
            </div>
        @endisset
    </div>
</div>
