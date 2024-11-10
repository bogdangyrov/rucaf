<div class="goods-wrap-slider">
    <div class="goods-slider">
        @if (isset($product->images) && count($product->images))
            @foreach ($product->images as $image)
                <div class="goods-slider__item">
                    <a href="{{ asset('storage/' . $image) }}" class="goods-slider__link" data-fancybox="goods"><img
                            src="{{ asset('storage/' . $image) }}" alt="" class="goods-slider__img"></a>
                </div>
            @endforeach
        @else
            <div class="goods-slider__item">
                <a href="{{ asset('assets/img/content/product-1.jpg') }}" class="goods-slider__link"
                    data-fancybox="goods"><img src="{{ asset('assets/img/content/product-1.jpg') }}" alt=""
                        class="goods-slider__img"></a>
            </div>
        @endif
    </div>
    <div class="thumbs-slider">
        @if (isset($product->images) && count($product->images))
            @foreach ($product->images as $image)
                <div class="thumbs-slider__item"><img src="{{ asset('storage/' . $image) }}" alt=""
                        class="thumbs-slider__img"></div>
            @endforeach
        @else
            <div class="thumbs-slider__item"><img src="{{ asset('assets/img/content/product-1.jpg') }}" alt=""
                    class="thumbs-slider__img"></div>
        @endif
    </div>
</div>
