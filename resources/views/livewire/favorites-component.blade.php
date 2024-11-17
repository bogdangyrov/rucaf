<div>
    @if (count($products))
        <div class="wrap-catalog">
            <div class="catalog">
                @foreach ($products as $product)
                    <livewire:product-item :product="$product" />
                @endforeach
            </div>
        </div>
    @else
        <div class="cart-empty-cart">
            <p>Избранные товары отсутствуют!</p>
            <p>Вы можете добавить в неё новые товары из каталога!</p>
        </div>
    @endif
</div>
