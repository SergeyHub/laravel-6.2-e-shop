@extends('layouts.app')
@section('content')
    <section class="blog-page" >
    <div class="container">
        @include('shared.breadcrumb')
        <h1 class="main-title text-center">{!! rv($title) !!}</h1>
        <div class="d-flex flex-wrap blog-page__list">
        @forelse ($articles as $article)
            @include('shared.article.teaser')
        @endforeach
        </div>
        {{ $articles->links() }}
    </div>
</section>
@endsection
