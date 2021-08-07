<!-- box-06 begin  advantage-->
<section class="advantage position-relative">
    <a name="box-06" id="box-06"></a>
    <div class="container">
        <h2 class="main-title text-center">{!! rv($data['title']) !!}</h2>
        <div class="row justify-content-around position-relative">
            @for ($i = 0; $i < 3; $i++)
            @isset($data['items'][$i]['text'])
            <div class="col-lg-4 col-md-6">
                <div class="advantage__item">
                    <div class="image__wraper icon-center mx-auto">
                        <img data-src="{{ asset($data['items'][$i]['image']) }}"  class="lazy img-fluid" alt="{{ rv($data['items'][$i]['image_alt']) }}">
                    </div>
                    <div class="text-lg text-center">
                        {!! rv($data['items'][$i]['title']) !!}
                    </div>
                    <div class="text-sm text-center">{!! rv($data['items'][$i]['text']) !!}</div>
                </div>
            </div>
            @endisset
            @endfor
        </div>
    </div>
</section>
<!-- box-06 end advantage-->

