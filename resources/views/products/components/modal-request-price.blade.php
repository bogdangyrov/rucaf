<div style="display: none;" class="modal modal--no-price modal--bottom" id="order{{ $product->id }}">
    <div class="modal-wrap">
        <div class="modal-title"><span>Запросить стоимость</span><button class="modal-close-btn" type="button"
                data-fancybox-close><i class="icon-close1"></i></button></div>
        <livewire:modal-request-price :product="$product">
    </div>
</div>
