<div class="cart-form">
    <div class="cart-form__title text-center">Способ доставки</div>
    <form onsubmit="yaCounterTemp.reachGoal('buy');"
            action="{{ route('order.set') }}/"
            method="post"
            class="cart-form__form js-form__cart-submit1 mx-auto px-0">
        <div class="row">

            <div class="delivery-block js-delivery col-md-6 pr-0">
                <div class="delivery-block__item js-depended-address">
                    <label class="checkbox d-inline-block">
                        <input type="radio" name="cart_delivery" value="pickup" checked="checked"><span class="checkbox__text">Самовывоз</span>
                    </label>
                </div>
                <div class="delivery-block__item js-depended-address">
                    <label class="checkbox">
                        <input type="radio" name="cart_delivery" class="js-depended-status" value="address" >
                        <span class="checkbox__text">Доставка курьером</span>
                    </label>

                </div>
                <div class="delivery-block__item js-depended-address">
                    <label class="checkbox js-check">
                        <input type="radio" name="cart_delivery"  class="js-depended-status" value="post">
                        <span class="checkbox__text">Доставка по области / краю</span>
                    </label>
                </div>
            </div>


            {{-- ГОРОД --}}
            <div class="col-md-6">
                <div class="city-block pb-1">
                    @if (currentCity())
                        <span class="city-block__title">Выберите город: </span>
                    @endif
                    <a href="#" class="city-block__link"
                        data-toggle="modal" data-target="#city-list">
                        {{ currentCity()?currentCity()->name:'Выберите город' }}
                        <span class="arrow lazy">@svg('images/svg/select-arrow.svg')</span>
                    </a>
                </div>
                {{-- здесь класс должен d-none меняться --}}
                <div class="form-group position-relative mt-3 mb-0 d-none mr-0">
                    <label class="form-label pl-0" for="cart-adress">Адрес доставки</label>
                    <div class="form-control__wrapper">
                        <input disabled="disabled" class="form-control adress" id="cart-adress" type="text" name="address" placeholder="Адрес">
                    </div>
                    <span class="icon position-absolute">
                        @svg('images/svg/search-pointer.svg')
                    </span>
                </div>
                @if (currentCity())
                    <div class="city-block form-group mb-0 mt-4 position-relative js-pick-up-address">
                        <div class="city-block__title pl-0">Адрес самовывоза:</div>
                        <div class="city-block__link font-weight-bold">{{ getAddress() }}</div>
                    </div>
                @endif
            </div>


            {{-- ПРИМЕЧАНИЕ --}}
            <div class="col-lg-12 mt-5 mt-lg-4">
                <div class="cart-form__title text-center">Примечание</div>
                <div class="cart-form__footnote text-center mb-4">*Обязательные поля для заполнения</div>
                <div class="row">
                    <div class="col-lg-6 contact-block">
                        <div class="form-group position-relative">
                            <label class="form-label" for="cart-recal-form-name"><span class="required">*</span> Ваше имя</label>
                            <div class="form-control__wrapper">
                                <input class="form-control js-focus" id="cart-recal-form-name" type="text" name="name" placeholder="Введите имя" required="required">
                            </div>
                            <span class="icon position-absolute">
                                @svg('images/svg/user.svg')
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-6 contact-block">
                        <div class="form-group position-relative">
                            <label class="form-label" for="cart-recal-form-tel"><span class="required">*</span> Ваш телефон</label>
                            <div class="form-control__wrapper">
                                <input class="form-control" id="cart-recal-form-tel" type="tel" name="phone" placeholder="+7" required="required">
                            </div>
                            <span class="icon position-absolute">
                                @svg('images/svg/call-answer.svg')
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group position-relative textarea">
                    <label class="form-label "
                            for="cart-form-message">Примечание
                    </label>
                    <div class="form-control__wrapper">
                        <textarea class="form-control"
                                id="cart-form-message"
                                name="message"
                                placeholder="Введите текст вашего примечания"
                                rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>

        @csrf
        <div class="d-flex buttons__wrapper flex-wrap justify-content-center justify-content-xl-between">
            <button type="submit" class="btn btn-dark btn-submit m-md-3 mx-xl-0">Оформить заказ</button>
            <a class="btn btn-light m-md-3 mt-3 mx-xl-0" href="/">Вернуться на сайт</a>
        </div>
    </form>
</div>