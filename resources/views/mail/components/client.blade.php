<section>
    <p><b>Клиент:</b> {{ $name }}, <a href="tel:+{{ $phone->formatE164() }}">+{{ $phone->formatNational() }}</a>
    </p>
    @if ($city)
        <p><b>Город:</b> {{ $city }} </p>
    @endif
</section>
