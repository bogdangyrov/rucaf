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
        @foreach ($product->attributeValues->take(5) as $attributeValue)
            <tr>
                <th><span>{{ $attributeValue->attribute->name }}</span></th>
                <td><span>{{ $attributeValue->value->value }}</span></td>
            </tr>
        @endforeach
    </table>
    <div class="good-actions">
        <a class="good-actions__btn-all" href="#desc" data-tab-index="0"><i class="icon-arrow3"></i><span>Все
                характеристики</span></a>
        @isset($product->article)
            <div class="good-actions__article">Артикул: <span>{{ $product->article }}</span></div>
        @endisset
    </div>

    <livewire:product-actions :product="$product" />

</div>
