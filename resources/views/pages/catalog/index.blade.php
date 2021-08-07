@extends('layouts.app')
@section('content')
    <section class="catalog catalog-page position-relative pt-0" id="catalog">
        <div class="container">
            @include('shared.breadcrumb')
            <h1 class="main-title text-center js-catalog-heading">{!! rv($pageTitle) !!}</h1>
            <a class="filters__mobile__btn btn btn-sm btn-light d-lg-none w-100 js-filters__mobile__btn" href="#">
                <span class="icon">@svg('images/svg/filter-mobile.svg')</span>
                Фильтры и сортировка
            </a>
            <div class="filters__mobile fixed-top d-lg-none d-none js-filters__mobile">
                <div class="container">
                    <div class="close position-absolute js-filters__mobile__btn">
                        <img class="lazy" alt="Закрыть" src="/images/svg/close.svg"
                             style="">
                    </div>
                    <h2 class="filters__mobile__title text-center">Фильтры</h2>
                    <div class="mb-4 js-catalog-controls js-catalog__mobile">
                        @include("pages.catalog._partials.controls")
                    </div>
                    <div class="js-catalog-filter js-catalog__mobile">
                        @include("pages.catalog._partials.filters")
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-4 d-none d-lg-block">
                    <div class="filters-heading d-flex align-items-end mb-4"><strong>Фильтры</strong></div>
                    <div class="js-catalog-filter js-catalog__desktop">
                        @include("pages.catalog._partials.filters")
                    </div>

                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="d-lg-flex justify-content-between align-items-end mb-4 d-none">
                        <div class="filters-heading d-flex align-items-end js-catalog-count">Найдено товаров: <strong
                                    class="ml-2">
                                {{filters()->count}}</strong></div>
                        <div class="js-catalog-controls js-catalog__desktop">
                            @include("pages.catalog._partials.controls")
                        </div>
                    </div>
                    <div class="row catalog__list js-catalog-list">
                        @include('shared.product.teasers')
                    </div>
                    <div class="js-catalog-paginate">
                        @include("pages.catalog._partials.pagination")
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript" src="{{asset("/js/catalog-handler.js")}}"></script>
    @php
        if ($category->id ?? null) {
            $sets = $category->sets;
        } else {
            $sets = \App\Models\Set::orderBy('order')->where('status',1)->get();
        }
    @endphp
    {{--@if ($sets->count())
    <div class="catalog-selection grey-borders position-relative">
        <div class="container">
            <h2 class="main-title text-center">Подборки</h2>
            <div class="catalog-selection__list d-flex justify-content-center flex-wrap">
                @foreach ($sets as $set)
                <a class="catalog-selection__link"  href="{{ $set->getUrl() }}">{{ $set->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
    @endif--}}
@endsection
