<div class="wrap-msg-city">
    <div class="w-msg-city">
        <div class="msg-city">
            <div class="msg-city__icon">
                <i class="icon-geo"></i>
            </div>

            <div class="msg-city__content">
                <div class="msg-city__title">
                    {{ $city ?: 'Загрузка...' }}
                </div>

                <div class="msg-city__data">
                    Это ваш город?
                </div>
            </div>
        </div>

        <div class="msg-city__actions">
            <button
                class="msg-city__btn btn"
                type="button"
                wire:click="confirm"
                @disabled(!$city)
            >
                Подтвердить
            </button>

            <button
                class="msg-city__link"
                type="button"
                data-fancybox
                data-src="#city"
            >
                Изменить
            </button>
        </div>
    </div>
</div>