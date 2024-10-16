<div>
    <h1>Тип: {{ $type->name }}</h1>
</div>
<form>
    <h2>Категории:</h2>
    <div>
        @foreach ($categories as $category)
            <div>
                <input type="checkbox" name="category" value="{{ $category->slug }}" id="category-{{ $category->slug }}">
                <label for="category-{{ $category->slug }}">{{ $category->name }}</label>
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
                        <input type="checkbox" name="{{ $attribute->slug }}" value="{{ $value->slug }}"
                            id="{{ $attribute->slug . '-' . $value->slug }}">
                        <label for="{{ $attribute->slug . '-' . $value->slug }}">{{ $value->value }}</label>
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
