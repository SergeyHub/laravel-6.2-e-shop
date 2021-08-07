@if (!cart()->empty)
    <div class="row flex-xl-nowrap">
        <div class="col-12 col-xl-auto mb-5 flex-shrink-1 flex-grow-1 js-cart-content">
            @include("pages.cart.cart-content")
        </div>

        {{-- ФОРМА ЗАКАЗА --}}
        <div class="col-12 col-lg-10 col-xl-auto mx-auto">
            @include('pages.cart.orderForm')
        </div>
    </div>
@else
    <div class="cart-empty text-center">
        <h2 class="cart-empty__title">в корзине 0 товаров</h2>
        <a class="btn btn-dark mx-auto" href="{{ route('catalog.show') }}/">В каталог</a>
    </div>
@endif
