<div class="wrap">
    <div class="content">
        <div class="text-block">
            <div class="title">Описание</div>
            <div class="text-block__content wrap-collapse-content">
                @isset($category->short_text)
                    <div class="collapse-content">
                        {!! $category->short_text !!}
                    </div>
                @endisset
                @isset($category->long_text)
                    <div class="collapse-content collapse-content--hidden">
                        {!! $category->long_text !!}
                    </div>
                    <div class="collapse-actions">
                        <button class="collapse-actions__btn-open" type="button">Показать больше</button>
                    </div>
                @endisset
            </div>
        </div>
    </div>
</div>
