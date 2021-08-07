<!-- box-02 begin types -->
<section class="types position-relative">
    <div class="container">
        <h2 class="main-title text-center">{!! rv($data['title'] ?? '') !!}</h2>
        <div class="row">
            <div class="col-lg-6 col-md-4">
                <img class="types__image img-fluid" src="{{ asset($data['image']) }}" alt="{{ rv($data['title'] ?? '') }}">
            </div>
            <div class="col-lg-6 col-md-8 d-flex">
                <div class="types__in my-auto ml-auto js-types">
                    <div class="types__tabs">
                        <ul class="nav nav-tabs nav-tabs__custom nav-fill">
                            @foreach ($data['items'] ?? [] as $item)
                            <li class="nav-item">
                                <a class="nav-link js-type-link {{ $loop->first ? 'active' : '' }}" id="js-type-link-{{ $loop->iteration }}" data-toggle="tab" href="#" data-target="#main-types__tabs-{{ $loop->iteration }}">0{{ $loop->iteration }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="tab-content">
                        @foreach ($data['items'] ?? [] as $item)
                        <div class="tab-pane js-type-item {{ $loop->first ? 'active' : '' }}" data-num="{{ $loop->iteration }}" id="main-types__tabs-{{ $loop->iteration }}">
                            <div class="types__item d-flex align-items-center">
                                <div class="types__item__icon icon-center flex-shrink-0">
                                    <div class="d-none d-md-block">@svg('images/svg/info-icon.svg')</div>
                                    <div class="d-md-none number">0{{ $loop->iteration }}</div>
                                </div>
                                <div class="types__item__description">
                                    {!! rv($item['description'] ?? '') !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="types__image mx-auto position-relative">
            <img class="product d-block mx-auto" src="{{ asset($data['image']) }}" alt="{{ rv($data['title'] ?? '') }}">
               @foreach ($data['items'] ?? [] as $item)
                <div class="position-absolute
                            js-types-link
                            cursor-pointer
                            types__item
                            types__item-{{ $loop->iteration }}
                            types__item-{{ ($loop->iteration % 2) ? 'left' : 'right' }}
                            types__item-row-{{ ((int) ($loop->index / 2))+1 }}">
                    <div class="types__item__icon">
                        @include('svg.types.'.$loop->iteration)
                    </div>
                    <div class="types__item__title">{!! rv($item['title'] ?? '') !!}</div>
                    <div class="types__item__description">{!! rv($item['description'] ?? '') !!}</div>
                    <div class="types__item__circle"></div>
                </div>
                @endforeach
        </div> --}}
    </div>
</section>
<!-- box-02 end types -->
