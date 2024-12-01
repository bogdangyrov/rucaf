<div style="display: none;" class="modal modal--no-price modal--bottom" id="order-one-click{{ $product->id }}">
    <div class="modal-wrap">
        <div class="modal-title"><span>Заказать в один клик</span><button class="modal-close-btn" type="button"
                data-fancybox-close><i class="icon-close1"></i></button></div>
        <livewire:modal-order-one-click :product="$product">
    </div>
</div>
