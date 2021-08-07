<!-- box-12 begin faq -->
<section class="faq position-relative">
    <a name="box-12" id="box-12"></a>
    <div class="container">
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <h2 class="main-title text-center mx-auto">{!! rv($data['title']) !!}</h2>
                <div class="faq__accordion" id="faq__accordion" itemscope itemtype="https://schema.org/FAQPage">
                    @foreach ($data['items'] as $item)
                    <div class="card position-relative {{ !$loop->index ? '-is-open' : '' }}" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <div class="faq__card-header" id="heading__0{{ $loop->index }}">
                            <div class="faq__title__wrapper position-relative
                             {{ $loop->index ? 'collapsed' : '' }}" data-toggle="collapse" data-target="#collapse__0{{ $loop->index }}" aria-expanded="true" aria-controls="collapse__0{{ $loop->index }}">
                                <div class="number position-absolute">{{ $loop->iteration < 19 ? '0' : ''}}{{ $loop->iteration}}</div>
                                <div class="faq__title d-flex align-items-center" itemprop="name">

                                    {!! rv($item['title']) !!}
                                </div>
                            </div>
                        </div>
                        <div id="collapse__0{{ $loop->index }}" class="collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading__0{{ $loop->index }}" data-parent="#faq__accordion"  itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div class="card-body" itemprop="text">
                                {!! rv($item['text']) !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- box-12 end faq -->
