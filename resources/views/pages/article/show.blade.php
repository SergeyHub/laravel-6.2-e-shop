@extends('layouts.app')
@section('content')
<div class="article-page">
    <div class="container">
        @include('shared.breadcrumb')
        <main>
            <h1 class="main-title acticle-title text-center">{!! rv($title) !!}</h1>
            <div class="article-content {{ class_basename($article) == 'Blog' ? 'blog-page-content' : '' }}">
                @php
                    $promoDate = $article->date ? $article->date->format('d.m.Y') : '';
                @endphp
                @if ($article->fields && count($article->fields))
                    @foreach ($article->fields as $field)
                        @include('shared.article.field')
                    @endforeach
                @else
                {!! rv(str_replace('%date%',$promoDate,$article->body)) !!}
                @endif
                @if (class_basename($article) == 'News')
                <div class="date text-right mx-auto col-md-9">
                    {{ $article->created_at->format('d.m.Y') }}
                </div>
                @endif
            </div>
            @if (class_basename($article) == 'Promo' &&
                $others = \App\Models\Promo::where('id','!=',$article->id)
                                            ->whereStatus(1)
                                            ->orderBy('order','desc')
                                            ->take(5)
                                            ->get())
                <div class="others-promo">
                    <h2 class="main-title text-center">Другие акции</h2>
                    <div class="blog__slider js-news__slider">
                        @foreach ($others as $item)
                            @include('shared.article.teaser',['article'=>$item,'date'=>true])
                        @endforeach
                    </div>
                    <div class="blog__slider__navigate justify-content-center align-items-center js-news__slider-navigate">
                        <button type="button" class="prev icon-center nav-arrow js-news-prev">@svg('images/svg/prev.svg')</button>
                        <button type="button" class="next icon-center nav-arrow js-news-next">@svg('images/svg/next.svg')</button>
                    </div>
                </div>
            @endif
            @if (class_basename($article) == 'News' &&
                $others = \App\Models\News::where('id','!=',$article->id)
                                            ->whereStatus(1)
                                            ->orderBy('order','desc')
                                            ->take(5)
                                            ->get())
                <div class="others-promo others-news">
                    <h2 class="main-title text-center">Другие новости</h2>
                    <div class="blog__slider js-news__slider">
                        @foreach ($others as $item)
                            @include('shared.article.teaser',['article'=>$item,'date'=>true])
                        @endforeach
                    </div>
                    <div class="blog__slider__navigate justify-content-center align-items-center js-news__slider-navigate">
                        <button type="button" class="prev icon-center nav-arrow js-news-prev">@svg('images/svg/prev.svg')</button>
                        <button type="button" class="next icon-center nav-arrow js-news-next">@svg('images/svg/next.svg')</button>
                    </div>
                </div>
            @endif
        </main>
    </div>
</div>
@if (class_basename($article) == 'Blog')
    <div class="article-page__comments grey-borders position-relative">
        @include('shared.article.comments')
    </div>
@endif
@endsection
