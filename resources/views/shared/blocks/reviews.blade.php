<!-- box-08 begin reviews -->
<section class="reviews">
    <a name="box-08" id="box-08"></a>
    <div class="container">
        <h2 class="main-title text-center">{!! rv($data['title']) !!}</h2>
        @php
            $reviews = \App\Models\Review::select("reviews.*")->join("products","reviews.product_id","=","products.id")->where("products.status",1)->where('reviews.status',1)->orderBy('reviews.created_at')->get()
        @endphp
        <div class="reviews__slider__wrapper position-relative">
            <button type="button" class="slick-prev icon-center slick-arrow js-review-prev" style=""><svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 2L2 7L7 12" stroke="#F4364C" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>
            <button type="button" class="slick-next icon-center slick-arrow js-review-next" style=""><svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 12L7 7L2 2" stroke="#F4364C" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>
            <div class="reviews__slider">
                @foreach ($reviews as $item)
                <div class="reviews__item text-center">
                    <div class="js-review_item reviews__item__in">
                        <img class="reviews__item__image mx-auto lazy" src="{{ asset($item->image ? $item->image : 'images/icons/avatar.png') }}" alt="{{ rv($item->name) }}">
                        <div class="reviews__item__title">{!! rv($item->name) !!}</div>
                        <div class="reviews__item__content">
                            <div class="description">
                                <p>
                                    {!! rv($item->shortDescription()) !!}
                                    @if ($item->addDescription())
                                        <span class="add_description js-add_description d-none">
                                            {!! rv($item->addDescription()) !!}
                                        </span>
                                    @endif
                                </p>

                            </div>

                            <a href="#" class="read-more js-more__link js-more__link-review">Читать полностью</a>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="reviews__slider__nav-second d-flex justify-content-center align-items-center">
            <button type="button" class="prev icon-center nav-arrow js-review-prev">@svg('images/svg/prev.svg')</button>
            <button type="button" class="next icon-center nav-arrow js-review-next js-review-next-small">@svg('images/svg/next.svg')</button>
        </div>
    </div>
</section>
<!-- box-08 end reviews -->
