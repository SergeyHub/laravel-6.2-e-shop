<!-- header top begin -->
<div class="header-top d-none d-lg-block">
    <div class="container">
        <div class="d-flex justify-content-between align-items-lg-center position-relative">
            <a href="/" class="logo">
                 <img class="d-block align-self-center lazy" src="{{ asset('images/icons/logotype.svg') }}" alt="{{ strip_tags(cv('site_name')) }}">
                {{-- <span class="site-description ml-2 align-self-end" style="max-width: 120px;">{!! cv('site_name') !!}</span> --}}
            </a>
            <div class="header__contact d-flex align-items-center justify-content-between flex-grow-1">
                <div class="header__contact__box address">
                    <p class="caption mb-0">
                        <span class="icon mr-1">@svg('images/svg/placeholder.svg')</span>
                        @if (currentCity())
                            <span>Выберите город: </span>
                        @endif
                        <a href="#" class="current-location__link" data-toggle="modal" data-target="#city-list">{{ currentCity()?currentCity()->name:'Выберите город' }}</a>
                        <span class="arrow lazy">@svg('images/svg/select-arrow.svg')</span>
                    </p>
                    <p class="value mb-0">{{ getAddress() }}</p>
                </div>
                <div class="header__contact__box">
                    <p class="caption mb-0">
                        <span class="icon mr-1">
                            @svg('images/svg/phone-receiver.svg')
                        </span>
                        Для всех регионов:
                    </p>
                    <p class="value mb-0">
                        <a onclick="yaCounterTemp.reachGoal('call');" href="tel:{{ str_replace(['(', ')', ' ', '-'], '', getConfigValue('phone_all')) }}">{{ getConfigValue('phone_all') }}</a>
                    </p>
                </div>
                <div class="header__contact__box">
                    <p class="caption mb-0">
                        <span class="icon mr-1">@svg('images/svg/phone-receiver.svg')</span>
                        {{ currentCity()?('Для '.currentCity()->name1).':' :'Для всех:' }}
                    </p>
                    <p class="value mb-0">
                        <a onclick="yaCounterTemp.reachGoal('call');" href="tel:{{ getPhone()['clear'] }}">{{ getPhone()['format'] }}</a>
                    </p>
                </div>
                <div class="cart-block d-flex align-items-center align-self-center js-cart-wrapper">
                    @include('shared.cart.informer')
                </div>
                <a class="btn btn-recall btn-sm d-lg-flex d-none" href="#" data-toggle="modal" data-target="#callbackorder-pop" data-title="Заказать звонок">
                   @svg('images/svg/phone-receiver1.svg') <span class="text">Перезвоните мне</span>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- header top end -->
<!-- header begin-->
<header class="header">
    <div class="navbar navbar-expand-lg p-0 h-100">
        <div class="container-fluid d-lg-none">
            <div class="d-flex justify-content-between w-100 align-items-center">
                <a href="/" class="logo">
                    <img class="d-block align-self-center" src="{{ asset('images/icons/logotype.svg') }}" alt="{{ strip_tags(cv('site_name')) }}">
                </a>
                <div class="d-flex">
                    <div class="cart-block d-flex align-items-center align-self-center js-cart-wrapper">
                        @include('shared.cart.informer')
                    </div>
                    <button class="navbar-toggler collapsed mb-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon m-auto"></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <nav class="collapse navbar-collapse h-100" id="navbarSupportedContent">
                <ul class="header__menu list-unstyled d-flex align-items-center justify-content-between w-100 flex-column flex-lg-row w-100 h-100 mx-auto mb-0">
                    <li class="header__menu__item">
                        <a class="header__menu__link" href="/">Главная</a>
                    </li>
                    <li class="header__menu__item">
                        <a class="header__menu__link" href="{{ route('catalog.show') }}/">Каталог</a>
                    </li>
                    <li class="header__menu__item">
                        <a class="header__menu__link" href="{{ ppId(6) }}">Доставка и оплата</a>
                    </li>
                    <li class="header__menu__item position-relative">
                        <a class="header__menu__link" href="{{ route('blog.index') }}/" id="useful-info-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Полезная информация  @svg('images/svg/arrow-select-red.svg')
                        </a>
                        <div class="dropdown-menu w-100" aria-labelledby="useful-info-link">
                            <ul class="dropdown-menu__list list-unstyled">
                                <li class="dropdown-menu__item icon-center">
                                    <a class="dropdown-menu__link" href="{{ route('blog.index') }}/">Статьи</a>
                                </li>
                                <li class="dropdown-menu__item icon-center">
                                    <a class="dropdown-menu__link" href="{{ route('news.index') }}/">Новости</a>
                                </li>
                                <li class="dropdown-menu__item icon-center">
                                    <a class="dropdown-menu__link" href="{{ route('promo.index') }}/">Акции</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="header__menu__item">
                        <a class="header__menu__link" href="{{ ppId(10) }}">О компании</a>
                    </li>
                    <li class="header__menu__item">
                        <a class="header__menu__link" href="{{ ppId(5) }}">Контакты</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<!-- header end-->
<!-- header-bottom begin -->
<div class="header-bottom px-3 d-lg-none">
    <div class="header__contact__box address text-center">
        <p class="caption mb-0">
            <span class="icon mr-1">@svg('images/svg/placeholder.svg')</span>
            @if (currentCity())
                <span>Выберите город: </span>
            @endif
            <a href="#" class="current-location__link" data-toggle="modal" data-target="#city-list">{{ currentCity()?currentCity()->name:'Выберите город' }}</a>
            <span class="arrow lazy">@svg('images/svg/select-arrow.svg')</span>
        </p>
        <p class="value mb-0">{{ getAddress() }}</p>
    </div>
    <div class="header__contact d-flex align-items-center justify-content-sm-around justify-content-between flex-wrap">
        <div class="header__contact__box">
            <p class="caption mb-0">
                <span class="icon mr-1">@svg('images/svg/phone-receiver.svg')</span>
                {{ currentCity()?('Для '.currentCity()->name1).':' :'Для всех:' }}
            </p>
            <p class="value mb-0">
                <a onclick="yaCounterTemp.reachGoal('call');" href="tel:{{ getPhone()['clear'] }}">{{ getPhone()['format'] }}</a>
            </p>
        </div>
        <div class="header__contact__box">
            <p class="caption mb-0">
                <span class="icon mr-1">
                    @svg('images/svg/phone-receiver.svg')
                </span>
                Для всех регионов:
            </p>
            <p class="value mb-0">
                <a onclick="yaCounterTemp.reachGoal('call');" href="tel:{{ str_replace(['(', ')', ' ', '-'], '', getConfigValue('phone_all')) }}">{{ getConfigValue('phone_all') }}</a>
            </p>
        </div>
    </div>
</div>
<!-- header-bottom end -->

