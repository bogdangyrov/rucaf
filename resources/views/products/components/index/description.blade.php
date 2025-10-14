@isset($shortText)
    <div class="wrap">
        <div class="content">
            <div class="text-block">
                <div class="title">Описание</div>
                <div class="text-block__content wrap-collapse-content">
                    <div class="collapse-content">
                        {!! $shortText !!}
                    </div>
                    @isset($longText)
                        <div class="collapse-content collapse-content--hidden">
                            {!! $longText !!}
                        </div>
                        <div class="collapse-actions">
                            <button class="collapse-actions__btn-open" type="button">Показать больше</button>
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
@endisset
