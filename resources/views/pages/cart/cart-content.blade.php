<div class="buy-list mb-5">
    @foreach (cart()->products as $item)
        @include('pages.cart.buy-item', ["item"=>$item])
    @endforeach
</div>

{{-- ИТОГО --}}
<div class="row mt-5 mb-md-4">

    <div class="col-12 col-md-6 mb-5 pb-3">
        <div class="total-price mx-auto px-0">
            <div class="mb-2">
                @if(cart()->total_old && cart()->total_old > cart()->total)
                    <del>{{cart()->total_old}}&nbsp;{{ currency() }}</del>
                @endif
            </div>
            Итого: <span class="summary js-cart-total-format">{{ number_format(cart()->total,0,'.',' ') }}&nbsp;<span class="currency">{{ currency() }}</span></span>
        </div>
    </div>


    {{-- ПРОМОКОД --}}
    <div class="col-12 col-md-6 pl-lg-0 js-promocode">
        @include("pages.cart.promocode")
    </div>
</div>
