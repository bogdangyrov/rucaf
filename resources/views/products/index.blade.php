<div>
    @foreach ($products as $product)
        <div>
            <p>Product Name: {{ $product->name }}</p>
            @foreach ($product->attributeValues as $attributeValue)
                <p>{{ $attributeValue->attribute->name }}: {{ $attributeValue->value }}</p>
            @endforeach
        </div>
    @endforeach
</div>
