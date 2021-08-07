@if ($paginator->hasPages())
<div class="catalog__pagination">
    <div class="pagination">
        @if (!$paginator->onFirstPage())
        <div class="pagination__text pagination__first"><a href="{{ $paginator->url(1) }}">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="5px" height="7px">
            <path fill-rule="evenodd" d="M3.923,6.905 C4.026,6.808 4.026,6.652 3.923,6.556 L0.631,3.491 L3.923,0.420 C4.026,0.324 4.026,0.167 3.923,0.071 C3.820,-0.025 3.652,-0.025 3.549,0.071 L0.077,3.310 C0.026,3.358 -0.000,3.418 -0.000,3.485 C-0.000,3.545 0.026,3.611 0.077,3.659 L3.549,6.899 C3.652,7.001 3.820,7.001 3.923,6.905 Z"></path>
            </svg> <span>В начало</span></a>
        </div>
        <div class="pagination__text pagination__prev"><a href="{{ $paginator->previousPageUrl() }}">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="5px" height="7px">
            <path fill-rule="evenodd" d="M3.923,6.905 C4.026,6.808 4.026,6.652 3.923,6.556 L0.631,3.491 L3.923,0.420 C4.026,0.324 4.026,0.167 3.923,0.071 C3.820,-0.025 3.652,-0.025 3.549,0.071 L0.077,3.310 C0.026,3.358 -0.000,3.418 -0.000,3.485 C-0.000,3.545 0.026,3.611 0.077,3.659 L3.549,6.899 C3.652,7.001 3.820,7.001 3.923,6.905 Z"></path>
            </svg> <span>Предыдущая</span></a>
        </div>
        @endif
        <ul>
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active"><a>{{ $page }}</a></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>
        @if ($paginator->hasMorePages())
        <div class="pagination__text pagination__next"><a href="{{ $paginator->nextPageUrl() }}"><span>Следующая</span>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="4px" height="7px">
            <path fill-rule="evenodd" d="M0.078,6.904 C-0.025,6.809 -0.025,6.652 0.078,6.556 L3.369,3.491 L0.078,0.420 C-0.025,0.324 -0.025,0.167 0.078,0.071 C0.181,-0.025 0.348,-0.025 0.451,0.071 L3.923,3.310 C3.974,3.359 4.000,3.419 4.000,3.485 C4.000,3.545 3.974,3.611 3.923,3.659 L0.451,6.899 C0.348,7.001 0.181,7.001 0.078,6.904 Z"></path>
            </svg></a>
        </div>
        <div class="pagination__text pagination__last"><a href="{{ $paginator->url($paginator->lastPage()) }}"><span>В конец</span>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="4px" height="7px">
            <path fill-rule="evenodd" d="M0.078,6.904 C-0.025,6.809 -0.025,6.652 0.078,6.556 L3.369,3.491 L0.078,0.420 C-0.025,0.324 -0.025,0.167 0.078,0.071 C0.181,-0.025 0.348,-0.025 0.451,0.071 L3.923,3.310 C3.974,3.359 4.000,3.419 4.000,3.485 C4.000,3.545 3.974,3.611 3.923,3.659 L0.451,6.899 C0.348,7.001 0.181,7.001 0.078,6.904 Z"></path>
            </svg></a>
        </div>
        @endif
    </div>

</div>
@endif
