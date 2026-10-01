<div class="modal-content" wire:init="loadCities" x-data="{
        search: '',
        match(cityName) {
            if (!this.search.trim()) return true;
            return cityName.toLowerCase().includes(this.search.toLowerCase().trim());
        }
    }">
    <div style="width:90%; padding-top:15px; padding-bottom:15px">
        <div class="modal-form__item">
            <input type="text" class="modal-form__input" id="name2" placeholder="" x-model="search"
                :disabled="!$wire.isLoaded">
            <label for="name2" class="modal-form__label">Поиск</label>
        </div>
    </div>

    <div style="overflow-y: scroll; height: 400px">
        <div x-show="!$wire.isLoaded" style="text-align: center; padding: 20px;">
            <span>Загрузка городов...</span>
        </div>

        <template x-if="$wire.isLoaded">
            <div class="cities-wrap-modal">
                @foreach ($groupedCities as $capitalLetter => $cities)
                    <div class="cities-group"
                        x-show="$el.querySelectorAll('.city-btn:not([style*=\'display: none\'])').length > 0">
                        <b class="cities-capital-letter">{{ $capitalLetter }}</b>

                        @foreach ($cities as $city)
                            <p class="city-btn" wire:click="chooseCity({{ $city['id'] }})"
                                x-show="match('{{ addslashes($city['name']) }}')" data-fancybox-close>
                                {{ $city['name'] }}
                            </p>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </template>
    </div>
</div>
