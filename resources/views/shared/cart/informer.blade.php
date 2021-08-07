<a href="{{ route('cart_show') }}/" class="cart-circle d-block position-relative">
    <span class="cart-icon position-absolute">
        @svg('images/svg/basket-icon.svg')
    </span>
    <span class="items d-block rounded-circle position-absolute js-cart-count">{{ cartCount() }}</span>
</a>
<div class="total-price">
    <a href="{{ route('cart_show') }}/" class="js-cart-sum">{{ cartSum() }}</a>
    <span class="currency">{{ country()->currency }}</span>
</div>
