<div class="wrap-good-card theiaStickySidebar">
    <div class="good-card">
        @isset($product->price)
            <div class="good-card__prices">
                @isset($product->discount_price)
                    <div class="good-card__price">{!! $product->getFormattedDiscountPrice() !!}₽
                    </div>
                    <div class="good-card__old-price">{!! $product->getFormattedPrice() !!}₽</div>
                @else
                    <div class="good-card__price">{!! $product->getFormattedPrice() !!}₽
                    </div>
                @endisset
            </div>
            <div class="good-card__wrap-actions">
                <form class="good-card__actions" wire:submit="addToCart">
                    @isset($quantity)
                        <a class="good-card__add-basket--added btn" href="{{ route('cart') }}">
                            В корзине</a>
                    @else
                        <input type="number" class="good-card__numb" placeholder="1 шт" wire:model="quantity">
                        <button class="good-card__add-basket btn" type="button" data-id="{{ $product->id }}"
                            wire:click="addToCart">
                            В корзину</button>
                    @endisset
                </form>
                <button class="good-card__one-click btn btn--gray" type="button">Заказать в 1
                    клик</button>
            </div>
        @else
            <div class="good-card__wrap-actions">
                <div class="good-card__actions">
                    <input type="number" class="good-card__numb" placeholder="1 шт">
                    <button class="good-card__add-basket btn" type="button">Запросить стоимость</button>
                </div>
                <button class="good-card__one-click btn btn--gray" type="button">Заказать в 1
                    клик</button>
            </div>
        @endisset
    </div>
    <div class="good-card-actions">
        @if ($inFavorites)
            <a class="good-card-actions__btn good-card-actions__btn-added" type="button" name="add-wishlist__btn"
                href="{{ route('favorites') }}"><i class="icon-fav"></i>
                <span>В избранном</span></a>
        @else
            <button class="good-card-actions__btn" type="button" name="add-wishlist__btn"
                wire:click="addToFavorites"><i class="icon-fav"></i>
                <span>В избранное</span></button>
        @endif

        @if ($inComparison)
            <a class="good-card-actions__btn good-card-actions__btn-added" type="button"
                href="{{ route('comparison') }}"><i class="icon-compare"></i>
                <span>В сравнении</span></a>
        @else
            <button class="good-card-actions__btn" type="button" wire:click="addToComparison"><i
                    class="icon-compare"></i>
                <span>Сравнение</span></button>
        @endif
    </div>
</div>
