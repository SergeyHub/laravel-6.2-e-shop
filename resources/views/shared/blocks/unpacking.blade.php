@php
    /* $data = [
        'text' => 'Второй этап развития Hatchimals ',
        'items' => [
            ['image' => '/images/project/step-1.png','image_alt' => 'first.jpg','text'=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
            do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Ut enim ad minim veniam, quis nostrud exercitation ullamco
            '],
            ['image' => '/images/project/step-1.png','image_alt' => 'first.jpg','text'=> 'text 2'],
            ['image' => '/images/project/step-1.png','image_alt' => 'first.jpg','text'=> 'text 3'],
            ['image' => '/images/project/step-1.png','image_alt' => 'first.jpg','text'=> 'text 4'],
            ['image' => '/images/project/step-1.png','image_alt' => 'first.jpg','text'=> 'text 5'],

        ],
    ] */
@endphp
<!-- box-05 begin unpacking-->
<section class="unpacking">
    <a name="box-05" id="box-05"></a>
    <div class="container">
        <h2 class="main-title text-center">{!! rv($data['title']) !!}</h2>
        <div class="row">
            <div class="col-lg-6">
                <div class="row align-items-center h-100">
                    <div class="col-8 unpacking__image d-flex justify-content-center">
                    @foreach ($data['items'] as $key => $item)
                        @isset($item['image'])
                        <img class="{{ $key ? 'd-none ':'' }}js-unpacking__box lazy js-unpacking__box__text-{{ $key }}" data-src="{{ asset($item['image']) }}" alt="{{ rv($item['image_alt']) }}">
                        @endisset
                    @endforeach
                    </div>
                    <div class="col-4 position-relative h-100">
                        <div class="curve w-100 d-flex h-100">@include('icons.curve')</div>
                        <ul class="unpacking__links position-absolute h-100 w-100 list-unstyled">
                            @foreach ($data['items'] as $key => $item)
                            <li class="position-absolute"><a data-target=".js-unpacking__box__text-{{ $key }}" class="js-choose {{ !$key?'active':'' }}" href="#">{{ $key+1 }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="unpacking__box">

                    @foreach ($data['items'] as $key => $item)
                    <div class="{{ $loop->first ?'' : 'd-none ' }} js-unpacking__box js-unpacking__box__text-{{ $key }}">
                        <h3 class="unpacking__box__subtitle">{!! rv($item['title']) !!}</h3>
                        <div class="unpacking__box__text ">
                            {!! rv($item['text']) !!}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
