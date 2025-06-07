@extends('layouts.mail')

@section('content')
    <div>
        <h1>Отправлена заявка на заказ</h1>

        <div class="email-content">
            @include('mail.components.client')
            @include('mail.components.comment')
        </div>

        <div>
            <table>
                <tr>
                    <th>Товар:</th>
                    <th>Количество:</th>
                    <th>Цена:</th>
                    <th>Общая цена:</th>
                </tr>

                @foreach ($products as $product)
                    <tr>
                        <th><a
                                href="{{ route('products.show', ['productType' => $product->category->productType, 'category' => $product->category, 'subcategory' => $product->subcategory, 'product' => $product]) }}">
                                {{ $product->name }}</a>
                        </th>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            @if (isset($product->discount_price))
                                {{ \App\Models\Product::formatPrice($product->discount_price, ' ') }}₽
                            @elseif (isset($product->price))
                                {{ \App\Models\Product::formatPrice($product->price, ' ') }}₽
                            @else
                                По запросу
                            @endisset
                    </td>
                    <td>
                        @isset($product->discount_price)
                            {{ \App\Models\Product::formatPrice($product->discount_price * $product->quantity, ' ') }}₽
                        @else
                            {{ \App\Models\Product::formatPrice($product->price * $product->quantity, ' ') }}₽
                        @endisset
                    </td>
                </tr>
            @endforeach

            <tr>
                <th>Общее кол-во:</th>
                <th>{{ $totalQuantity }}</th>
                <th>Сумма:</th>
                <th>{{ \App\Models\Product::formatPrice($totalSum, ' ') }}₽</th>
            </tr>
        </table>
    </div>
@endsection
