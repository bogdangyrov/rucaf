<div class="faq-actions__item">
    <div class="faq-actions__icon"><i class="icon-geo"></i></div>
    <div class="faq-actions__content">
        <div class="faq-actions__title">
            @if ($city)
                {{ $city }}
            @else
                Санкт-Петербург
            @endif
        </div>
        <button class="faq-actions__data" type="button" data-fancybox="" data-src="#city">изменить</button>
    </div>

    <div style="display: none;" class="modal modal--no-price modal--bottom" id="city">
        <div class="modal-wrap">
            <div class="modal-title"><span>Изменить город</span><button class="modal-close-btn" type="button"
                    data-fancybox-close><i class="icon-close1"></i></button></div>
            <livewire:city-search />
        </div>
    </div>
</div>
