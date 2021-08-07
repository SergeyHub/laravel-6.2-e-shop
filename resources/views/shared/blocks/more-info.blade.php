<!-- box-07 begin more-info -->
<section class="how-to-order position-relative">
    <div class="container">
        <h2 class="main-title text-center">{!! rv($data['title']) !!}</h2>
        <div class="d-flex justify-content-center flex-wrap how-to-order__box">
            @foreach ($data['items'] as $item)
            @if ($item['title'] ?? null)
                <div class="how-to-order__item item-{{ $loop->iteration }} position-relative text-center {{ $loop->last ? 'last' : '' }}" >
                    <div class="number">
                        @if ($loop->last)
                        @svg('images/svg/last.svg')
                        @else
                        {{ $loop->iteration < 10 ? 0 : '' }}{{ $loop->iteration }}
                        @endif
                    </div>
                    <div class="text">{!! rv($item['title']) !!}</div>
                </div>
                <div class="decor-line decor-line-{{ $loop->iteration }}"></div>
            @endif
            @if ($loop->last)
            <div class="w-100"></div>
            <a href="#"
                data-toggle="modal"
                data-target="#callbackorder-pop"
                data-title="Получить консультацию"
                class="btn btn-green">
                Получить консультацию
            </a>
            @endif
            @if ($loop->iteration == 3)
                <div class="w-100 d-none d-lg-block"></div>
            @endif
            {{-- @if ($loop->iteration == 2)
            </div>
            <div class="d-flex flex-md-row-reverse justify-content-between flex-md-nowrap flex-wrap how-to-order__box">
            @endif --}}
            @endforeach
        </div>
    </div>
</section>
<!-- box-07 end more-info -->

