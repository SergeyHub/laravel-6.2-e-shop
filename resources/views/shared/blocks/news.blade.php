<!-- box-08 begin news -->
@php
    $blogs = \App\Models\News::where('status',1)
                ->whereDate('created_at','<=',\Carbon\Carbon::Now())
                ->orderBy('order','desc')
                ->limit($data['count'])
                ->get();
    $date = true;
@endphp
@if ($blogs->count())
<section class="blog news position-relative">
    <div class="container">
        <h2 class="main-title text-center">{!! rv($data['title']) !!}</h2>
        <div class="blog__slider position-relative js-news__slider">
            @forelse ($blogs as $article)
                @include('shared.article.teaser')
            @endforeach
        </div>
        <div class="blog__slider__navigate justify-content-center align-items-center js-news__slider-navigate">
            <button type="button" class="prev icon-center nav-arrow js-news-prev">@svg('images/svg/prev.svg')</button>
            <button type="button" class="next icon-center nav-arrow js-news-next">@svg('images/svg/next.svg')</button>
        </div>
    </div>
</section>
@endif
<!-- box-08 end news -->
