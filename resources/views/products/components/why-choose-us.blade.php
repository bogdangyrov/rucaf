<div class="wrap wrap--coop">
    <div class="coop faq content">
        <div class="coop__left">
            <div class="title">
                <h2>С нами сотрудничают, <br>потому что выгодно</h2>
            </div>
            <div class="coop__txt">
                <p>Когда выгода встречается с надёжностью, рождается идеальный партнёр для вашего бизнеса. Мы предлагаем
                    не просто оборудование — мы открываем новые возможности для роста. Широкий ассортимент, персональные
                    условия и скорость поставок позволяют нашим партнёрам быть на шаг впереди конкурентов. Каждый заказ
                    — это вклад в ваше развитие, а каждая сделка — подтверждение нашего стремления быть лучшими для вас.
                </p>
            </div>
            <div class="faq__actions faq-actions">
                <div class="faq-actions__item">
                    <button class="faq-actions__btn btn" type="button" data-fancybox data-src="#request-call">Звонок
                        специалиста</button>
                </div>
                <div class="faq-actions__item">
                    <div class="faq__info faq-info">
                        <div class="faq-info__icon"><i class="icon-phone"></i></div>
                        <div class="faq-info__content">
                            <a href="tel:{{ $phoneNumbers->first()->formattedLinkNumber() }}"
                                class="faq-info__title">{{ $phoneNumbers->first()->formattedNumber() }}</a>
                            <div class="faq-info__data">{!! $phoneNumbers->first()->data !!}</div>
                        </div>
                    </div>
                    <div class="faq__hidden-info hidden-info faq-info" style="display: none;">
                        @for ($i = 1; $i < count($phoneNumbers); $i++)
                            <div class="hidden-info__item">
                                <div class="faq-info__icon"><i class="icon-phone"></i></div>
                                <div class="faq-info__content">
                                    <a href="tel:{{ $phoneNumbers[$i]->formattedLinkNumber() }}"
                                        class="faq-info__title">{{ $phoneNumbers[$i]->formattedNumber() }}</a>
                                    <div class="faq-info__data">{!! $phoneNumbers[$i]->data !!}</div>
                                </div>
                            </div>
                        @endfor
                        <div class="hidden-info__item">
                            <button class="hidden-info__btn btn" type="button" data-fancybox
                                data-src="#request-call">Звонок специалиста</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="coop__right">
            <div class="coop__img"><img src="{{ asset('img/logo-big.svg') }}" alt=""></div>
        </div>
    </div>
</div>
