<div>
    <h1>Тип: {{ $type->name }}</h1>
</div>
<form>
    <h2>Категории:</h2>
    <div>
        @foreach ($categories as $category)
            <div>
                <input type="checkbox" name="category" value="{{ $category->id }}" id="category-{{ $category->id }}">
                <label for="category-{{ $category->id }}">{{ $category->name }}</label>
            </div>
        @endforeach
    </div>
    <h3>Характеристики</h3>
    @foreach ($attributes as $attribute)
        <div>
            <p>{{ $attribute->name }}:</p>
            <div style="margin-left: 10px">
                @foreach ($attribute->values as $value)
                    <div>
                        <input type="checkbox" name="{{ $attribute->id }}" value="{{ $value->id }}"
                            id="{{ $attribute->id . '-' . $value->id }}">
                        <label for="{{ $attribute->id . '-' . $value->id }}">{{ $value->value }} |
                            {{ $value->products->count() }}</label>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
    <button>Применить</button>
</form>
<br>
<div>
    @foreach ($products as $product)
        <div>
            <p>Product Name: {{ $product->name }}</p>
            <p>Caterogy: {{ $product->category->name }}</p>
            @foreach ($product->attributeValues as $attributeValue)
                <p>{{ $attributeValue->attribute->name }}: {{ $attributeValue->value->value }}</p>
            @endforeach
        </div>
        <br>
    @endforeach
</div>
