<footer class="footer" itemscope itemtype="http://schema.org/Organization">
    <div class="footer__top">
        <div class="container">
            <ul class="header__menu list-unstyled d-flex align-items-center justify-content-between flex-column flex-lg-row w-100 h-100 mx-auto mb-0">
                <li class="header__menu__item">
                    <a class="header__menu__link {{-- @if (\Request::is('/')) current" @endif --}}" href="/">Главная</a>
                </li>
                <li class="header__menu__item">
                    <a class="header__menu__link {{-- @if (\Request::is('catalog*')) current" @endif --}}" href="{{ route('catalog.show')  }}/">Каталог</a>
                </li>
                <li class="header__menu__item">
                    <a class="header__menu__link {{-- @if (\Request::is('delivery')) current" @endif --}}" href="{{ ppId(6) }}">Доставка и оплата</a>
                </li>
                <li class="header__menu__item item__dropdown position-relative">
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
                    <a class="header__menu__link {{-- @if (\Request::is('about')) current" @endif --}}" href="{{ ppId(10) }}">О компании</a>
                </li>
                <li class="header__menu__item">
                    <a class="header__menu__link {{-- @if (\Request::is('contacts')) current" @endif --}}" href="{{ ppId(5) }}">Контакты</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="footer__middle" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
        <div class="container">
            <div class="footer__middle__in d-flex justify-content-between align-items-lg-center flex-wrap">
                <a href="/" class="logo">
                    <img class="d-block align-self-center lazy" src="{{ asset('images/icons/logotype.svg') }}" alt="{{ strip_tags(cv('site_name')) }}">
                </a>
                <div class="header__contact d-flex align-items-center justify-content-around justify-content-lg-between flex-grow-1 flex-wrap">
                    <div class="header__contact__box address">
                        <p class="caption mb-0">
                            <span class="icon mr-1">@svg('images/svg/placeholder.svg')</span>
                            @if (currentCity())
                                <span>Выберите город: </span>
                            @endif
                            <a href="#" class="current-location__link" data-toggle="modal" data-target="#city-list"><span itemprop="addressLocality">{{ currentCity()?currentCity()->name:'Выберите город' }}</span></a>
                            <span class="arrow lazy">@svg('images/svg/select-arrow.svg')</span>
                        </p>
                        <p class="value mb-0" itemprop="streetAddress">{{ getAddress() }}</p>
                    </div>
                    <div class="header__contact__box">
                        <p class="caption mb-0">
                            <span class="icon mr-2">
                                @svg('images/svg/phone-receiver.svg')
                            </span>
                            Для всех регионов:
                        </p>
                        <p class="value mb-0">
                            <a onclick="yaCounterTemp.reachGoal('call');" href="tel:{{ str_replace(['(', ')', ' ', '-'], '', getConfigValue('phone_all')) }}"><span itemprop="telephone">{{ getConfigValue('phone_all') }}</span></a>
                        </p>
                    </div>
                    <div class="header__contact__box">
                        <p class="caption mb-0">
                            <span class="icon mr-2">@svg('images/svg/phone-receiver.svg')</span>
                            {{ currentCity()?('Для '.currentCity()->name1).':' :'Для всех:' }}
                        </p>
                        <p class="value mb-0">
                            <a onclick="yaCounterTemp.reachGoal('call');" href="tel:{{ getPhone()['clear'] }}">{{ getPhone()['format'] }}</a>
                        </p>
                    </div>
                    <div class="w-100 d-lg-none"></div>
                    <div class="social-footer d-flex justify-content-center">
                        @if(getConfigValue('vk_link'))
                            <a href="{{ getConfigValue('vk_link') }}" class="soc-icon icon-center vk" target="_blank">@svg('images/svg/vk-logo.svg')</a>
                        @endif
                        @if(getConfigValue('facebook_link'))
                            <a href="{{ getConfigValue('facebook_link') }}" class="soc-icon icon-center facebook" target="_blank">@svg('images/svg/fb-logo.svg')</a>
                        @endif
                        @if(getConfigValue('instagram_link'))
                            <a href="{{ getConfigValue('instagram_link') }}" class="soc-icon icon-center instagram1" target="_blank">@svg('images/svg/insta-logo.svg')</a>
                        @endif
                    </div>
                    <a class="btn btn-recall btn-sm" href="#" data-toggle="modal" data-target="#callbackorder-pop" data-title="Заказать звонок">
                       @svg('images/svg/phone-receiver.svg') <span class="text">Перезвоните мне</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="container position-relative">
            <a href="#" class="slide-to-top position-absolute icon-center">@svg('images/svg/arrow-faq.svg')</a>
            <div class="d-flex align-items-center flex-wrap">
                <ul class="bank-data d-flex list-unstyled flex-wrap mb-0 order-2 order-lg-1 mt-3 mt-lg-0">
                    <li itemprop="name">{!! rv(str_replace("\n",'</li><li>',getConfigValue('coord'))) !!}</li>
                </ul>
                <ul class="header__menu list-unstyled d-flex align-items-center flex-grow-1 justify-content-between flex-column flex-lg-row mb-0 order-1 order-lg-2">
                    <li class="header__menu__item">
                        <a class="header__menu__link" href="{{ ppId(7) }}">Возврат и обмен</a>
                    </li>
                    <li class="header__menu__item">
                        <a class="header__menu__link" href="{{ ppId(4) }}">Гарантии</a>
                    </li>
                    <li class="header__menu__item">
                        <a class="header__menu__link" href="{{ ppId(9) }}">Политика конфиденциальности</a>
                    </li>
                    <li class="header__menu__item">
                        <a class="header__menu__link" href="{{ route('page.sitemap') }}/">Карта сайта</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="copyright text-center">Все права защищены. <a href="https://{{ country()->domain }}">{{ country()->domain }}</a> {{ date('Y') }} ©</div>
</footer>


