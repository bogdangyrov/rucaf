<div class="bread">
    <a href="/" class="bread__link">Главная</a>
    <span class="bread__sep"><i class="icon-arrow1"></i></span>
    <a href="#" class="bread__link">Каталог</a>
    <span class="bread__sep"><i class="icon-arrow1"></i></span>
    <a href="{{ route('products', ['productType' => $type->slug]) }}" class="bread__link">{{ $type->name }}</a>
    <span class="bread__sep"><i class="icon-arrow1"></i></span>
</div>
