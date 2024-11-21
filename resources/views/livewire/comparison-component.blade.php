<div class="tabs">
    @if (count($productTypes))
        <ul class="tabs__menu tabs-menu scroll">
            @foreach ($productTypes as $type)
                <li class="tabs-menu__item category-btn">
                    <a href="#type-{{ $type->slug }}" class="tabs-menu__link">{{ $type->name }}</a>
                </li>
            @endforeach
        </ul>

        @foreach ($productTypes as $type)
            <div id="type-{{ $type->slug }}" class="tabs__content tabs-content">
                <div class="tabs-info">

                    <div class="comparison-table-wrapper" id="comparison-table-1">
                        <div class="comparison-table">

                            <div class="comparison-header">
                                <div class="comparison-header-item">{{ $type->name }}</div>
                                @foreach ($type->products as $product)
                                    <div class="comparison-header-item"
                                        href="{{ route('products.show', ['productType' => $type->slug, 'product' => $product->slug]) }}">
                                        <img src="{{ asset(isset($product->images[0]) ? "storage/{$product->images[0]}" : 'assets/img/content/product-1.jpg') }}"
                                            alt="">
                                        <p>{{ $product->name }}</p>
                                    </div>
                                @endforeach
                            </div>

                            @foreach ($type->attributes as $attribute)
                                <div class="comparison-row">
                                    <div class="comparison-cell characteristic">{{ $attribute->name }}</div>

                                    @foreach ($type->products as $product)
                                        <div class="comparison-cell">
                                            {{ $product->attributeValues->where('attribute.id', $attribute->id)->first()->value->value ?? '-' }}
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach

                            <div class="comparison-row">
                                <div class="comparison-cell characteristic">Цена</div>

                                @foreach ($type->products as $product)
                                    <div class="comparison-cell">
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
                                @endforeach
                            </div>

                            <div class="comparison-row">
                                <div class="comparison-cell characteristic">-</div>

                                @foreach ($type->products as $product)
                                    <div class="comparison-cell">
                                        <button class="btn" wire:click="delete({{ $product->id }})">Удалить</button>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="comparison-empty-comparison">
            <p>Страница сравнений пока что пуста!</p>
            <p>Вы можете добавить в неё новые товары из <a href="{{ route('catalog') }}">каталога</a>!</p>
        </div>
    @endif
</div>
