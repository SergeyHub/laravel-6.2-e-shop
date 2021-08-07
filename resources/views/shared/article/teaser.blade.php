<div class="blog-item {{ !($loop->index % 3) ? 'first' : (!(($loop->index-1) % 3) ? 'center' : 'last') }} ">
    @if ($article->image)
    <div class="blog-image">
        <a class="blog-image-link" href="{{ $article->getUrl() }}/">
            <img class="d-block w-100" src="{{ asset($article->image) }}" alt="{{ rv($article->title) }}">
        </a>
    </div>
    @endif
    <div class="blog-content">
        @if ($date ?? null)
            <div class="date">
                {{ $article->created_at->format('d.m.Y') }}
            </div>
        @endif
        <h3 class="blog-title">
            <a href="{{ $article->getUrl() }}/">{{ rv($article->title) }}</a>
        </h3>
        @if ($article->description)
        <div class="blog-short">
            {!! rv($article->description) !!}
        </div>
        @endif

    </div>
    @if ($article->date && $article->date < \Carbon\Carbon::now())
    <a class="btn btn-sm w-100 btn-muted" href="{{ $article->getUrl() }}/">Акция завершена</a>
    @else
    <a class="btn btn-sm w-100" href="{{ $article->getUrl() }}/">Прочитать</a>
    @endif
</div>
