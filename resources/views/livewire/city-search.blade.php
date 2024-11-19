<div class="modal-content">
    <div style="width:90%; padding-top:15px; padding-bottom:15px">
        <div class="modal-form__item">
            <input type="text" class="modal-form__input" id="name2" placeholder="" wire:model.live="search">
            <label for="name2" class="modal-form__label">Поиск</label>
        </div>
    </div>

    <div style="overflow-y: scroll; height: 400px">
        <div class="cities-wrap-modal">
            @foreach ($groupedCities as $capitalLetter => $cities)
                <div class="cities-group">
                    <b class="cities-capital-letter">{{ $capitalLetter }}</b>
                    @foreach ($cities as $city)
                        <p class="city-btn" wire:click="chooseCity({{ $city->id }})" data-fancybox-close>
                            {{ $city->name }}</p>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
