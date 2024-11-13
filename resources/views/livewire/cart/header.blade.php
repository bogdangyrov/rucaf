<a href="{{ route('cart') }}" class="actions__item">
    <span class="actions__btn"><i class="icon-basket"></i></span>
    @if ($totalQuantity)
        <span class="actions__numbs">{{ $totalQuantity }}</span>
    @endif
</a>
