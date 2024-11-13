<div>
    @if ($products->count())
        <div class="cart-items">
            @foreach ($products as $product)
                <div class="cart-item">
                    <div class="cart-item__image">
                        <img src="{{ asset(isset($product->images[0]) ? "storage/{$product->images[0]}" : 'assets/img/content/product-1.jpg') }}"
                            alt="{{ $product->name }}">
                    </div>
                    <div class="cart-item__details">
                        <h2 class="cart-item__title">{{ $product->name }}</h2>
                        <div class="cart-item__price">
                            Цена:
                            @isset($product->discount_price)
                                {!! $product->getFormattedDiscountPrice() !!}₽
                                <div class="cart__old-price">
                                    {!! $product->getFormattedPrice() !!}₽
                                </div>
                            @else
                                {!! $product->getFormattedPrice() !!}₽
                            @endisset
                        </div>
                        <div class="cart-item__quantity">
                            <button class="btn btn--border cart-item__quantity-btn"
                                wire:click.throttle.100ms="decrement({{ $product->id }})">-</button>
                            <input type="number" class="cart-item__quantity-input" value="{{ $product->quantity }}"
                                min="1" max="100" readonly>
                            <button class="btn btn--border cart-item__quantity-btn"
                                wire:click.throttle.100ms="increment({{ $product->id }})">+</button>
                        </div>
                    </div>
                    <div class="cart-item__remove">
                        <button class="btn btn--gray" wire:click="delete({{ $product->id }})">Удалить</button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="cart-summary">
            <p class="cart-summary__total">Всего: {!! \App\Models\Product::formatPrice($totalSum) !!}₽ <span
                    class="cart-summary__total-quantity">({{ $totalQuantity }} товаров)</span></p>
            <button class="btn">Оставить заявку</button>
        </div>
    @else
        <div class="cart-empty-cart">
            <p>Ваша корзина пока что пуста!</p>
            <p>Вы можете добавить в неё новые товары из каталога!</p>
        </div>
    @endif
</div>
