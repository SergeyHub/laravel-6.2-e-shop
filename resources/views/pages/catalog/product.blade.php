@extends('layouts.app')
@section('content')

<div class="product-page position-relative">
    <div class="container">
        @include('shared.breadcrumb')
        <div class="product-card">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="product-card__title d-lg-none text-center">{!! rv($product->name) !!}</h2>
                    <div class="photo-big__wrapper position-relative">
                        <button type="button" class="slick-prev icon-center slick-arrow product-slick-prev js-product-slick-prev"><svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 2L2 7L7 12" stroke="#F4364C" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                        <button type="button" class="slick-next icon-center slick-arrow product-slick-next js-product-slick-next"><svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 12L7 7L2 2" stroke="#F4364C" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                        <div class="photo-big h-100">
                            @foreach ($product->visibleImages ?? [] as $key => $image)
                            <div class="photo-big__item">
                                <a href="{{ asset($image) }}" class="d-flex h-100" data-lightbox="product-{{ $product->id }}">
                                    <img class="m-auto mw-100 mh-100" src="{{ asset($image) }}" alt="{{ rv($product->getAlt($key)) }}">
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <div class="photo-big__numbers position-absolute">
                            <span class="current js-photo-big-current">01</span>
                            <span class="total">/{{ count($product->visibleImages ?? []) > 9 ? '' : '0'  }} {{ count($product->visibleImages ?? []) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h1 class="product-card__title d-none d-lg-block">{!! rv($product->name) !!}</h1>
                    <form action="{{ route('cart.set') }}/" method="post" class="product-card__form js-form__to-cart">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <div class="d-flex align-items-center plusminus__wrapper">
                            <div class="plusminus d-flex align-items-center js-plusminus">
                                <span class="minus js-minus">-</span>
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="text" name="count" class="js-product-count" data-price="{{ $product->getPrice() }}" data-old_price="{{ $product->getPrice(0) }}" id="" value="1" readonly>
                                <span class="plus js-plus">+</span>
                            </div>
                            @if ($product->getPrice(0))
                                <div class="old-price align-self-end">
                                    {{ number_format($product->getPrice(0),0,'.',' ') }}
                                    <span class="currency small"> {{ currency() }}</span>
                                </div>
                            @endif
                            <div class="price-sum">
                                <span class="js-product-sum">{{ nf($product->getPrice()) }}</span>
                                <span class="currency small">{{ currency() }}</span>
                            </div>
                        </div>
                        <div class="d-flex product-card__form__buttons justify-content-between flex-wrap">
                            @if(!$product->under_order)
                                <button class="btn" type="submit">
                                    <span class="icon">@svg('images/svg/basket-icon.svg')</span>
                                    В корзину
                                </button>
                                <a class="btn btn-light js-quick-btn" data-id="{{ $product->id }}" href="{{ route('quick',['id'=>$product->id]) }}">
                                    Купить в 1 клик
                                </a>
                            @else
                                <a class="btn btn-under-order-card"  onclick="callOrderQTYPopup('{{$product->id}}')">
                                    Под заказ
                                </a>

                            @endif


                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-4 col-6">
                            <div class="product-card__block">
                                <div class="product-card__block__icon image__wraper icon-center">
                                    @svg('images/svg/map-pin.svg')
                                </div>
                                <h3 class="product-card__block__title">В наличии:</h3>
                                <div class="product-card__block__text">
                                    @if (currentCity())
                                    <p>{{ currentCity()->name }}</p>
                                    <p>{{ currentCity()->address }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="product-card__block">
                                <div class="product-card__block__icon image__wraper icon-center">
                                    @svg('images/svg/wallet.svg')
                                </div>
                                <h3 class="product-card__block__title">Способы оплаты:</h3>
                                <div class="product-card__block__text">
                                    <ul class="list-unstyled product-card__block__list mb-0 mt-0">
                                        <li>Оплата при получении</li>
                                        <li>Безналичный расчет</li>
                                        <li>По счету для юр. лиц</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6 mx-auto">
                            <div class="product-card__block">
                                <div class="product-card__block__icon image__wraper icon-center">
                                @svg('images/svg/share.svg')
                                </div>
                                <h3 class="product-card__block__title">Поделиться:</h3>
                                <div class="product-card__block__text social__wrapper">
                                    <div class="social-likes social-likes_notext product-card__social d-flex social-icon">
                                        <div class="soc-icon facebook" href="#">@svg('images/svg/fb-logo.svg')</div>
                                        <div class="soc-icon vkontakte" href="#">@svg('images/svg/vk-logo.svg')</div>
                                        <div class="soc-icon twitter" href="#">@svg('images/svg/twitter-logo.svg')</div>
                                        <div class="soc-icon odnoklassniki" href="#">@svg('images/svg/ok-logo.svg')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-description">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs d-flex nav-fill nav-tabs__custom">
                @if ($product->description)
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#" data-target="#product-desc-01">Описание</a>
                </li>
                @endif
                @if ($product->feature)
                <li class="nav-item">
                    <a class="nav-link {{ $product->description ? '' : 'active' }}" data-toggle="tab" href="#" data-target="#product-desc-02">Характеристики</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ ($product->description || $product->feature) ? '' : 'active' }}" data-toggle="tab" href="#" data-target="#product-desc-03">Отзывы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#" data-target="#product-desc-04">Вопрос-ответ</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                @if ($product->description)
                <div class="tab-pane active" id="product-desc-01">
                    <div class="col-xl-8 col-lg-10 px-lg-0 mx-auto">
                        {!! rv($product->description) !!}
                    </div>
                </div>
                @endif
                @if ($product->feature)
                <div class="tab-pane {{ $product->description ? 'fade' : 'active' }} " id="product-desc-02">
                    <div class="col-xl-8 col-lg-10 mx-auto">
                        <div class="table__wrapper">
                            <table class="table">
                                <tbody>
                                    @php
                                        $items = explode("\n",$product->feature)
                                    @endphp
                                    @foreach($items as $item)
                                        @php
                                            $col = explode('|',$item)
                                        @endphp
                                        <tr>
                                            <td class="caption">{{ rv(trim($col[0])) }}</td>
                                            <td >{{isset($col[1])?rv(trim($col[1])):''}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
                <div class="tab-pane {{ ($product->description || $product->feature) ? 'fade' : 'active' }}" id="product-desc-03">
                    @if ($product->reviews->where('status',1)->count())
                    @foreach ($product->reviews->where('status',1)->sortBy('created_at') as $review)
                    <div class="product-description__review {{ $loop->last ? 'last' : '' }}">
                        <div class="col-xl-8 col-lg-10 px-lg-0 mx-auto">
                            <div class="d-flex align-items-start">
                                <div class="review__icon">
                                    <img class="rounded-circle" src="{{ asset($review->image ? $review->image : '/images/project/review-avatar.jpg') }}"
                                    alt="{{ $review->name }}">
                                </div>
                                <div>
                                    <div class="review__date">{{ $review->created_at->format('d.m.Y') }}</div>
                                    <h3 class="review__title">{!! rv($review->name) !!}</h3>
                                    <div class="review__text">{!! rv($review->message_full) !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="product-description__review__empty-text mx-auto text-center">
                        <img class="image d-block mx-auto" src="/images/project/review-empty.png" alt="">
                        На данный момент у товара нет отзывов. Оставьте свой отзыв, чтобы стать первым!
                    </div>
                    @endif
                    <div class="col-xl-8 col-lg-10 px-0 mx-auto">
                        <form action="{{ route('reviews.add') }}/" method="POST" class="review__form js-review__form">
                            {{captcha()->inputs}}
                            <h3 class="review__form__title text-center">Оставить отзыв о товаре</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label class="form-label" for="review-form-name">* Ваше имя</label>
                                        <div class="form-control__wrapper">
                                            <input class="form-control" id="review-form-name" type="text" name="name" placeholder="Введите имя" required="required">
                                        </div>
                                        <span class="icon position-absolute">
                                            @svg('images/svg/user.svg')
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label class="form-label" for="review-form-tel">* Ваш телефон</label>
                                        <div class="form-control__wrapper">
                                            <input class="form-control" id="review-form-tel" type="tel" name="phone" placeholder="+7" required="required">
                                        </div>
                                        <span class="icon position-absolute">
                                            @svg('images/svg/call-answer.svg')
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group position-relative">
                                        <label class="form-label"
                                                for="review-form-message">* Ваш отзыв
                                        </label>
                                        <div class="form-control__wrapper">
                                            <textarea class="form-control"
                                                    id="review-form-message"
                                                    name="message"
                                                    placeholder="Введите текст вашего отзыва"
                                                    rows="3"
                                                    required="required"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-none">
                                    <label for="review-agreement">
                                        <input type="checkbox" name="agreement" id="review-agreement">
                                        Я согласен с политикой.
                                    </label>
                                </div>
                                <div class="w-100"></div>
                                <input type="hidden" name="type" value="Отправить отзыв">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                {{ csrf_field() }}
                                <button type="submit" class="btn mx-auto">Отправить</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="product-desc-04">
                    @forelse ($product->questions->where('status',1) as $question)
                    <div id="question-{{ $question->id }}" class="product-description__review {{ $loop->last ? 'last' : '' }}">
                        <div class="col-xl-8 col-lg-10 px-lg-0 mx-auto">
                            <div class="d-flex align-items-start">
                                <div class="review__icon">
                                    <img class="rounded-circle" src="/images/project/review-avatar.jpg"
                                    alt="{{ $question->name }}">
                                </div>
                                <div>
                                    <div class="review__date">{{ $question->created_at->format('d.m.Y') }}</div>
                                    <h3 class="review__title">{!! rv($question->name) !!}</h3>
                                    <div class="review__text">{{ rv($question->question) }}</div>
                                </div>
                            </div>
                            @if ($question->answer)
                            <div class="question__answer">
                                <div class="d-flex align-items-start">
                                    <div class="review__icon">
                                        <img class="rounded-circle img-fluid" src="{{ asset($question->image ? $question->image : cv('answer_icon')) }}"
                                        alt="Представить магазина">
                                    </div>
                                    <div>
                                        <h3 class="review__title">{{ cv('answer_name') }}</h3>
                                        <div class="review__text">{!! rv($question->answer) !!}</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="product-description__review__empty-text mx-auto text-center">
                        <img class="image d-block mx-auto" src="/images/project/review-empty.png" alt="">
                        На данный момент по этому товару не задавали вопросы. Оставьте свой вопрос, чтобы стать первым!
                    </div>
                    @endforelse
                    <div class="col-xl-8 col-lg-10 px-0 mx-auto">
                        <form action="{{ route('questions.add') }}/" method="POST" class="review__form js-review__form1">
                            {{captcha()->inputs}}
                            <h3 class="review__form__title text-center">Оставить вопрос о товаре</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label class="form-label" for="questions-form-name">* Ваше имя</label>
                                        <div class="form-control__wrapper">
                                            <input class="form-control" id="questions-form-name" type="text" name="name" placeholder="Введите имя" required="required">
                                        </div>
                                        <span class="icon position-absolute">
                                            @svg('images/svg/user.svg')
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label class="form-label" for="questions-form-email">* Ваш e-mail</label>
                                        <div class="form-control__wrapper">
                                            <input class="form-control" id="questions-form-email" type="email" name="email" placeholder="Введите e-mail" required="required">
                                        </div>
                                        <span class="icon position-absolute">
                                            @svg('images/svg/email.svg')
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group position-relative">
                                        <label class="form-label"
                                                for="questions-form-message">* Ваш вопрос
                                        </label>
                                        <div class="form-control__wrapper">
                                            <textarea class="form-control"
                                                    id="questions-form-message"
                                                    name="message"
                                                    placeholder="Введите текст вашего вопроса"
                                                    rows="3"
                                                    required="required"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-none">
                                    <label for="questions-agreement">
                                        <input type="checkbox" name="agreement" id="questions-agreement">
                                        Я согласен с политикой.
                                    </label>
                                </div>
                                <div class="w-100"></div>
                                <input type="hidden" name="type" value="Отправить отзыв">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                {{ csrf_field() }}
                                <button type="submit" class="btn mx-auto ">Отправить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="w-100"></div>
        </div>
    </div>
</div>
<div class="additionals-blocks">
    @if ($product->similar->where('status',1)->count())
        @include('shared.product.slider',
            [
                'title' => 'Похожие товары',
                'first' => true,
                'prs'   => $product->similar->where('status',1)->sortBy('order')
            ])
    @endif
    @if ($product->recommends->where('status',1)->count())
        @include('shared.product.slider', [
                'title'=>'Рекомендуем также',
                'prs'=> $product->recommends->where('status',1)->sortBy('order')
            ])
    @endif
    @if ($product->buywith->where('status',1)->count())
        @include('shared.product.slider', [
                'title'=>'С этим товаром покупают',
                'prs'=> $product->buywith->where('status',1)->sortBy('order')
            ])
    @endif
</div>
@endsection
@section('scripts')
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('libs/lightbox2/dist/css/lightbox.min.css') }}" />
<script src="{{ asset('libs/lightbox2/dist/js/lightbox.min.js') }}"></script>
<script>
    lightbox.option({
      'wrapAround': true
    })
</script>
@endsection
