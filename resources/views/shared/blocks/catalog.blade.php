<!-- begin catalog -->
<section class="catalog position-relative">
    <a id="catalog"></a>
    <div class="container">
        <h2 class="main-title text-center">{!! rv($data['title'] ?? '') !!}</h2>
        <div class="catalog__list position-relative">
            <div class="row">
                @foreach (Catalog::getFrontProducts($data['amount'] ?? 1000) as $product)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    @include('shared.product.teaser')
                </div>
                @endforeach
            </div>
            @if (Catalog::getFrontProducts($data['amount'] ?? 1000)->count() < \App\Models\Product::where('status',1)->count())
            <a class="btn btn-light show-all mx-auto p-0" href="{{ route('catalog.show') }}/">Посмотреть все осциллографы</a>
            @endif
        </div>
    </div>
</section>
<!-- end catalog -->



