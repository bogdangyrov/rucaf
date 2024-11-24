@extends('layouts.mail')

@section('content')
    <div>
        <h1>Отправлена заявка на заказ</h1>

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
                                href="{{ route('products.show', ['productType' => $product->productType->slug, 'product' => $product->slug]) }}">
                                {{ $product->name }}</a>
                        </th>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            @isset($product->discount_price)
                                {{ \App\Models\Product::formatPrice($product->discount_price, ' ') }}₽
                            @else
                                {{ \App\Models\Product::formatPrice($product->price, ' ') }}₽
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
    </div>
@endsection
