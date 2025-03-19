<div class="wrap wrap--main-catalog wrap--light-gray">
    <div class="content">
        <div class="wrap-main-catalog">
            <div class="main-catalog">
                @foreach ($productTypes as $type)
                    <a href="{{ route('products.index', ['productType' => $type, 'category' => $type->categories[0], 'subcategory' => $type->categories[0]->subcategories[0]]) }}"
                        class="main-catalog__item">
                        <div class="main-catalog__img"><img src="{{ asset('storage/' . $type->image) }}"
                                alt="Фото {{ $type->name }}">
                        </div>
                        <div class="main-catalog__title">{{ $type->name }}</div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
