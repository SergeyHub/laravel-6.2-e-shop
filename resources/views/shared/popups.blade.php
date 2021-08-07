<div class="first-screen__get-consult d-md-none">
    <a href="#" data-toggle="modal" data-target="#callbackorder-pop" data-title="Заказать звонок" class="phone position-fixed">@svg('images/svg/phone-receiver.svg')</a>
</div>

<div class="callback-pop modal fade" id="callbackorder-pop" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content position-relative">
            <div class="modal-header">
                <div class="modal-header__icon image__wraper icon-center">
                    @svg('images/svg/phone-big.svg')
                </div>
                <div class="close position-absolute" data-dismiss="modal" aria-label="Закрыть">
                    <img data-src="{{ asset('images/svg/close.svg') }}" class="lazy" alt="Закрыть">
                </div>
            </div>
            <div class="modal-body text-center">
                <div class="main-title color-black">Оставьте свои данные</div>
                <div class="modal-body__text">
                    и наш менеджер свяжется с Вами <strong>в течение 3 минут</strong>
                </div>
                <form  action="{{ route('callback.set') }}/" method="post" class="mx-auto js-form--more-info5" >
                    <div class="row justify-content-center text-left ">
                        <div class="col-lg-4">
                            <div class="form-group position-relative">
                                <label class="form-label" for="modal-recal-form-name">* Ваше имя</label>
                                <div class="form-control__wrapper">
                                    <input class="form-control" id="modal-recal-form-name" type="text" name="name" placeholder="Введите имя" required="required">
                                </div>
                                <span class="icon position-absolute">
                                    @svg('images/svg/user.svg')
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group position-relative">
                                <label class="form-label" for="modal-recal-form-tel">* Ваш телефон</label>
                                <div class="form-control__wrapper">
                                    <input class="form-control" id="modal-recal-form-tel" type="tel" name="phone" placeholder="+7" required="required">
                                </div>
                                <span class="icon position-absolute">
                                    @svg('images/svg/call-answer.svg')
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body__btns d-flex justify-content-center">
                        @csrf
                        <button class="btn" type="submit">Позвоните мне</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="city-list-pop modal fade" id="city-list" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content position-relative">

            {{-- <div class="modal-header d-block">
                <h2 class="city-list-pop__title text-center">Укажите свой город в поле, если не нашли его в списке</h2>
                <div class="form-group position-relative mb-0 search mx-auto">
                    <input class="form-control" type="text" name="search_city" placeholder="Найти" >
                    <span class="icon position-absolute">@svg('images/svg/search.svg')</span>
                </div>
            </div> --}}
            <div class="modal-body">
                <div class="close position-absolute" data-dismiss="modal" aria-label="Закрыть">
                    <img data-src="{{ asset('images/svg/close.svg') }}" class="lazy" alt="Закрыть">
                </div>
                <div class="main-title color-black">Выберите город</div>
                <div class="search mx-auto">
                    <div class="form-group position-relative text-left">
                        <label class="form-label" for="search_city">Укажите в поле, если не нашли в списке</label>
                        <div class="form-control__wrapper">
                            <input class="form-control" id="search_city" type="text" name="search_city" placeholder="{{ currentCity()->name ?? '' }}">
                        </div>
                        <span class="icon position-absolute">
                            @svg('images/svg/search-pointer.svg')
                        </span>
                        <span class="icon search-icon position-absolute">
                            @svg('images/svg/search-icon.svg')
                        </span>
                    </div>
                </div>

                <div class="city-list">
                    @php
                        $ch = 'А';
                    @endphp
                    <div class="card city_cart">
                        <p class="card_name">{{ $ch }}</p>
                        @php
                            $cities = \App\Models\City::where('country_id',country()->id)->where('status',1)->orderBy('name')->get();
                        @endphp
                        @foreach($cities as $city)
                            @if(mb_strtoupper(mb_substr($city->name,0,1)) != $ch)
                                @php
                                $ch = mb_strtoupper(mb_substr($city->name,0,1));
                                @endphp
                                </div>
                                <div class="card city_cart {{ citiesInLetter($cities,$ch) ? 'show-default' : 'hide-default d-none' }}">
                                <p class="card_name">{{ $ch }}</p>
                            @endif
                            <p class="city-name {{ $city->show_default ? 'show-default' : 'hide-default d-none' }}"><a href="{{ cityUrl($city) }}">{{ $city->name }}</a></p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm-pop" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content blue position-relative">
            <div class="modal-header">
                <div class="modal-header__icon image__wraper icon-center">
                    @svg('images/svg/ok-sircle-big.svg')
                </div>
                <div class="close position-absolute" data-dismiss="modal" aria-label="Закрыть">
                    <img data-src="{{ asset('images/svg/close.svg') }}" class="lazy" alt="Закрыть">
                </div>
            </div>
            <div class="modal-body text-center">
                <div class="main-title color-black">Товар добавлен в корзину</div>
                <div class="modal-body__text js-review-modal-text">
                    В корзине <span class="js-cart-count-text"></span>
                    <strong>на сумму <span class="js-cart-sum"></span></strong>
                </div>
                <div class="modal-body__btns d-flex justify-content-center flex-column flex-md-row">

                    <a href="#" data-dismiss="modal" aria-label="Close" class="btn btn-light mr-3">Вернуться к выбору товара</a>
                    <a href="/cart/" class="btn ml-3"><span>Перейти в корзину</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirm-review" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content position-relative">
            <div class="modal-header">
                <div class="modal-header__icon image__wraper icon-center">
                    @svg('images/svg/ok-sircle-big.svg')
                </div>
                <div class="close position-absolute" data-dismiss="modal" aria-label="Закрыть">
                    <img data-src="{{ asset('images/svg/close.svg') }}" class="lazy" alt="Закрыть">
                </div>
            </div>

            <div class="modal-body text-center">
                <div class="main-title color-black js-review-modal-title"></div>
                <div class="modal-body__text js-review-modal-text"></div>
            </div>
        </div>
    </div>
</div>

<div class="confirm-pop modal fade" id="callback-pop" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content position-relative">
            <div class="modal-header position-relative justify-content-center">
                <div class="close position-absolute" data-dismiss="modal" aria-label="Close">
                    @svg('images/svg/close-icon.svg')
                </div>
                <div class="h2 main-title title-white">Помощь</div>
            </div>
            <div class="modal-body">
                <form onsubmit="yaCounterTemp.reachGoal('callback');" action="{{ route('callback.set') }}/" method="post" class="js-form--modal">
                    <div class="px-150">
                        <div class="form-group">
                            <input class="form-control" type="text" name="name" placeholder="Ваше имя" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="tel" name="phone" placeholder="Ваш телефон" required>
                        </div>
                        <input type="hidden" name="type" value="Позвоните мне">
                        {{ csrf_field() }}
                        <button type="submit" class="btn mx-auto d-block">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="thankfulness-pop modal fade" id="thankfulness-pop" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header position-relative justify-content-center">
                <div class="close position-absolute" data-dismiss="modal" aria-label="Close">
                    @svg('images/svg/close-icon.svg')
                </div>
                <div class="h2 main-title title-white text-center">Спасибо</div>
            </div>
            <div class="modal-body text-center ">
                <div class="text mx-auto">
                        <span class="js-client-name"></span> спасибо за заявку.
                        Наш менеджер свяжется с Вами в ближайшее время
                </div>
                <a class="btn" href="#" data-dismiss="modal" aria-label="Close">
                    Продолжить покупки
                </a>
            </div>
        </div>
    </div>
</div>
<div class="thankfulness-pop modal fade" id="order-pop" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header position-relative justify-content-center">
                <div class="close position-absolute" data-dismiss="modal" aria-label="Close">
                    @svg('images/svg/close-icon.svg')
                </div>
                <div class="h2 main-title title-white text-center">Спасибо</div>
            </div>
            <div class="modal-body text-center">
                <div class="text mx-auto">
                        <span class="js-order-name"></span> спасибо за заказ.
                        Наш менеджер свяжется с Вами в ближайшее время
                </div>
                <a class="btn" href="/">Продолжить покупки</a>
            </div>
        </div>
    </div>
</div>
@include('shared.popups.qty-order')
