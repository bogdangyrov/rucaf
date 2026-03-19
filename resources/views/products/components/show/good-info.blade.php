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
    <div class="specs-grid">
        @foreach ($product->attributeValues->take(5) as $attributeValue)
            <div class="spec-item">
                <span class="spec-name">{{ $attributeValue->attribute->name }}</span>
                <span class="spec-dots"></span>
                <span class="spec-value">{{ $attributeValue->value->value }}</span>
            </div>
        @endforeach
    </div>
    <div class="good-actions">
        <a class="good-actions__btn-all" href="#chars" data-tab-index="0"><i class="icon-arrow3"></i><span>Все
                характеристики</span></a>
        @isset($product->article)
            <div class="good-actions__article">Артикул: <span>{{ $product->article }}</span></div>
        @endisset
    </div>

    <livewire:product-actions :product="$product" />

</div>
