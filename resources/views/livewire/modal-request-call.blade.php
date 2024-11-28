<div class="modal-wrap">
    <div class="modal-title"><span>Звонок специалиста</span><button class="modal-close-btn" type="button"
            data-fancybox-close><i class="icon-close1"></i></button></div>
    <div class="modal-content scroll">
        @if ($emailSended)
            <div class="msg-ok">
                <div class="msg-ok__icon"><i class="icon-check1"></i></div>
                <div class="msg-ok__content">
                    <p><b>Заявка отправлена</b></p>
                    <p>Вам перезвонят в течение 15 минут.</p>
                </div>
            </div>
            <div class="msg-actions">
                <button class="msg-actions__btn btn btn--gray" type="button" data-fancybox-close>Закрыть</button>
            </div>
        @else
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
                </div>

                <div class="modal-form__item modal-form__item--actions">
                    <button class="modal-form__btn btn" type="submit">Запросить
                        звонок</button>
                </div>
                <label class="modal-form__item modal-form__item--privacy">
                    <input type="checkbox" class="modal-form__check" wire:model="privacy">
                    <span class="modal-form__txt @error('privacy') error @enderror">Даю согласие на <a
                            href="{{ route('privacy') }}">обработку
                            персональных данных.</a></span>
                </label>
            </form>
        @endif
    </div>
</div>
