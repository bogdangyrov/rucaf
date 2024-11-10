<div class="w-sort-list">
    <div class="sort-list-title">{{ $sortTitle }}:</div>
    <div class="sort-list">
        @foreach ($sortList as $name => $slug)
            @php
                $query = $originalQuery;
                $query['page'] = 1;
                $query[$sortSlug] = $slug;
            @endphp
            <a class="sort-list__item {{ $filter->$attr == $slug ? 'sort-list__item--active' : '' }}"
                href="{{ route('products.index', [
                    'productType' => $type,
                    ...$query,
                ]) }}">
                <span class="sort-list__txt">{{ $name }}</span>
            </a>
        @endforeach
    </div>
</div>
