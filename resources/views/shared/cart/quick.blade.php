<form action="{{ route('quick') }}/" method="post" class="buy-item quick-product js-form__quick-cart">
    @csrf
    <div class="d-flex align-items-center flex-wrap justify-content-between">
        <div class="d-flex align-items-center flex-wrap buy-item__product">
            <div class="buy-item__image">
                <a class="d-block buy-item__image__link" href="#">
                    <img class="mw-100 mh-100" src="{{ asset($product->getImage()) }}" alt="{{ rv($product->name) }}">
                </a>
            </div>
            <div class="w-100 d-lg-none"></div>
            <a class="buy-item__name d-block" href="{{ $product->getUrl() }}" >{!! rv($product->name) !!}</a>
        </div>
        <div class="d-flex align-items-center price-wrapper mr-lg-4">
            <div class="plusminus d-flex align-items-center js-plusminus">
                <span class="minus js-minus js-up">-</span>
                <input type="hidden" name="id" value="{{ $product->id }}">
                <input type="text" name="count" value="{{ $count }}" readonly>
                <span class="plus js-plus js-up ">+</span>
            </div>
            <div class="d-flex align-items-center flex-column flex-sm-row">
                @if ($product->getPrice(0))
                    <div class="old-price">{{ number_format($product->getPrice(0)*$count,0,'.',' ') }}<span class="currency"> {{ currency() }}</span></div>
                @endif
                <div class="price-sum">
                    {{ number_format($product->getPrice()*$count,0,'.',' ') }} <span class="currency">{{ currency() }}</span>
                </div>
            </div>
        </div>
    </div>
</form>
