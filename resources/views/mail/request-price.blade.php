@extends('layouts.mail')

@section('content')
    <div>
        <h1>Отправлен запрос на стоимость</h1>

        <div class="email-content">
            @include('mail.components.client')
            @include('mail.components.comment')
            @include('mail.components.product-name')

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
                    <td>{{ $product->category->productType->name }}</td>
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
