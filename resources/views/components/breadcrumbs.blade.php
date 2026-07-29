<div class="bread">
    @foreach ($items as $item)
        @if (isset($item['url']))
            <a href="{{ $item['url'] }}" class="bread__link">{{ $item['label'] }}</a>
        @else
            <a class="bread__link">{{ $item['label'] }}</a>
        @endif
        @if (!$loop->last)
            <span class="bread__sep"><i class="icon-arrow1"></i></span>
        @endif
    @endforeach
</div>

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        @foreach ($items as $item)
        {
        "@type": "ListItem",
        "position": {{ $loop->iteration }},
        "name": "{{ $item['label'] }}",
        "item": "{{ $item['url'] ?? request()->url() }}"
        }@if(!$loop->last),@endif
        @endforeach
    ]
}
</script>
