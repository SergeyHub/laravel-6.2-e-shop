@extends('layouts.app')
@section('content')
<div class="success-page position-relative">
    <div class="container">
        @include('shared.breadcrumb')
        <div class="row">
            <div class="col-lg-6 offset-xl-2 px-lg-0">
                <h1 class="main-title">{!! rv($title) !!}</h1>
                <div class="first-screen__image__wrapper overflow-hidden d-lg-none">
                    <img class="first-screen__image d-block mx-auto" src="/images/project/boy-6.png" alt="">
                </div>
                <div class="success__info d-flex align-items-center">
                    <div class="icon icon-center flex-shrink-0">
                        @svg('images/svg/phone-big.svg')
                    </div>
                    <div class="success__info__text">
                        <p>
                            @if ($order->fio)
                            <strong>{{ $order->fio }},</strong> спасибо,
                            @else
                            Спасибо,
                            @endif
                            что выбрали наш интернет-магазин!</p>
                        <p>В ближайшее время мы свяжемся с Вами по телефону: <strong class="text-nowrap">{{ $order->phone }}</strong></p>
                    </div>
                </div>
                @if ($order->delivery != 'quick')
                <div class="success__info d-flex align-items-center">
                    <div class="icon icon-center flex-shrink-0">
                        @svg('images/svg/map-pin.svg')
                    </div>
                    @if ($order->delivery == 'pickup')
                    <div class="success__info__text">
                        <p>Заказ можно забрать в пункте выдачи заказов:</p>
                        <p><strong>
                            @if (currentCity())
                            г. {{ currentCity()->name }}
                            {{ getAddress() }}
                            @endif
                            </strong>
                        </p>
                    </div>
                    @elseif ($order->delivery == 'address' || $order->delivery == 'post')
                    <div class="success__info__text">
                        <p>Заказ будет доставлен на указанный Вами адрес:</p>
                        <p><strong>
                            @if (currentCity())
                            г. {{ currentCity()->name }},
                            @endif
                            {{ $order->address }}
                            </strong>
                        </p>
                    </div>
                    @endif
                </div>
                @endif
                <div class="success__confirm">
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <div class="icon icon-center flex-shrink-0">
                            @svg('images/svg/ok-sircle-big.svg')
                        </div>
                        <div class="text-wrapper">
                            <div class="title">Итого: <span class="total"> {{ nf($order->price) }} {{ currency() }}</span></div>
                            <div class="text">Будем рады видеть Вас снова!</div>
                        </div>
                    </div>
                    <a href="/" class="btn btn-light p-0">Вернуться на сайт</a>
                </div>
            </div>
            <div class="col-lg-4 position-relative d-none d-lg-block custom-height">
                <img class="success-page__image position-absolute" src="/images/project/boy-6.png" alt="">
            </div>
        </div>
    </div>
</div>

@endsection
