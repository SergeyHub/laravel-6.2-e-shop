<div class="catalog__item js-catalog__item gorizontal position-relative">
    <div class="catalog__item__sticker position-absolute">
        @if ($product->discount())
            <div class="catalog__item__sticker__icon icon-center"><span>{{ $product->discount() }}</span></div>
        @endif
        @if ($product->bestseller)
            <div class="catalog__item__sticker__icon icon-center hit"><span>ХИТ</span></div>
        @endif
        @if ($product->new)
            <div class="catalog__item__sticker__icon icon-center new"><span>NEW</span></div>
        @endif
    </div>
    <div class="catalog__item__content d-flex">
        <div class="photo">
            <a class="photo__link h-100 d-flex justify-content-center" href="{{ $product->getUrl() }}">
                <img class="photo__image mw-100 mh-100 align-self-center"
                     src="{{ asset(_i($product->getImage(),300,330)) }}"
                     alt="{{ rv(strip_tags($product->getAlt())) }}">
            </a>
        </div>
        <div class="d-flex flex-column">
            <div class="name">
                <a href="{{ $product->getUrl() }}">
                    {!! rv($product->name) !!}
                    @if (isset($append) && $append)
                        ({{$append}})
                    @endif
                </a>
            </div>
            @if ($product->channels || $product->bandwidth || $product->frequency)
                <div class="catalog__item__description">
                    @if ($product->channels)
                        <div class="catalog__item__description__item d-flex align-items-start justify-content-between ">
                            <div class="description__item__left  d-flex align-items-center flex-shrink-0">
                                <span>количество каналов:</span>
                            </div>
                            <div class="description__item__right text-right">
                                {!! rv($product->channels) !!}
                            </div>
                        </div>
                    @endif
                    @if ($product->bandwidth)
                        <div class="catalog__item__description__item d-flex align-items-start justify-content-between ">
                            <div class="description__item__left d-flex align-items-center flex-shrink-0">
                                <span>Полоса пропускания:</span>
                            </div>
                            <div class="description__item__right text-right">
                                {!! rv($product->bandwidth) !!}
                            </div>
                        </div>
                    @endif
                    @if ($product->frequency)
                        <div class="catalog__item__description__item d-flex align-items-start justify-content-between">
                            <div class="description__item__left d-flex align-items-center flex-shrink-0">
                                <span>Частота дискретизации:</span>
                            </div>
                            <div class="description__item__right text-right">
                                {!! rv($product->frequency) !!}
                            </div>
                        </div>
                    @endif
                    @if ($product->depth)
                        <div class="catalog__item__description__item d-flex align-items-start justify-content-between">
                            <div class="description__item__left d-flex align-items-center flex-shrink-0">
                                <span>Глубина памяти:</span>
                            </div>
                            <div class="description__item__right text-right">
                                {!! rv($product->depth) !!}
                            </div>
                        </div>
                    @endif
                </div>
            @endif
            <div class="d-flex align-items-center gorizontal__bottom mt-auto flex-wrap">
                <div class="prices d-flex align-items-center">
                    @if ($product->getPrice(0))
                    <div class="old-price">
                        {{ number_format($product->getPrice(0),0,'.',' ') }}<span class="currency"> {{ currency() }}</span>
                    </div>
                    @endif
                    <div class="new-price">
                        {{ number_format($product->getPrice(1),0,'.',' ') }}<span class="currency"> {{ currency() }}</span>
                    </div>
                </div>
                <div class="d-flex flex-wrap buttons">
                    @if(!$product->under_order)
                        <form action="{{ route('quick') }}/" method="post" class="form">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="count" class="js-product-count" value="1">
                            <button type="submit" class="btn btn-sm btn-white btn-quick p-0">Купить в 1 клик</button>
                        </form>
                        <form action="{{ route('cart.set') }}/" method="post" class="js-form__to-cart form">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="count" value="1">

                            <button type="submit" class="btn btn-sm p-0">
                                <span class="icon">@svg('images/svg/cart-icon.svg')</span>Купить
                            </button>


                        </form>
                    @else
                        <a class="btn btn-sm btn-light p-0 btn-under-order-teaser"  onclick="callOrderQTYPopup('{{$product->id}}')">
                            Под заказ
                        </a>

                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
