@if ($paginator->hasPages())
    <nav class="wrap-pagination">
        <button class="pagination-btn-more btn btn--white" type="button">Показать еще</button>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="pagination__item">
                    <a class="pagination__link pagination__link--prev pagination__link--disabled"><i
                            class="icon-arrow1"></i></a>
                </li>
            @else
                <li class="pagination__item">
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="pagination__link pagination__link--prev pagination__link--disabled"><i
                            class="icon-arrow1"></i></a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="pagination__item"><span class="pagination__dots">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pagination__item"><span class="pagination__current">{{ $page }}</span>
                            </li>
                        @else
                            <li class="pagination__item"><a href="{{ $url }}"
                                    class="pagination__link">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="pagination__item"><a href="{{ $paginator->nextPageUrl() }}"
                        class="pagination__link pagination__link--next"><i class="icon-arrow1"></i></a>
                </li>
            @else
                <li class="pagination__item"><a
                        class="pagination__link pagination__link--next pagination__link--disabled"><i
                            class="icon-arrow1"></i></a>
                </li>
            @endif
        </ul>
    </nav>
@endif
