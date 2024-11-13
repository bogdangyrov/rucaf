<div class="good-info">
    <div class="good-data">
        <div class="good-data__title">Номинальный ток, А</div>
        <div class="good-data__choice good-choice">
            <label class="good-choice__item">
                <input type="radio" class="good-choice__check" name="amperage">
                <span class="good-choice__txt">1000</span>
            </label>
            <label class="good-choice__item">
                <input type="radio" class="good-choice__check" name="amperage" checked>
                <span class="good-choice__txt">1500</span>
            </label>
        </div>
    </div>
    <table class="good-chars">
        @php
            $endFor = $product->attributeValues->count() < 5 ? $product->attributeValues->count() : 5;
        @endphp
        @for ($i = 0; $i < $endFor; $i++)
            <tr>
                <th><span>{{ $product->attributeValues[$i]->attribute->name }}</span></th>
                <td><span>{{ $product->attributeValues[$i]->value->value }}</span></td>
            </tr>
        @endfor
    </table>
    <div class="good-actions">
        <a class="good-actions__btn-all" href="#desc" data-tab-index="0"><i class="icon-arrow3"></i><span>Все
                характеристики</span></a>
        <div class="good-actions__article">Артикул: <span>9957</span></div>
    </div>
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
                    @livewire(Cart\AddButton::class, ['product' => $product])
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
            <button class="good-card-actions__btn" type="button" name="add-wishlist__btn"
                data-id="{{ $product->id }}"><i class="icon-fav"></i><span>В
                    избранное</span></button>
            <button class="good-card-actions__btn" type="button"><i
                    class="icon-compare"></i><span>Сравнение</span></button>
        </div>
    </div>
</div>
