@extends('layouts.app')
@section('content')
<div class="bg-light-decorate">
    <div class="container">
        @include('shared.breadcrumb')
        <main>
            <h1 class="main-title acticle-title text-center">{!! rv($title) !!}</h1>
            <div class="article-content">
                @if ($page->data && count($page->data))
                    @foreach ($page->data as $field)
                        @include('shared.article.field')
                    @endforeach
                @else
                {!! rv($page->body) !!}
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
