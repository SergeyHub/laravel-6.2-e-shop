<!-- box-05 begin blog -->
@php
    $blogs = \App\Models\Blog::where('status',1)->whereDate('created_at','<=',\Carbon\Carbon::Now())->orderBy('order')->limit($data['count'])->get()
@endphp
@if ($blogs->count())
<section class="blog position-relative grey-borders">
    <div class="container">
        <h2 class="main-title text-center">{!! rv($data['title']) !!}</h2>
        <div class="blog__slider position-relative js-blog__slider">
            @forelse ($blogs as $article)
                @include('shared.article.teaser')
            @endforeach
        </div>
        <div class="blog__slider__navigate justify-content-center align-items-center js-blog__slider-navigate">
            <button type="button" class="prev icon-center nav-arrow js-blog-prev">@svg('images/svg/prev.svg')</button>
            <button type="button" class="next icon-center nav-arrow js-blog-next">@svg('images/svg/next.svg')</button>
        </div>
    </div>
</section>
@endif
<!-- box-05 end blog -->
