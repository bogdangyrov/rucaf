<section class="wrap">
    <div class="content">
        <div class="cities__title title">
            <h2>Регионы доставки</h2>
        </div>
        <div class="cities-wrap">
            @foreach ($citiesGrouped as $capitalLetter => $cities)
                <div class="cities-group">
                    <b class="cities-capital-letter">{{ $capitalLetter }}</b>
                    @foreach ($cities as $city)
                        <p>{{ $city->name }}</p>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</section>
