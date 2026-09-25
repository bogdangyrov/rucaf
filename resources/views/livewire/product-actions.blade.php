<div class="wrap-good-card theiaStickySidebar">
    <div class="good-card">
        @isset($product->price)
            <div class="good-card__prices">
                @isset($product->discount_price)
                    <div class="good-card__price">{!! $product->getFormattedDiscountPrice() !!}₽
                    </div>
                    <div class="good-card__old-price">{!! $product->getFormattedPrice() !!}₽</div>
                @else
                    <div class="good-card__price">{!! $product->getFormattedPrice() !!}₽
                    </div>
                @endisset
            </div>
            <div class="good-card__wrap-actions">
                <form class="good-card__actions" wire:submit="addToCart">
                    @isset($quantity)
                        <a class="good-card__add-basket--added btn" href="{{ route('cart') }}">
                            В корзине</a>
                    @else
                        <input type="number" class="good-card__numb" placeholder="1 шт" wire:model="quantity">
                        <button class="good-card__add-basket btn" type="button" data-id="{{ $product->id }}"
                            wire:click="addToCart">
                            В корзину</button>
                    @endisset
                </form>
                <button class="good-card__one-click btn btn--gray" type="button" data-fancybox
                    data-src="#order-one-click{{ $product->id }}">Заказать в 1
                    клик</button>
                <div class="good-card__contacts">
                    <div class="good-card__contacts-title">Для вопросов и заявок:</div>
                    <div class="good-card__contacts-items">
                        @foreach (\App\Models\PhoneNumber::all() as $phone)
                            <div class="good-card__contact-row"><span class="good-card__contact-label">Тел:</span> <a
                                    href="tel:{{ $phone->formattedLinkNumber() }}">+{{ $phone->formattedNumber() }}</a>
                            </div>
                        @endforeach
                        @foreach (\App\Models\Email::all() as $email)
                            <div style="position: relative;">
                                <div class="good-card__contact-row faq-info__title email"><span
                                        class="good-card__contact-label">Email:</span> <a
                                        href="mailto:{{ $email->email }}">{{ $email->email }}</a></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="good-card__wrap-actions">
                <form class="good-card__actions" wire:submit="addToCart">
                    @isset($quantity)
                        <a class="good-card__add-basket--added btn" href="{{ route('cart') }}">
                            В корзине</a>
                    @else
                        <input type="number" class="good-card__numb" placeholder="1 шт" wire:model="quantity">
                        <button class="good-card__add-basket btn" type="button" data-id="{{ $product->id }}"
                            wire:click="addToCart">
                            В корзину</button>
                    @endisset
                </form>
                <div class="good-card__actions">
                    <button class="good-card__add-basket btn" type="button" data-fancybox
                        data-src="#order{{ $product->id }}">Запросить
                        стоимость</button>
                </div>
                <button class="good-card__one-click btn btn--gray" type="button" data-fancybox
                    data-src="#order-one-click{{ $product->id }}">Заказать в 1
                    клик</button>
                <div class="good-card__contacts">
                    <div class="good-card__contacts-title">Для вопросов и заявок</div>
                    <div class="good-card__contacts-items">
                        @foreach (\App\Models\PhoneNumber::all() as $phone)
                            <div class="good-card__contact-row"><span class="good-card__contact-label">Тел:</span> <a
                                    href="tel:{{ $phone->formattedLinkNumber() }}">+{{ $phone->formattedNumber() }}</a>
                            </div>
                        @endforeach
                        @foreach (\App\Models\Email::all() as $email)
                            <div class="good-card__contact-row"><span class="good-card__contact-label">Email:</span> <a
                                    href="mailto:{{ $email->email }}">{{ $email->email }}</a></div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endisset
    </div>
    <div class="good-card-actions">
        @if ($inFavorites)
            <a class="good-card-actions__btn good-card-actions__btn-added" type="button" name="add-wishlist__btn"
                href="{{ route('favorites') }}"><i class="icon-fav"></i>
                <span>В избранном</span></a>
        @else
            <button class="good-card-actions__btn" type="button" name="add-wishlist__btn"
                wire:click="addToFavorites"><i class="icon-fav"></i>
                <span>В избранное</span></button>
        @endif

        @if ($inComparison)
            <a class="good-card-actions__btn good-card-actions__btn-added" type="button"
                href="{{ route('comparison') }}"><i class="icon-compare"></i>
                <span>В сравнении</span></a>
        @else
            <button class="good-card-actions__btn" type="button" wire:click="addToComparison"><i
                    class="icon-compare"></i>
                <span>Сравнение</span></button>
        @endif
    </div>

    @if (
        (isset($subcategory->docs) && count($subcategory->docs) > 0) ||
            (isset($product->docs) && count($product->docs) > 0))
        <div class="docs">
            @foreach ($subcategory->docs_file_names ?? [] as $doc => $name)
                <a href="{{ Storage::url($doc) }}" class="docs__item"
                    @if (in_array(strtolower($product::getDocExtension($doc)), ['jpg', 'jpeg', 'png', 'webp', 'gif'])) data-fancybox="docs" @else target="_blank" @endif>
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
                <a href="{{ Storage::url($doc) }}" class="docs__item"
                    @if (in_array(strtolower($product::getDocExtension($doc)), ['jpg', 'jpeg', 'png', 'webp', 'gif'])) data-fancybox="docs" @else target="_blank" @endif>
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
