<div>
    @if ($quantity)
        <a class="catalog-order__btn--added btn" href="{{ route('cart') }}">В корзине</a>
    @else
        <button class="catalog-order__btn btn" type="button" wire:click='addToCart'>В корзину</button>
    @endif
</div>
