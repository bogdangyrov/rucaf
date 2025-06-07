<div>
    @if ($products->count())
        <div class="cart-items">
            @foreach ($products as $product)
                <div class="cart-item">
                    <a class="cart-item__image"
                        href="{{ route('products.show', ['productType' => $product->category->productType, 'category' => $product->category, 'subcategory' => $product->subcategory, 'product' => $product]) }}">
                        <img src="{{ asset(isset($product->subcategory->images[0]) ? "storage/{$product->subcategory->images[0]}" : 'img/content/product-1.jpg') }}"
                            alt="{{ $product->name }}">
                    </a>
                    <div class="cart-item__details">
                        <a class="cart-item__title"
                            href="{{ route('products.show', ['productType' => $product->category->productType, 'category' => $product->category, 'subcategory' => $product->subcategory, 'product' => $product]) }}">
                            {{ $product->name }}</a>
                        <div class="cart-item__price">
                            Цена:
                            @if (isset($product->discount_price))
                                {!! $product->getFormattedDiscountPrice() !!}₽
                                <div class="cart__old-price">
                                    {!! $product->getFormattedPrice() !!}₽
                                </div>
                            @elseif (isset($product->price))
                                {!! $product->getFormattedPrice() !!}₽
                            @else
                                По заказу
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
        <button class="btn" data-fancybox data-src="#request-cart">Оставить заявку</button>
    </div>
@else
    <div class="cart-empty-cart">
        <p>Ваша корзина пока что пуста!</p>
        <p>Вы можете добавить в неё новые товары из <a href="{{ route('catalog') }}">каталога</a>!</p>
    </div>
@endif
</div>
