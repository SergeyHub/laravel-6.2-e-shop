@php
    $data = [
        'text' => 'Второй этап развития Hatchimals ',
        'items' => [
            ['image' => '/images/project/step-1.png','image_alt' => 'first.jpg','text'=> 'text 1'],
            ['image' => 'first.jpg','image_alt' => 'first.jpg','text'=> 'text 2'],

        ],
    ]
@endphp
<!-- box-05 begin steps-->
<section class="unpacking">
    <div class="container">
        <h2 class="main-title text-center">Как развивается <span>Hatchimals?</span></h2>
        <div class="row">
            <div class="col-md-6">
                <div class="unpacking__image">
                    @foreach ($data['items'] as $key => $item)
                        @isset($item['image'])
                        <img class="{{ $key ? 'd-none ':'' }}js-unpacking__box lazy js-unpacking__box__text-{{ $key }}" data-src="{{ asset($item['image']) }}" alt="{{ rv($item['image_alt']) }}">
                        @endisset
                    @endforeach
                    <ul class="unpacking__links position-absolute w-100 h-100 list-unstyled ">
                        @foreach ($data['items'] as $key => $item)
                        <li><a data-target=".js-unpacking__box__text-{{ $key }}" class="js-choose {{ !$key?'active':'' }}" href="#">{{ $key+1 }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="unpacking__box box-field">

                    @foreach ($data['items'] as $key => $item)
                    <div class="{{ $key ? 'd-none ':'' }}unpacking__box__text js-unpacking__box js-unpacking__box__text-{{ $key }}">
                        {!! rv($item['text']) !!}
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>
</section>
