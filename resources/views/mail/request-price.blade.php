@extends('layouts.mail')

@section('content')
    <div>
        <h1>Отправлен запрос на стоимость</h1>

        <div class="email-content">
            <section>
                <p><b>Клиент:</b> {{ $name }}, <a
                        href="tel:+{{ $phone->formatE164() }}">+{{ $phone->formatNational() }}</a>
                </p>
            </section>

            @isset($comment)
                <section>
                    <p><b>Комментарий: </b></p>
                    <p>{{ $comment }}</p>
                </section>
            @endisset

            <h3>Товар: <a
                    href="{{ route('products.show', ['productType' => $product->productType->slug, 'product' => $product->slug]) }}">{{ $product->name }}</a>
            </h3>

            @isset($quantity)
                <section>
                    <p><b>В количестве:</b> {{ $quantity }} шт.</p>
                </section>
            @endisset

        </div>

        <div>
            <table>
                <tr>
                    <th>Характеристика:</th>
                    <th>Значение:</th>
                </tr>
                <tr>
                    <th>Тип товара:</th>
                    <td>{{ $product->productType->name }}</td>
                </tr>
                <tr>
                    <th>Категория:</th>
                    <td>{{ $product->category->name }}</td>
                </tr>

                @foreach ($product->attributeValues as $attributeValue)
                    <tr>
                        <th>{{ $attributeValue->attribute->name }}</th>
                        <td>{{ $attributeValue->value->value }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
