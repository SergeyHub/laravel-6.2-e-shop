@extends('layouts.app')
@section('content')
<div class="delivery-page">
    <div class="delivery-page__top">
        <div class="container">
            @include('shared.breadcrumb')
            <h1 class="main-title text-center">Доставка и оплата</h1>
            <div class="delivery-page__tabs mx-auto">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs__custom nav-fill">
                     <li class="nav-item">
                         <a class="nav-link active js-delivery-tab"
                             data-toggle="tab"
                             href="#"
                             data-title="Вы можете <strong>забрать заказ</strong> самостоятельно в день заказа, через 15 минут после его оформления."
                             data-subtitle="Просто заполните форму."
                             data-target="#delivery-page__tabs-01">
                             Самовывоз
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link js-delivery-tab"
                             data-toggle="tab"
                             href="#"
                             data-title="Вы можете <strong>уточнить стоимость</strong> доставки в Ваш регион у менеджера нашего магазина."
                             data-subtitle="Для этого нужно заполнить форму."
                             data-target="#delivery-page__tabs-02">
                             Курьерская доставка
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link js-delivery-tab"
                             data-toggle="tab"
                             href="#"
                             data-title="Вы можете <strong>уточнить стоимость</strong> доставки в Ваш регион у менеджера нашего магазина."
                             data-subtitle="Для этого нужно заполнить форму."
                             data-target="#delivery-page__tabs-03">
                             Доставка по области/краю
                         </a>
                     </li>
                </ul>
            </div>
            <!-- Tab panes -->
            <div class="tab-content mx-auto">
                <div class="tab-pane active" id="delivery-page__tabs-01">
                    <div class="row position-relative">
                        <div class="col-lg-3 col-sm-6">
                            <div class="advantage__item">
                                <div class="image__wraper icon-center mx-auto">
                                    @svg('images/svg/support-big.svg')
                                </div>
                                <div class="text-lg text-center">Городской номер</div>
                                <div class="text-sm text-center">
                                    <a onclick="yaCounterTemp.reachGoal('call');" href="tel:{{ getPhone()['clear'] }}">{{ getPhone()['format'] }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="advantage__item">
                                <div class="image__wraper icon-center mx-auto">
                                    @svg('images/svg/map-pin-big.svg')
                                </div>
                                <div class="text-lg text-center">Адрес</div>
                                <div class="text-sm text-center">
                                    @if (currentCity())
                                    г.{{ currentCity()->name }}<br>
                                    @endif
                                    {!! rv(getAddress()) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="advantage__item">
                                <div class="image__wraper icon-center mx-auto">
                                    @svg('images/svg/time-big.svg')
                                </div>
                                <div class="text-lg text-center">Режим работы</div>
                                <div class="text-sm text-center">
                                    {!! str_replace("\n","<br>",rv(getSchedule())) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="advantage__item">
                                <div class="image__wraper icon-center mx-auto">
                                    @svg('images/svg/wallet-big.svg')
                                </div>
                                <div class="text-lg text-center">Оплата при получении в магазине</div>
                                <div class="text-sm text-center">
                                    Наличными или банковской картой
                                </div>
                            </div>
                        </div>
                        <div class="d-none d-lg-block decor-line left position-absolute"></div>
                        <div class="d-none d-lg-block decor-line center position-absolute"></div>
                        <div class="d-none d-lg-block decor-line right position-absolute"></div>
                    </div>
                </div>
                <div class="tab-pane" id="delivery-page__tabs-02">
                    <div class="row position-relative">
                        <div class="col-lg-3 col-sm-6">
                            <div class="advantage__item">
                                <div class="image__wraper icon-center mx-auto">
                                    @svg('images/svg/support-big.svg')
                                </div>
                                <div class="text-lg text-center">
                                    <a onclick="yaCounterTemp.reachGoal('call');" href="tel:{{ getPhone()['clear'] }}">{{ getPhone()['format'] }}</a>
                                </div>
                                <div class="text-sm text-center">
                                    для расчета стоимости доставки свяжитесь с нашим менеджером
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="advantage__item">
                                <div class="image__wraper icon-center mx-auto">
                                    @svg('images/svg/ruble-big.svg')
                                </div>
                                <div class="text-lg text-center">Стоимость доставки</div>
                                <div class="text-sm text-center">
                                    {{ cv('delivery_price') }} {{ currency() }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="advantage__item">
                                <div class="image__wraper icon-center mx-auto">
                                    @svg('images/svg/wallet-big.svg')
                                </div>
                                <div class="text-lg text-center">Оплата</div>
                                <div class="text-sm text-center">
                                    Наличными или банковской картой
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 px-lg-0">
                            <div class="advantage__item">
                                <div class="image__wraper icon-center mx-auto">
                                    @svg('images/svg/ok-sircle-big.svg')
                                </div>
                                <div class="text-lg text-center">Оплата производится<br>при получении товара</div>
                                <div class="text-sm text-center">
                                    Вы можете оплатить удобным<br> для себя способом
                                </div>
                            </div>
                        </div>
                        <div class="d-none d-lg-block decor-line left position-absolute"></div>
                        <div class="d-none d-lg-block decor-line center position-absolute"></div>
                        <div class="d-none d-lg-block decor-line right position-absolute"></div>
                    </div>
                </div>
                <div class="tab-pane" id="delivery-page__tabs-03">
                    <div class="row position-relative">
                        <div class="col-lg-3 col-sm-6">
                            <div class="advantage__item">
                                <div class="image__wraper icon-center mx-auto">
                                    @svg('images/svg/support-big.svg')
                                </div>
                                <div class="text-lg text-center">
                                    <a onclick="yaCounterTemp.reachGoal('call');" href="tel:{{ getPhone()['clear'] }}">{{ getPhone()['format'] }}</a>
                                </div>
                                <div class="text-sm text-center">
                                    для расчета стоимости<br> доставки свяжитесь с<br> нашим менеджером
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 px-lg-0">
                            <div class="advantage__item">
                                <div class="image__wraper icon-center mx-auto">
                                    <img class="lazy img-fluid p-1" alt="Доставка" src="/images/icons/cdek.svg">
                                </div>
                                <div class="text-lg text-center">Отправка курьерской службой СДЭК</div>
                                <div class="text-sm text-center px-7">
                                    Мы берем предоплату за<br> доставку.
                                    В среднем {{ cv('cdek_price') }} {{ currency() }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="advantage__item">
                                <div class="image__wraper icon-center mx-auto">
                                    <img class="lazy img-fluid p-2" alt="Доставка" src="/images/icons/post-icon.svg">
                                </div>
                                <div class="text-lg text-center">При отправке Почтой России</div>
                                <div class="text-sm text-center">
                                    Мы берем фиксированную предоплату за доставку<br>
                                    {{ cv('post_price') }} {{ currency() }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="advantage__item">
                                <div class="image__wraper icon-center mx-auto">
                                    @svg('images/svg/wallet-big.svg')
                                </div>
                                <div class="text-lg text-center">Оплата после <br>получения товара</div>
                                <div class="text-sm text-center">
                                    удобным для вас способом
                                </div>
                            </div>
                        </div>
                        <div class="d-none d-lg-block decor-line left position-absolute"></div>
                        <div class="d-none d-lg-block decor-line center position-absolute"></div>
                        <div class="d-none d-lg-block decor-line right position-absolute"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="delivery-page__info more-info position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-none d-lg-block position-relative">
                    <img class="more-info__image position-absolute" src="/images/project/boy-4.png" alt="">
                </div>
                <div class="col-lg-6">
                    <h2 class="main-title js-delivery-title">
                        Вы можете <strong>забрать заказ </strong>самостоятельно в день заказа, через 15 минут после его оформления.
                    </h2>
                    <div class="first-screen__image__wrapper overflow-hidden d-lg-none">
                        <img class="first-screen__image d-block mx-auto" src="/images/project/boy-4.png" alt="">
                    </div>
                    <div class="more-info__text d-flex align-items-center flex-lg-nowrap flex-wrap js-delivery-subtitle">
                        Просто заполните форму.
                    </div>
                    <div class="more-info__form__wrapper position-relative">
                        <form onsubmit="yaCounterTemp.reachGoal('callback');" action="{{ route('callback.set') }}/" method="post"
                        class="more-info__form white js-form--more-info" novalidate="novalidate">
                            <div class="form-group position-relative mr-0">
                                <label class="form-label" for="delivery-form-name">* Ваше имя</label>
                                <div class="form-control__wrapper">
                                    <input class="form-control" id="delivery-form-name" type="text" name="name" placeholder="Введите имя" required="">
                                </div>
                                <span class="icon position-absolute">
                                    @svg('images/svg/user.svg')
                                </span>
                            </div>
                            <div class="form-group position-relative mr-0">
                                <label class="form-label" for="delivery-form-tel">* Ваш телефон</label>
                                <div class="form-control__wrapper">
                                    <input class="form-control" id="delivery-form-tel" type="tel" name="phone" placeholder="+7" required="">
                                </div>
                                <span class="icon position-absolute">
                                    @svg('images/svg/call-answer.svg')
                                </span>
                            </div>
                            <input type="hidden" name="type" value="Позвоните мне">
                            <input type="hidden" name="_token" value="0UAzxCykDMF7Rl6KpEwZInJJEQ35UAcj10dIMqlB">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-green w-100">Получить консультацию</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="contacts" >
        @include('shared.mapContacts')
    </div>
</div>
@endsection
