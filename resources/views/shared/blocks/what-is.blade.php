<!-- box-03 begin what-is -->
<section class="what-is">
    <a name="box-02" id="box-02"></a>
    <div class="container">
        <h2 class="main-title text-center">{!! rv($data['title']) !!}<h2>
        <div class="description text-center">{!! rv($data['subtitle']) !!}</div>
        <div class="d-flex what-is__row justify-content-between flex-wrap">
            @isset($data['items'][0])
            <div class="what-is__item item-01 position-relative">
                <div class="d-flex align-items-center justify-content-center jusjustify-content-md-start">
                    <div class="number">01</div>
                    <div class="content d-flex align-items-center">
                        <div class="image__wraper position-relative d-flex">
                            <img class="m-auto lazy" data-src="{{ asset($data['items'][0]['image']) }}" alt="{{ rv($data['items'][0]['image_alt']) }}">
                            <div class="info-icon__wrapper position-absolute rounded-circle">
                                <div class="info-icon rounded-circle w-100 h-100 d-flex align-items-center
                                justify-content-center">i</div>
                            </div>
                        </div>
                        <div class="arrow d-none d-md-block"></div>
                    </div>
                </div>
                <div class="text margin-for-number"><p>{!! rv($data['items'][0]['text']) !!}</p></div>
                <div class="arrow down position-absolute d-md-none"></div>
            </div>
            @endisset
            @isset($data['items'][1])
            <div class="what-is__item item-02 position-relative order-lg-2 order-md-2">
                <div class="d-flex align-items-center justify-content-center jusjustify-content-md-start">
                    <div class="number">02</div>
                    <div class="content d-flex align-items-center">
                        <div class="image__wraper position-relative d-flex">
                            <img class="m-auto lazy" data-src="{{ asset($data['items'][1]['image']) }}" alt="{{ rv($data['items'][1]['image_alt']) }}">
                            <div class="info-icon__wrapper position-absolute rounded-circle">
                                <div class="info-icon rounded-circle w-100 h-100 d-flex align-items-center
                                justify-content-center">i</div>
                            </div>
                        </div>
                        <div class="arrow d-none d-lg-block"></div>
                    </div>
                </div>
                <div class="text order-lg-3 margin-for-number"><p>{!! rv($data['items'][1]['text']) !!}</p></div>
                <div class="arrow down position-absolute d-lg-none d-md-block"></div>
            </div>
            @endisset
            @isset($data['items'][2])
            <div class="w-100 mb-4 order-md-3 d-lg-none d-md-block d-none"></div>
            <div class="what-is__item item-03 position-relative order-lg-3 order-md-5">
                <div class="d-flex align-items-center justify-content-center jusjustify-content-md-start">
                    <div class="number order-lg-1 order-md-2">03</div>
                    <div class="content d-flex align-items-center order-lg-2 order-md-1">
                        <div class="image__wraper position-relative d-flex order-md-2">
                            <img class="m-auto lazy" data-src="{{ asset($data['items'][2]['image']) }}" alt="{{ rv($data['items'][2]['image_alt']) }}">
                            <div class="info-icon__wrapper position-absolute rounded-circle">
                                <div class="info-icon rounded-circle w-100 h-100 d-flex align-items-center
                                justify-content-center">i</div>
                            </div>
                        </div>
                        <div class="arrow left order-md-1 d-lg-none d-md-block d-none"></div>
                    </div>
                </div>
                <div class="text order-lg-3 margin-for-number"><p>{!! rv($data['items'][2]['text']) !!}</p></div>
                <div class="arrow down position-absolute d-lg-block d-md-none"></div>
            </div>
            @endisset
            @isset($data['items'][3])
            <div class="w-100 mb-4 order-lg-4 d-none d-lg-block"></div>
            <div class="what-is__item  item-04 position-relative order-lg-7 order-md-4">
                <div class="d-flex align-items-center justify-content-center jusjustify-content-md-start">
                    <div class="number order-lg-2 order-md-2">04</div>
                    <div class="content d-flex align-items-center order-lg-1 order-md-1">
                        <div class="image__wraper position-relative d-flex order-lg-2">
                            <img class="m-auto lazy" data-src="{{ asset($data['items'][3]['image']) }}" alt="{{ rv($data['items'][3]['image_alt']) }}">
                            <div class="info-icon__wrapper position-absolute rounded-circle">
                                <div class="info-icon rounded-circle w-100 h-100 d-flex align-items-center
                                justify-content-center">i</div>
                            </div>
                        </div>
                        <div class="arrow left order-lg-1 d-none d-lg-block"></div>
                    </div>
                </div>
                <div class="text order-lg-3 margin-for-arrow"><p>{!! rv($data['items'][3]['text']) !!}</p></div>
                <div class="arrow down position-absolute d-lg-none d-md-block"></div>
            </div>
            @endisset
            @isset($data['items'][4])
            <div class="w-100 mb-4 order-md-6 d-lg-none d-md-block d-none"></div>
            <div class="what-is__item  item-05 position-relative order-lg-6 order-md-7">
                <div class="d-flex align-items-center justify-content-center jusjustify-content-md-start">
                    <div class="number order-lg-2">05</div>
                    <div class="content d-flex align-items-center order-lg-1">
                        <div class="image__wraper position-relative d-flex order-lg-2">
                            <img class="m-auto lazy" data-src="{{ asset($data['items'][4]['image']) }}" alt="{{ rv($data['items'][4]['image_alt']) }}">
                            <div class="info-icon__wrapper position-absolute rounded-circle">
                                <div class="info-icon rounded-circle w-100 h-100 d-flex align-items-center
                                justify-content-center">i</div>
                            </div>
                        </div>
                        <div class="arrow d-lg-none d-md-block d-none"></div>
                        <div class="arrow left order-lg-1 d-lg-block d-none"></div>
                    </div>
                </div>
                <div class="text order-lg-3 margin-for-arrow"><p>{!! rv($data['items'][4]['text']) !!}</p></div>
                <div class="arrow down position-absolute d-md-none"></div>
            </div>
            @endisset
            @isset($data['items'][5])
            <div class="what-is__item  item-06 position-relative order-lg-5 order-md-8">
                <div class="d-flex align-items-center justify-content-center jusjustify-content-md-start">
                    <div class="number order-lg-2 order-md-1">06</div>
                    <div class="content d-flex align-items-center order-lg-1 order-md-2">
                            <div class="image__wraper position-relative d-flex">
                                <img class="m-auto lazy" data-src="{{ asset($data['items'][5]['image']) }}" alt="{{ rv($data['items'][5]['image_alt']) }}">
                                <div class="info-icon__wrapper position-absolute rounded-circle">
                                    <div class="info-icon rounded-circle w-100 h-100 d-flex align-items-center
                                    justify-content-center">i</div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="text"><p>{!! rv($data['items'][5]['text']) !!}</p></div>
            </div>
            @endisset
        </div>
    </div>
</section>
<!-- box-02 begin what-is -->
