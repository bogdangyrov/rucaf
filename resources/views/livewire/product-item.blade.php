<div class="catalog__item">

    <div class="catalog__wrap-img">
        <a class="catalog__img"
            href="{{ route('products.show', ['productType' => $product->category->productType, 'category' => $product->category, 'subcategory' => $product->subcategory, 'product' => $product]) }}"><img
                src="
                @if (isset($product->images[0])) {{ asset("storage/{$product->images[0]}") }}
                @elseif (isset($product->subcategory->images[0]))
                {{ asset("storage/{$product->subcategory->images[0]}") }}
                @else {{ asset('img/content/product-1.jpg') }} @endif"
                alt="{{ $product->name }}"></a>
        <div class="catalog__wrap-actions">

            @if ($product->is_new)
                <div class="catalog-stocks__sale catalog-stocks__sale--new catalog-stocks__sale--new-yellow">
                    Новинка</div>
                &nbsp;
            @endif

            @if (isset($product->price) && isset($product->discount_price))
                <div class="catalog__stocks catalog-stocks">
                    <div class="catalog-stocks__sale">
                        -{{ $product->discountPercentage() }}%
                    </div>
                </div>
            @endif

            <div class="catalog__actions catalog-actions">
                <div class="catalog-actions__item">
                    @if ($inFavorites)
                        <div class="catalog-actions__btn catalog-actions__btn--added" wire:click="deleteFromFavorites">
                            <i class="icon-fav"></i>
                        </div>
                    @else
                        <div class="catalog-actions__btn" wire:click="addToFavorites"><i class="icon-fav"></i></div>
                    @endif
                </div>
                <div class="catalog-actions__item">
                    @if ($inComparison)
                        <div class="catalog-actions__btn catalog-actions__btn--added" wire:click="deleteFromComparison">
                            <i class="icon-compare"></i>
                        </div>
                    @else
                        <button class="catalog-actions__btn " wire:click="addToComparison"><i
                                class="icon-compare"></i></button>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <a class="catalog__content"
        href="{{ route('products.show', ['productType' => $product->category->productType, 'category' => $product->category, 'subcategory' => $product->subcategory, 'product' => $product]) }}">
        <div class="catalog__price">
            @isset($product->price)
                @isset($product->discount_price)
                    {!! $product->getFormattedDiscountPrice() !!}₽
                    <div class="catalog__old-price">
                        {!! $product->getFormattedPrice() !!}₽
                    </div>
                @else
                    {!! $product->getFormattedPrice() !!}₽
                @endisset
            @else
                По запросу
            @endisset
        </div>
        <div class="catalog__title">{{ $product->name }}</div>
    </a>

    <div class="catalog__order catalog-order">
        @if ($quantity)
            <a class="catalog-order__btn--added btn" href="{{ route('cart') }}">В корзине</a>
        @else
            <button class="catalog-order__btn btn" type="button" wire:click='addToCart'>В корзину</button>
        @endif
    </div>

    @include('products.components.modal-request-price')
</div>
