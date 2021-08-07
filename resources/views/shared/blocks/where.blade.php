<!-- box-09 start where -->
<section class="where">
    <div class="container">
        <h2 class="main-title text-center">{!! rv($data['title']) !!}</h2>
        @foreach ($data['items'] as $item)
        <div class="where__item {{ ($loop->iteration % 2 )? 'odd' : 'even' }}">
            <div class="row no-gutters align-items-center">
                <div class="col-lg-6 order-lg-{{ ($loop->iteration % 2 )? 1 : 2 }}">
                    <img class="where__item__image where__item__image-desctop w-100 lazy" data-src="/images/project/animations/{{ $loop->iteration }}.gif" alt="{{ rv($item['title']) }}">
                    <img class="where__item__image where__item__image-mobile w-100 lazy" data-src="/images/project/animations/{{ $loop->iteration }}m.gif" alt="{{ rv($item['title']) }}">
                </div>
                <div class="col-lg-6 order-lg-{{ ($loop->index % 2 )? 1 : 2 }}">
                    <div class="where__item__content ">
                        <h4 class="where__item__content__title">{!! rv($item['title']) !!}</h4>
                        <div class="where__item__content__text">{!! rv($item['text']) !!}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
<!-- box-09 end where -->
