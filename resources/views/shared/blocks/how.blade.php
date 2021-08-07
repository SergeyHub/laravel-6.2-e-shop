<!-- box-11 begin how -->
<section class="delivery advantage position-relative">
    <a name="box-11" id="box-11"></a>
    <div class="container">
        <h2 class="main-title text-center">{!! rv($data['title']) !!}</h2>
        <div class="row justify-content-around position-relative">
            @foreach ($data['items'] as $item)
            <div class="col-lg-4 col-md-6">
                <div class="advantage__item text-center d-flex flex-column justify-content-between h-100 mb-0">
                    <div>
                        <div class="image__wraper icon-center mx-auto">
                            @switch($loop->index)
                                @case(0)
                                @svg('images/svg/map-big.svg')

                                    @break
                                @case(1)
                                <img class="lazy p-1" width="98" data-src="/images/icons/cdek.svg" alt="">
                                    @break
                                @case(2)
                                <img class="lazy p-2" width="98" data-src="/images/icons/post-icon.svg" alt="">
                                    @break
                                @default

                            @endswitch

                        </div>
                        <div class="text__wrapper mx-auto">
                            <div class="text-lg">{!! rv($item['title']) !!}</div>
                            <div class="text-sm">{!! rv($item['description']) !!}</div>
                        </div>
                    </div>
                    <a class="delivery__link" @if ($loop->index) href="{{ ppId(6) }}#delivery-page__tabs-03" @else data-toggle="modal" data-target="#city-list" href="#" @endif >{{ $loop->index ? 'Подробнее' : 'Выбрать город' }}</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- box-11 end how -->
