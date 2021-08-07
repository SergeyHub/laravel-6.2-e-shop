<div class="cart-helper">
    <div class="container">
        <h2 class="main-title text-center">
            Чтобы <strong>оформить</strong> заказ:
        </h2>
        <div class="cart-helper__text mx-auto text-center">
            <div class="icon icon-center mx-auto">
                @svg('images/svg/phone-big.svg')
            </div>
            <div class="cart-helper__text__in">
                <div class="contacts-page__info__text">
                    Свяжитесь с нами по бесплатному номеру
                </div>
                <div class="contacts-page__info__text__big">
                    <a class="color-red" onclick="yaCounter54742531.reachGoal('call');" href="tel:{{ getPhone2()['clear'] }}">
                        <strong>{{ getPhone2()['format'] }}</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
