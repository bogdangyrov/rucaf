@extends('layouts.master')

@section('content')
    <div class="wrap-main">
        <div class="content content--main">
            <div class="wrap-search">
                <livewire:search />
                <div class="search-links">
                    <div class="search-links__item"><a href="#" class="search-links__link">Автоматические выключатели
                            220В</a></div>
                    <div class="search-links__item"><a href="#" class="search-links__link">Управление краном</a></div>
                    <div class="search-links__item"><a href="#" class="search-links__link">Электродвигатели</a></div>
                    <div class="search-links__item"><a href="#" class="search-links__link">Лебедки</a></div>
                </div>
            </div>

            @include('components.main-slider')
        </div>
    </div>

    @include('components.catalog')

    <div class="wrap wrap--brands wrap--light-gray">
        <div class="content">
            <div class="wrap-brands-slider">
                <div class="brands-slider">
                    <div class="brands-slider__item"><img src="{{ asset('img/content/img-11.png') }}" alt="">
                    </div>
                    <div class="brands-slider__item"><img src="{{ asset('img/content/img-12.png') }}" alt="">
                    </div>
                    <div class="brands-slider__item"><img src="{{ asset('img/content/img-13.png') }}" alt="">
                    </div>
                    <div class="brands-slider__item"><img src="{{ asset('img/content/img-15.png') }}" alt="">
                    </div>
                    <div class="brands-slider__item"><img src="{{ asset('img/content/img-11.png') }}" alt="">
                    </div>
                    <div class="brands-slider__item"><img src="{{ asset('img/content/img-12.png') }}" alt="">
                    </div>
                    <div class="brands-slider__item"><img src="{{ asset('img/content/img-13.png') }}" alt="">
                    </div>
                    <div class="brands-slider__item"><img src="{{ asset('img/content/img-15.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wrap wrap--gray wrap--pluses">
        <div class="content">
            <div class="wrap-pluses">
                <div class="pluses">
                    <div class="pluses__item">
                        <div class="pluses__title">Соответствие заявленному качеству</div>
                        <div class="pluses__content">
                            <p>Перед появлением товара на сайте, наши специалисты проводят независимое тестирование.</p>
                        </div>
                    </div>
                    <div class="pluses__item">
                        <div class="pluses__title">Сотрудничество с производителями</div>
                        <div class="pluses__content">
                            <p>Сотрудничество с производителями без посредников позволяет установить более низкую цену.</p>
                        </div>
                    </div>
                    <div class="pluses__item">
                        <div class="pluses__title">Товар всегда в наличии на складе</div>
                        <div class="pluses__content">
                            <p>Отгрузка со склада происходит в течение 2-4 рабочих дней после заказа.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wrap">
        <div class="content">
            <div class="text-block">
                <div class="title">О нас</div>
                <div class="text-block__content wrap-collapse-content">
                    <div class="collapse-content">
                        <p><strong>ООО "ПТС"</strong> является признанным лидером в области производства и продаж
                            промышленного
                            оборудования и электротехники. Мы специализируемся на поставке грузоподъемного и кранового
                            оборудования, промышленных и бытовых насосов, электрощитовой продукции, низковольтной
                            аппаратуры, талей и тельферов. Достигнутыми результатами
                            мы по праву гордимся и продолжаем динамично развиваться.</p>

                        <p>Качество продукции находится под постоянным контролем наших технических специалистов. На все
                            товары предоставляется <strong>гарантийное</strong> и постгарантийное обслуживание, что
                            обеспечивает
                            дополнительную уверенность в надежности наших решений.</p>
                    </div>
                    <div class="collapse-content collapse-content--hidden">
                        <p><strong>Собственный логистический центр</strong> и складские помещения позволяют осуществлять
                            отгрузку продукции в
                            день заказа. Мы обеспечиваем доставку по всей территории России и странам СНГ, предлагая быстрые
                            и удобные условия для наших клиентов.</p>

                        <p>Ключевые преимущества сотрудничества с нами:</p>
                        <ol>
                            <li><strong>Оперативная отгрузка:</strong> благодаря собственному логистическому центру и
                                складам мы отправляем заказы в день оформления.</li>
                            <li><strong>Широкая география доставки:</strong> мы доставляем продукцию по всей России и
                                странам СНГ.</li>
                            <li><strong>Взаимовыгодное сотрудничество:</strong> для постоянных клиентов действует
                                комплексная система скидок и акций.</li>
                        </ol>

                        <p>Наша компания стремится к построению долгосрочных отношений с клиентами и партнерами, обеспечивая
                            индивидуальный подход и высококлассное обслуживание. Мы с радостью делимся знаниями и опытом,
                            помогая выбрать оптимальное оборудование под ваши задачи.</p>

                    </div>
                    <div class="collapse-actions">
                        <a href="{{ route('page', ['page' => 'o-kompanii']) }}" class="collapse-actions__btn btn">О
                            компании</a>
                        <button class="collapse-actions__btn-open" type="button">Показать больше</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.hot-products')

    @include('components.frequent-questions')
    @include('components.cities')
@endsection
