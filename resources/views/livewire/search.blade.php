<div>
    <div class="search">
        <input type="search" class="search__input" id="search1" placeholder=" " wire:model.live="search">
        <label for="search1" class="search__label">Поиск по сайту</label>
        <div class="search__btn"><i class="icon-search"></i></div>
        @if (isset($products))
            <div class="search-results">
                <ul class="search-results__list">
                    @if (count($products))
                        @foreach ($products as $product)
                            <li class="search-results__item">
                                <a href="{{ route('products.show', ['productType' => $product->category->productType, 'category' => $product->category, 'subcategory' => $product->subcategory, 'product' => $product->slug]) }}"
                                    class="search-results__link">{{ $product->name }}</a>
                            </li>
                        @endforeach
                    @else
                        <li class="search-results__item">
                            <div class="search-results__link-not-found">По вашему запросу ничего не найдено
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        @endif
    </div>
</div>
