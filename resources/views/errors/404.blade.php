@php
    meta()
        ->clear()
        ->using('404')
        ->using([
               'title'=>'Страница не найдена | '.request()->getHost(),
           ]);
@endphp

@extends('layouts.app')
@section('content')
    <div class="error404">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb d-none d-sm-flex">
                    <li class="breadcrumb-item ">
                        <a href="/">@svg('images/svg/house.svg')</a>
                    </li>
                    <li class="breadcrumb-item active ">
                        404
                    </li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-lg-6 offset-xl-1 px-lg-0">
                    <div class="error404__in">
                        <h1 class="main-title">404 ошибка</h1>
                        <div class="first-screen__image__wrapper overflow-hidden d-lg-none">
                            <img class="first-screen__image d-block mx-auto" src="/images/project/boy-8.png" alt="">
                        </div>
                        <div class="success__info d-flex align-items-center">
                            <div class="icon icon-center flex-shrink-0">
                                @svg('images/svg/error-icon.svg')
                            </div>
                            <div class="success__info__text">
                                Страница, которую Вы ищете, не существует либо устарела.
                            </div>
                        </div>
                        <div class="d-flex flex-wrap justify-content-center justify-content-lg-start">
                            <a class="btn btn-light mb-3" href="{{url()->previous()}}">Вернуться назад</a>
                            <a class="btn mb-3" href="/">На главную</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block position-relative custom-height">
                    <img class="error404__image position-absolute" src="/images/project/boy-8.png" alt="Ошибка 404">
                </div>
            </div>
        </div>
    </div>

@endsection
