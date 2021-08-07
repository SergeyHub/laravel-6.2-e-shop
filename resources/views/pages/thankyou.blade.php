@extends('layouts.app')
@section('content')
<div class="thankyou success-page">
    <div class="container">
        @include('shared.breadcrumb')
        <div class="row">
            <div class="col-lg-6 offset-xl-2 px-lg-0">
                <h1 class="main-title">{!! rv($title) !!}</h1>
                <div class="first-screen__image__wrapper overflow-hidden d-lg-none">
                    <img class="first-screen__image d-block mx-auto" src="/images/project/boy-7.png" alt="">
                </div>
                <div class="thankyou__content">
                    <div class="success__info d-flex ">
                        <div class="icon icon-center flex-shrink-0">
                            @svg('images/svg/phone-big.svg')
                        </div>
                        <div class="success__info__text">
                            <p><strong>{{ $callback->name }},</strong> спасибо, что выбрали наш интернет-магазин!</p>
                            <p>В ближайшее время мы
                                @if ($callback->phone)
                                свяжемся с Вами по телефону:
                                <strong class="text-nowrap">{{ $callback->phone }}</strong> и поможем выбрать подходящий товар.</p>
                                @else
                                отправим Вам ответ на email: <strong>{{ $callback->email }}</strong>
                                @endif
                        </div>
                    </div>
                    <a class="btn btn-light btn-green thankyou__btn p-0" href="/">Вернуться на сайт</a>
                </div>
            </div>
            <div class="col-lg-4 position-relative d-none d-lg-block">
                <img class="success-page__image position-absolute" src="/images/project/boy-7.png" alt="">
            </div>
        </div>
    </div>
</div>
@endsection
