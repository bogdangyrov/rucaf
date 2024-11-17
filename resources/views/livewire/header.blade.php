<div class="header__actions actions">

    <button class="actions__item actions__item--white actions__item--search" type="button" data-fancybox
        data-src="#search">
        <span class="actions__btn"><i class="icon-search"></i></span>
    </button>

    <a href="{{ route('comparison') }}" class="actions__item">
        <span class="actions__btn"><i class="icon-compare"></i></span>
        @if ($comparisonQuantity)
            <span class="actions__numbs">{{ $comparisonQuantity }}</span>
        @endif
    </a>

    <a href="{{ route('favorites') }}" class="actions__item">
        <span class="actions__btn"><i class="icon-fav"></i></span>
        @if ($favoritesQuantity)
            <span class="actions__numbs">{{ $favoritesQuantity }}</span>
        @endif
    </a>

    <a href="{{ route('cart') }}" class="actions__item">
        <span class="actions__btn"><i class="icon-basket"></i></span>
        @if ($cartQuantity)
            <span class="actions__numbs">{{ $cartQuantity }}</span>
        @endif
    </a>

    <a class="actions__item actions__item--white actions__item--menu">
        <span class="actions__btn"><i class="icon-menu1"></i></span>
    </a>
</div>
