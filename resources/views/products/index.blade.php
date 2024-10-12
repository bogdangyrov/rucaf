<div>
    <h1>Тип:</h1>
</div>
<div>
    <h2>Категории:</h2>
    @foreach ($categories as $category)
        <div>
            <p>{{ $category->name }}</p>
        </div>
    @endforeach
    <h3>Характеристики</h3>
    @foreach ($attributes as $attribute)
        <div>
            <p>{{ $attribute->name }}</p>
        </div>
        <div style="margin-left: 10px">
            @foreach ($attribute->attributeValues as $value)
                <div>
                    <p>{{ $value->value }}</p>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
<br>
<div>
    @foreach ($products as $product)
        <div>
            <p>Product Name: {{ $product->name }}</p>
            <p>Caterogy: {{ $product->category->name }}</p>
            @foreach ($product->attributeValues as $attributeValue)
                <p>{{ $attributeValue->attribute->name }}: {{ $attributeValue->value }}</p>
            @endforeach
        </div>
        <br>
    @endforeach
</div>
