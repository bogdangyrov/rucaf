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
        <div class="favorites-empty">
            <p>Избранные товары отсутствуют!</p>
            <p>Вы можете добавить в неё новые товары из <a href="{{ route('catalog') }}">каталога</a>!</p>
        </div>
    @endif
</div>
