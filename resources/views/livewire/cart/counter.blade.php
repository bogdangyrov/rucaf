<div class="cart-item__quantity">
    <button class="btn btn--border cart-item__quantity-btn" wire:click="decrement">-</button>
    <input type="number" class="cart-item__quantity-input" value="{{ $quantity }}" min="1" max="100">
    <button class="btn btn--border cart-item__quantity-btn" wire:click="increment">+</button>
</div>
