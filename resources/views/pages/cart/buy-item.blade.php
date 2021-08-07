<form action="{{ route('cart.set') }}/" method="post" class="js-form__to-cart buy-item  p-lg-4 position-relative">
    <input type="hidden" name="cart" value="1">
    @csrf
    <div class="d-lg-flex p-lg-2">
        <div class="d-flex align-items-center d-lg-block flex-wrap buy-item__product mr-lg-4">
            <div class="buy-item__image m-lg-0">
                <a class="d-block buy-item__image__link" href="{{ $item->url }}">
                    <img class="mw-100 mh-100 d-block mx-auto" src="{{ asset($item->image) }}" alt="{{ rv($item->name) }}">
                </a>
            </div>
            <div class="buy-item__name d-lg-none pt-4 w-100">
                <a class="d-inline-block mb-1" href="{{ $item->url }}" >{!! rv($item->name) !!}</a>
            </div>
        </div>

        <div class="d-flex align-items-center price-wrapper pl-0 flex-wrap flex-grow-1">
            <div class="buy-item__name d-none d-lg-block align-self-start mw-100 mb-3 flex-grow-1 pr-lg-3">
                <a class="" href="{{ $item->url }}" >{!! rv($item->name) !!}</a>
            </div>

            <div class="w-100"></div>

            <div class="plusminus d-flex align-items-center order-lg-1 mx-lg-0 js-plusminus">
                <span class="minus js-minus js-up">-</span>
                <input type="hidden" name="id" value="{{ $item->id }}">
                <input type="text" name="count" id=""data-price="{{ $item->price }}" data-old_price="{{ $item->price_old }}" value="{{$item->count}}" readonly>
                <span class="plus js-plus js-up ">+</span>
            </div>

            <div class="prices d-flex flex-column flex-lg-row justify-content-end align-items-end flex-grow-1 py-lg-2">
                @if ($item->price_old && ($item->price_old > $item->price))
                    <div class="old-price m-0 mr-lg-3">{{ number_format($item->price_old,0,'.',' ') }}&nbsp;<span class="currency">{{ currency() }}</span></div>
                    @endif
                <div class="price-sum mr-lg-4">
                    {{ number_format($item->price,0,'.',' ') }}&nbsp;<span class="currency">{{ currency() }}</span>
                </div>
            </div>

            <div class="remove js-cart-remove">
                @svg('images/svg/remove.svg')
            </div>
        </div>
    </div>
</form>