<h3>Товар: <a
        href="{{ route('products.show', ['productType' => $product->category->productType->slug, 'category' => $product->category, 'subcategory' => $product->subcategory, 'product' => $product->slug]) }}">{{ $product->name }}</a>
</h3>
