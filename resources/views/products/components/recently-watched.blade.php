@if ($recentlyViewedProducts)
    <section class="wrap wrap--hot">
        <div class="content">
            <div class="title">
                <h2>Вы недавно смотрели</h2>
            </div>
            <div class="wrap-catalog scroll">
                <div class="catalog">
                    @foreach ($recentlyViewedProducts as $product)
                        @include('products.components.index.product-item')

                        {{-- <div class="catalog__item">
                            <div class="catalog__wrap-img">
                                <a class="catalog__img"
                                    href="{{ route('products.show', ['productType' => $product->productType->slug, 'product' => $product->slug]) }}"><img
                                        src="{{ asset(isset($product->images[0]) ? "storage/{$product->images[0]}" : 'assets/img/content/product-1.jpg') }}"
                                        alt="{{ $product->name }}"></a>
                                <div class="catalog__wrap-actions">
                                    @if ($product->is_new)
                                        <div
                                            class="catalog-stocks__sale catalog-stocks__sale--new catalog-stocks__sale--new-yellow">
                                            Новинка</div>
                                        &nbsp;
                                    @endif

                                    @if (isset($product->price) && isset($product->discount_price))
                                        <div class="catalog__stocks catalog-stocks">
                                            <div class="catalog-stocks__sale">
                                                -{{ $product->discountPercentage() }}%
                                            </div>
                                        </div>
                                    @endif
                                    <div class="catalog__actions catalog-actions">
                                        <div class="catalog-actions__item">
                                            <div class="catalog-actions__btn catalog-actions__btn--added"><i
                                                    class="icon-fav"></i></div>
                                        </div>
                                        <div class="catalog-actions__item">
                                            <div class="catalog-actions__btn"><i class="icon-compare"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="catalog__content"
                                href="{{ route('products.show', ['productType' => $product->productType->slug, 'product' => $product->slug]) }}">
                                <div class="catalog__price"> @isset($product->price)
                                        @isset($product->discount_price)
                                            {!! $product->getFormattedDiscountPrice() !!}₽
                                            <div class="catalog__old-price">
                                                {!! $product->getFormattedPrice() !!}₽
                                            </div>
                                        @else
                                            {!! $product->getFormattedPrice() !!}₽
                                        @endisset
                                    @else
                                        По запросу
                                    @endisset
                                </div>
                                <div class="catalog__title">{{ $product->name }}</div>
                            </a>
                            <div class="catalog__order catalog-order">
                                @isset($product->price)
                                    <button class="catalog-order__btn btn" type="button">В корзину</button>
                                @else
                                    <button class="catalog-order__btn btn" type="button" data-fancybox=""
                                        data-src="#order{{ $product->id }}">Запросить стоимость</button>
                                @endisset
                            </div>
                        </div> --}}

                        {{--  @include('products.components.modal-request-price') --}}
                    @endforeach

                </div>
            </div>
        </div>
    </section>
@endif
