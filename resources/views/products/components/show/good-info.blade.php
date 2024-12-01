<div class="good-info">
    {{-- <div class="good-data">
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
    </div> --}}
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

    <livewire:product-actions :product="$product" />

</div>
