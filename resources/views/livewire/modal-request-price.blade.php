<div>
    <div class="modal-content custom-scroll">
        @if ($emailSended)
            <div class="msg-ok">
                <div class="msg-ok__icon"><i class="icon-check1"></i></div>
                <div class="msg-ok__content">
                    <p><b>Заявка отправлена</b></p>
                    <p>Вам перезвонят в рабочее время <br>(Вт с 09:00).</p>
                </div>
            </div>
            <div class="msg-actions">
                <button class="msg-actions__btn btn btn--gray" type="button" data-fancybox-close>Закрыть</button>
            </div>
        @else
            <div class="order">
                <div class="order__wrap-order-img wrap-order-img">
                    <div class="order__img"><img
                            src="{{ asset(isset($product->images[0]) ? "storage/{$product->images[0]}" : 'assets/img/content/product-1.jpg') }}"
                            alt="{{ $product->name }}"></div>
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
            <form wire:submit="sendEmail" class="modal-form">
                <div class="modal-form__item">
                    <input type="text" class="modal-form__input" name="name" placeholder=" " wire:model="name">
                    <label for="name" class="modal-form__label">Имя</label>
                </div>
                <div class="modal-form__error">
                    @error('name')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <div class="modal-form__item">
                    <input type="text" class="modal-form__input" name="phone" placeholder=" " wire:model="phone">
                    <label for="phone" class="modal-form__label">Телефон</label>
                </div>
                <div class="modal-form__error">
                    @error('phone')
                        <p class="modal-validation-error"> {{ $message }}</p>
                    @enderror
                </div>

                <div class="modal-form__item">
                    <textarea class="modal-form__textarea" placeholder=" " name="text" wire:model="comment"></textarea>
                    <label for="msg2" class="modal-form__label">Комментарий</label>
                </div>
                <div class="modal-form__error">
                    @error('comment')
                        <p class="modal-validation-error"> {{ $message }}</p>
                    @enderror
                    @error('quantity')
                        <p class="modal-validation-error"> {{ $message }}</p>
                    @enderror
                </div>

                <div class="modal-form__item modal-form__item--actions">
                    <div class="modal-form__sum">
                        <input type="text" class="modal-form__input" placeholder="1 шт." name="quantity"
                            wire:model="quantity">
                    </div>
                    <button class="modal-form__btn btn" type="submit" {{-- data-fancybox
                data-src="#form-price-ok2" --}}>Запросить
                        стоимость</button>
                </div>
                <label class="modal-form__item modal-form__item--privacy">
                    <input type="checkbox" class="modal-form__check" wire:model="privacy">
                    <span class="modal-form__txt @error('privacy') error @enderror">Даю согласие на <a
                            href="#">обработку
                            персональных данных.</a></span>
                </label>
            </form>
        @endif
    </div>
</div>
