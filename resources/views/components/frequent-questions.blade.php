<section class="wrap">
    <div class="content">
        <div class="faq">
            <div class="faq__left">
                <div class="faq__title title">
                    <h2>Частые вопросы</h2>
                </div>
                <div class="faq__content">
                    <p>Мы собрали частые вопросы от парнеров и покупателей. Если не нашли нужную информацию оставьте
                        заявку на звонок специалиста или обратитесь в службу поддержки.</p>
                </div>
                <div class="faq__actions faq-actions">
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
                    <div class="faq-actions__item">
                        <div class="faq__info faq-info">
                            <div class="faq-info__icon"><i class="icon-mail"></i></div>
                            <div class="faq-info__content">
                                <a href="mailto:{{ $emails->first()->email }}"
                                    class="faq-info__title">{{ $emails->first()->email }}</a>
                                <div class="faq-info__data">{{ $emails->first()->data }}</div>
                            </div>
                        </div>
                        <div class="faq__hidden-info hidden-info faq-info" style="display: none;">
                            @for ($i = 1; $i < count($emails); $i++)
                                <div class="hidden-info__item">
                                    <div class="faq-info__icon"><i class="icon-mail"></i></div>
                                    <div class="faq-info__content">
                                        <a href="mailto:{{ $emails[$i]->email }}"
                                            class="faq-info__title">{{ $emails[$i]->email }}</a>
                                        <div class="faq-info__data">{{ $emails[$i]->data }}</div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="faq-actions__item">
                        <button class="faq-actions__btn btn btn--gray" type="button" data-fancybox
                            data-src="#request-call">Звонок специалиста</button>
                    </div>
                </div>
            </div>
            <div class="faq__right">
                <div class="q-a">
                    <div class="q-a__item">
                        <div class="q-a__title">Есть ли у вас акции для постоянных клиентов?</div>
                        <div class="q-a__content">
                            <p>Есть ли у вас акции для постоянных клиентов?</p>
                        </div>
                    </div>
                    <div class="q-a__item">
                        <div class="q-a__title">Вы можете доставить заказ в другую страну?</div>
                        <div class="q-a__content">
                            <p>Учитывая ключевые сценарии поведения, понимание сути ресурсосберегающих технологий не
                                даёт нам иного выбора, кроме определения новых предложений. Внезапно, тщательные
                                исследования конкурентов, вне зависимости от их уровня, должны быть разоблачены. Ясность
                                нашей позиции очевидна: постоянное информационно-пропагандистское обеспечение нашей
                                деятельности предопределяет высокую востребованность своевременного выполнения
                                сверхзадачи.</p>
                        </div>
                    </div>
                    <div class="q-a__item">
                        <div class="q-a__title">Куда обращаться по вопросам сотрудничества?</div>
                        <div class="q-a__content">
                            <p>Куда обращаться по вопросам сотрудничества?</p>
                        </div>
                    </div>
                    <div class="q-a__item">
                        <div class="q-a__title">Есть ли скидки при заказе ОПТом?</div>
                        <div class="q-a__content">
                            <p>Есть ли скидки при заказе ОПТом?</p>
                        </div>
                    </div>
                    <div class="q-a__item">
                        <div class="q-a__title">Могу ли я самостоятельно забрать заказ?</div>
                        <div class="q-a__content">
                            <p>Могу ли я самостоятельно забрать заказ?</p>
                        </div>
                    </div>
                    <div class="q-a__item">
                        <div class="q-a__title">Можете ли выступить посредником в закупке оборудования?</div>
                        <div class="q-a__content">
                            <p>Можете ли выступить посредником в закупке оборудования?</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
