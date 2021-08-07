<!-- box-05 begin how-to-order -->
<section class="how-to-order">
    <div class="container position-relative">
        <h2 class="main-title text-uppercase text-center">{!! rv($data['title']) !!}</h2>
        <div class="row">
            <img class="how-to-order__image position-absolute lazy" data-src="{{ asset($data['image']) }}" alt="{{ rv($data['image_alt']) }}">
            <div class="col-xl-10 offset-xl-2">
                <div class="how-to-order__list">
                    @foreach ($data['items'] as $item)

                    <div class="how-to-order__item position-relative">
                        <div class="image__wrapper d-flex justify-content-center mx-auto">
                            <img class="align-self-center lazy" data-src="{{ $item['image'] }}" alt="{{ rv($item['image_alt']) }}">
                        </div>
                        <div class="caption text-uppercase text-center"><span>{!! rv($item['text']) !!}</span></div>
                        @if (!$loop->last)
                        <div class="separator position-absolute"></div>
                        @endif
                    </div>
                    @endforeach
                    <div class="clearfix"></div>
                </div>
                <a class="btn btn-light-shadow text-uppercase mx-auto" href="{{ route('catalog.show') }}" {{-- data-toggle="modal" data-target="#thankfulness-pop" --}}>
                    <span class="icon">
                        <img class="lazy" data-src="/images/icons/arrow-point-to-right.png" alt="">
                    </span>
                    <span class="txt">оформить заказ</span>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- box-05 end how-to-order -->
