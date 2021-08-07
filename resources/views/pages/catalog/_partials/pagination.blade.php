<catalog-pagination :count="pagination_count" :current="pagination_current"></catalog-pagination>
{{--
@if(filters()->tree()->paginate && (filters()->tree()->pagination_count > 1))
    @php
        $count = filters()->tree()->pagination_count;
        $current = filters()->tree()->pagination_current;
    @endphp
    <div class="row">
        <div class="col text-center">
            <div class="pagination catalog__pagination justify-content-center align-items-center">
                --}}
{{--  PREV BUTTON --}}{{--

                <button type="button" class="icon-center nav-arrow  js-catalog-pagination-page"
                    @if($current != 1)
                        data-page="{{$current - 1}}"
                        href="{{resolver()->pageUrl($current-1)}}"
                    @endif
                >@svg('images/svg/prev.svg')</button>

                --}}
{{-- FIRST PAGE BUTTON --}}{{--

                <a class="nav-number js-catalog-pagination-page {{ $current  == 1 ? 'active' : '' }}"
                   @if($current  != 1)
                    data-page="1"
                    href="{{resolver()->pageUrl(1)}}"
                            @endif
                    >
                    1
                </a>

                --}}
{{-- OTHERS BUTTONS --}}{{--

                @for ($page = 2; $page <= $count; $page++)
                    <a class="nav-number js-catalog-pagination-page {{ $current == $page ? 'active' : '' }}"
                        @if($current != $page)
                            data-page="{{$page}}"
                            href="{{resolver()->pageUrl($page)}}"
                        @endif
                    >
                        {{$page}}
                    </a>
                @endfor

                --}}
{{-- NEXT PAGE BUTTON --}}{{--

                <button type="button" class="icon-center nav-arrow js-catalog-pagination-page"
                    @if($current != $count)
                        data-page="{{$current + 1}}"
                        href="{{resolver()->pageUrl($current + 1)}}"
                    @endif
                >
                    @svg('images/svg/next.svg')
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col text-center">
            --}}
{{-- SHOW BUTTON --}}{{--

            <a class="btn btn-sm btn-light catalog__pagination__btn  js-catalog-pagination-page" data-page="all"
               href="{{resolver()->pageUrl("all")}}">Просмотреть всё</a>
        </div>
    </div>
@endif
--}}
