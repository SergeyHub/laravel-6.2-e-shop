<div class="container">
    <div class="additionals-block">
        <h2 class="main-title text-center">{!! rv($title) !!}</h2>
        <div class="additionals-block__slider__wrapper">
            <div class="additionals-block__slider js-additionals__slider">
                @foreach ($prs as $pr)
                <div class="additionals-block__slider__item js-slider-item">
                    @include('shared.product.teaser',['product'=>$pr])
                </div>
                @endforeach
            </div>
            <div class="blog__slider__navigate justify-content-center align-items-center js-additionals__slider-navigate">
                <button type="button" class="prev icon-center nav-arrow js-slider-prev">@svg('images/svg/prev.svg')</button>
                <button type="button" class="next icon-center nav-arrow js-slider-next">@svg('images/svg/next.svg')</button>
            </div>
        </div>
    </div>
</div>
