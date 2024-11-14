<form class="good-card__actions" wire:submit="addToCart">
    @isset($quantity)
        <a class="good-card__add-basket--added btn" href="{{ route('cart') }}">
            В корзине</a>
    @else
        <input type="number" class="good-card__numb" placeholder="1 шт" wire:model="quantity">
        <button class="good-card__add-basket btn" type="button" data-id="{{ $product->id }}" wire:click="addToCart">
            В корзину</button>
    @endisset
</form>
