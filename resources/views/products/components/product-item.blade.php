<div class="catalog__item">

    <div class="catalog__wrap-img">
        <a class="catalog__img"
            href="{{ route('product', ['productType' => $type->slug, 'product' => $product->slug]) }}"><img
                src="{{ asset('assets/img/content/product-1.jpg') }}" alt="{{ $product->name }}"></a>
        <div class="catalog__wrap-actions">
            <div class="catalog__actions catalog-actions">
                <div class="catalog-actions__item">
                    <div class="catalog-actions__btn"><i class="icon-fav"></i></div>
                </div>
                <div class="catalog-actions__item">
                    <div class="catalog-actions__btn"><i class="icon-compare"></i></div>
                </div>
            </div>
        </div>
    </div>

    <a class="catalog__content" href="#">
        <div class="catalog__price">
            @isset($product->price)
                {{ $product->price }}₽
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

    <div style="display: none;" class="modal modal--no-price modal--bottom" id="order{{ $product->id }}">
        <div class="modal-wrap">
            <div class="modal-title"><span>Запросить стоимость</span><button class="modal-close-btn" type="button"
                    data-fancybox-close><i class="icon-close1"></i></button></div>
            <div class="modal-content custom-scroll">
                <div class="order">
                    <div class="order__wrap-order-img wrap-order-img">
                        <div class="order__img"><img src="{{ asset('assets/img/content/product-1.jpg') }}"
                                alt="{{ $product->name }}" alt=""></div>
                    </div>
                    <div class="order__data order-data">
                        <div class="order-data__title">{{ $product->name }}</div>
                        <div class="order-data__product-data product-data">
                            <div class="product-data__item">
                                <div class="product-data__title">Артикул:</div>
                                <div class="product-data__content">9957</div>
                            </div>
                            <div class="product-data__item">
                                <div class="product-data__title">Габариты ШхВхГ, мм:</div>
                                <div class="product-data__content">600х750х980</div>
                            </div>
                            <div class="product-data__item">
                                <div class="product-data__title">Масса, кг:</div>
                                <div class="product-data__content">216</div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="#" class="modal-form">
                    <div class="modal-form__item">
                        <input type="text" class="modal-form__input" id="name2" placeholder=" ">
                        <label for="name2" class="modal-form__label">Имя</label>
                    </div>
                    <div class="modal-form__item">
                        <input type="tel" class="modal-form__input" id="phone2" placeholder=" ">
                        <label for="phone2" class="modal-form__label">Телефон</label>
                    </div>
                    <div class="modal-form__item">
                        <textarea class="modal-form__textarea" id="msg2" placeholder=" "></textarea>
                        <label for="msg2" class="modal-form__label">Комментарий</label>
                    </div>
                    <div class="modal-form__item modal-form__item--actions">
                        <div class="modal-form__sum">
                            <input type="number" class="modal-form__input" value="1" id="sum2">
                            <label for="sum2" class="modal-form__label">шт</label>
                        </div>
                        <button class="modal-form__btn btn" type="button" data-fancybox
                            data-src="#form-price-ok2">Запросить стоимость</button>
                    </div>
                    <label class="modal-form__item modal-form__item--privacy">
                        <input type="checkbox" class="modal-form__check">
                        <span class="modal-form__txt">Даю согласие на <a href="#">обработку
                                персональных данных.</a></span>
                    </label>
                </form>
            </div>
        </div>
    </div>

</div>
