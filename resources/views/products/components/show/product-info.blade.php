<div class="product-info">
    <div class="tabs">
        <ul class="tabs__menu tabs-menu scroll">
            <li class="tabs-menu__item"><a href="#chars" class="tabs-menu__link">Характеристики</a></li>
            <li class="tabs-menu__item"><a href="#desc" class="tabs-menu__link">Описание</a></li>
            <li class="tabs-menu__item"><a href="#how-buy" class="tabs-menu__link">Как заказать</a></li>
            <li class="tabs-menu__item"><a href="#pay" class="tabs-menu__link">Оплата</a></li>
            <li class="tabs-menu__item"><a href="#delivery" class="tabs-menu__link">Доставка</a></li>
            <li class="tabs-menu__item"><a href="#garanty" class="tabs-menu__link">Гарантия и
                    возврат</a></li>
        </ul>
        <div class="product-specs tabs__content tabs-content" id="chars">
            <h2 style="padding-bottom: 15px">Технические характеристики</h2>
            @php
                $specs = [];
                foreach ($product->attributeValues as $attributeValue) {
                    $specs[] = [
                        'name' => $attributeValue->attribute->name,
                        'value' => $attributeValue->value->value,
                    ];
                }
                if (isset($product->dimensions)) {
                    $specs[] = ['name' => 'Габариты ШхВхГ, мм', 'value' => $product->dimensions];
                }
                if (isset($product->mass)) {
                    $specs[] = ['name' => 'Масса, кг', 'value' => $product->mass];
                }
            @endphp
            <div class="specs-grid">
                @foreach ($specs as $spec)
                    <div class="spec-item">
                        <span class="spec-name">{{ $spec['name'] }}</span>
                        <span class="spec-dots"></span>
                        <span class="spec-value">{{ $spec['value'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div id="desc" class="tabs__content tabs-content">
            <div class="tabs-txt">
                <p>{!! str_replace('{NAME}', explode(' ', $product->name)[1], $subcategory->description) !!}</p>
                <p>{!! str_replace('{NAME}', explode(' ', $product->name)[1], $product->description) !!}</p>
            </div>
            <div class="tabs-info">
                @if (isset($subcategory->docs) && count($subcategory->docs) > 0)
                    <div class="docs">
                        @foreach ($subcategory->docs_file_names ?? [] as $doc => $name)
                            <a href="{{ Storage::url($doc) }}" class="docs__item">
                                <i class="docs__icon {{ $product::getDocIcon($doc) }}"></i>
                                <div class="docs__content">
                                    <div class="docs__title">{{ $name }}</div>
                                    <div class="docs__format">
                                        <span>
                                            @if (Storage::disk('public')->exists($doc))
                                                @if (Storage::disk('public')->size($doc) / 1024 / 1024 < 1)
                                                    {{ round(Storage::disk('public')->size($doc) / 1024) }}
                                                    Kб
                                                @else
                                                    {{ round(Storage::disk('public')->size($doc) / 1024 / 1024, 1) }}
                                                    Мб
                                                @endif
                                            @endif
                                        </span>
                                        <span>{{ $product::getDocExtension($doc) }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach

                        @foreach ($product->docs_file_names ?? [] as $doc => $name)
                            <a href="{{ Storage::url($doc) }}" class="docs__item">
                                <i class="docs__icon {{ $product::getDocIcon($doc) }}"></i>
                                <div class="docs__content">
                                    <div class="docs__title">{{ $name }}</div>
                                    <div class="docs__format">
                                        <span>
                                            @if (Storage::disk('public')->exists($doc))
                                                @if (Storage::disk('public')->size($doc) / 1024 / 1024 < 1)
                                                    {{ round(Storage::disk('public')->size($doc) / 1024) }}
                                                    Kб
                                                @else
                                                    {{ round(Storage::disk('public')->size($doc) / 1024 / 1024, 1) }}
                                                    Мб
                                                @endif
                                            @endif
                                        </span>
                                        <span>{{ $product::getDocExtension($doc) }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div id="how-buy" class="tabs__content tabs-content">
            <div class="tabs-txt">
                <h2>Как заказать промышленное оборудование</h2>
                <p>В компании <strong>«Промтеплострой»</strong> предусмотрено несколько удобных способов оформления
                    заказа на электротехническую продукцию и промышленное оборудование. Мы работаем с предприятиями по
                    всей России и СНГ.</p>

                <p><strong>1. Оформление через сайт (Быстрый заказ):</strong></p>
                <ul>
                    <li>Воспользуйтесь кнопкой <strong>«Заказать в 1 клик»</strong> непосредственно в карточке
                        интересующего товара.</li>
                    <li>В открывшейся форме укажите ваши контактные данные и нажмите «Отправить».</li>
                    <li>Наш ведущий специалист подготовит индивидуальное коммерческое предложение с учетом актуальных
                        остатков и свяжется.</li>
                </ul>

                <p><strong>2. Заявка по электронной почте:</strong></p>
                <ul>
                    <li>Направьте запрос на наш официальный адрес: <a href="mailto:{{ $emails->first()->email }}">{{ $emails->first()->email }}</a>.
                    </li>
                    <li>Для оперативного выставления счета рекомендуем сразу прикрепить <strong>реквизиты вашей
                            организации</strong> и указать требуемое количество товара.</li>
                    <li>Технический специалист проконсультирует вас по подбору аналогов и срокам отгрузки.</li>
                </ul>

                <p><strong>3. Заказ по телефону:</strong></p>
                <ul>
                    <li>Свяжитесь с нами по номеру: <a href="tel:88003017090">+8 (800) 301-70-90</a>.</li>
                    <li>Вы сможете получить профессиональную консультацию, уточнить технические характеристики
                        оборудования и сразу запустить процесс подготовки договора поставки.</li>
                </ul>
            </div>
        </div>

        <div id="pay" class="tabs__content tabs-content">
            <div class="tabs-txt">
                <h2>Условия оплаты</h2>
                <p>Мы предлагаем прозрачные и гибкие финансовые условия для обеспечения бесперебойных поставок на ваши
                    объекты.</p>

                <p><strong>Для юридических лиц и ИП:</strong></p>
                <p>Оплата производится по <strong>безналичному расчету с НДС</strong>. После обработки вашей заявки
                    через сайт или почту <a href="mailto:{{ $emails->first()->email }}">{{ $emails->first()->email }}</a>, менеджер выставит счет на
                    оплату.</p>
                <ul>
                    <li><strong>Гибкие условия:</strong> Возможна частичная предоплата по предварительному согласованию
                        с вашим персональным менеджером.</li>
                    <li><strong>Документооборот:</strong> Полный комплект бухгалтерских документов (счет-фактура,
                        накладная ТОРГ-12 или УПД) предоставляется вместе с товаром или отправляется почтой/через
                        системы ЭДО.</li>
                    <li><strong>Договор поставки:</strong> Мы ценим юридическую чистоту сделок — по вашему запросу
                        подготовим и согласуем официальный договор.</li>
                </ul>

                <p><strong>Для физических лиц:</strong></p>
                <p>Вы можете оплатить заказ по счету через мобильное приложение любого банка (по реквизитам или
                    QR-коду), а также через кассу в любом отделении банка.</p>
                <ul>
                    <li>После поступления денежных средств на расчетный счет, мы незамедлительно приступаем к <a
                            href="{{ route('page', ['page' => 'dostavka-i-oplata']) }}">доставке вашего заказа</a>.
                    </li>
                    <li>Все финансовые операции подтверждаются документально, обеспечивая 100% безопасность вашей
                        покупки.</li>
                </ul>
            </div>
        </div>

        <div id="delivery" class="tabs__content tabs-content">
            <div class="tabs-txt">
                <h2>География и способы доставки</h2>
                <p>Компания «Промтеплострой» осуществляет оперативную доставку оборудования в любую точку <strong>России
                        и стран СНГ</strong>. Мы сотрудничаем только с проверенными логистическими операторами.</p>

                <p><strong>Наши преимущества:</strong></p>
                <ul>
                    <li><strong>Бесплатно:</strong> Доставка груза до терминала транспортной компании в городе
                        отправителя.</li>
                    <li><strong>Выбор перевозчика:</strong> Работаем с «Деловые Линии», «ПЭК», «Байкал-Сервис»,
                        «ЖелДорЭкспедиция», «Энергия» и другими ТК по вашему выбору.</li>
                </ul>

                <p><strong>Этапы доставки:</strong></p>
                <ol>
                    <li>После подтверждения оплаты мы комплектуем заказ и бесплатно доставляем его на терминал выбранной
                        ТК.</li>
                    <li>Сотрудник транспортной компании уведомит вас о прибытии груза в ваш город.</li>
                    <li>Для получения товара на терминале представителю юрлица необходимы паспорт и доверенность,
                        физлицу — паспорт.</li>
                </ol>
                <p>Для срочных заказов и малогабаритных посылок (до 10 кг) возможна организация
                    <strong>экспресс-доставки</strong> курьерскими службами до двери вашего офиса или склада.</p>
            </div>
        </div>

        <div id="garanty" class="tabs__content tabs-content">
            <div class="tabs-txt">
                <h2>Гарантийные обязательства и сервис</h2>
                <p>Приобретая промышленное оборудование на портале <a href="{{ route('home') }}">rucaf.com</a>, вы
                    получаете официальную гарантию качества от <strong>12 до 60 месяцев</strong>.</p>

                <p><strong>Ваши права как покупателя:</strong></p>
                <p>В случае обнаружения заводских дефектов в течение гарантийного срока, вы вправе:</p>
                <ul>
                    <li>Запросить бесплатное устранение неисправностей (гарантийный ремонт).</li>
                    <li>Потребовать соразмерного снижения цены или замены товара на аналогичную модель.</li>
                    <li>Отказаться от договора с полным возвратом уплаченных средств (после технической экспертизы
                        товара на складе Поставщика).</li>
                </ul>

                <p><strong>Условия сохранения гарантии:</strong></p>
                <ul>
                    <li>Наличие документов, подтверждающих факт покупки (УПД, ТОРГ-12).</li>
                    <li>Сохранение полной комплектации и целостности заводских пломб (за исключением необходимых для
                        монтажа).</li>
                    <li>Отсутствие следов ненадлежащей эксплуатации и механических повреждений.</li>
                </ul>

                <p><strong>Порядок возврата оборудования:</strong></p>
                <p>Возврат или обмен товара осуществляется после письменного согласования с менеджером. Покупатель
                    отправляет товар ТК до города Поставщика. После проверки сохранности внешнего и внутреннего
                    состояния оборудования, возврат денежных средств производится в течение <strong>5 рабочих
                        дней</strong>.</p>
            </div>
        </div>
    </div>
</div>
