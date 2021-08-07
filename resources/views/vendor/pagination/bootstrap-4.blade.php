@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled btn btn-light btn-prev p-0 icon-center">
                @svg('images/svg/prev.svg')
            </li>
        @else
            <li class="page-item p-0">
                <a class="btn btn-light btn-prev p-0 icon-center" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                    @svg('images/svg/prev.svg')
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item  p-0">
                <a class="btn btn-light btn-next p-0 icon-center" href="{{ $paginator->nextPageUrl() }}" rel="next">
                    @svg('images/svg/next.svg')
                </a>
            </li>
        @else
            <li class="page-item disabled btn btn-light btn-next p-0 icon-center">
                @svg('images/svg/next.svg')
            </li>
        @endif
    </ul>
@endif
