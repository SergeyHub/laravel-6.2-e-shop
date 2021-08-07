<section class="cart-empty__form position-relative">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-none d-lg-block position-relative">
                <img class="more-info__image position-absolute" src="/images/project/boy-5.png" alt="">
            </div>
            <div class="col-lg-6">
                <h2 class="main-title">Вы все еще не можете определиться с<strong> выбором осциллографa?</strong></h2>
                <div class="first-screen__image__wrapper overflow-hidden d-lg-none">
                    <img class="first-screen__image d-block mx-auto" src="/images/project/boy-5.png" alt="">
                </div>
                <div class="more-info__text"> Наши опытные специалисты Вас проконсультируют</div>
                <div class="more-info__form__wrapper position-relative">
                    <form onsubmit="yaCounterTemp.reachGoal('callback');" action="{{ route('callback.set') }}/" method="post"
                    class="more-info__form js-form--more-info">
                        <div class="form-group position-relative mr-0">
                            <label class="form-label" for="order-form-name2">* Ваше имя</label>
                            <div class="form-control__wrapper">
                                <input class="form-control" id="order-form-name2" type="text" name="name" placeholder="Введите имя" required="">
                            </div>
                            <span class="icon position-absolute">
                                @svg('images/svg/user.svg')
                            </span>
                        </div>
                        <div class="form-group position-relative mr-0">
                            <label class="form-label" for="order-form-tel2">* Ваш телефон</label>
                            <div class="form-control__wrapper">
                                <input class="form-control" id="order-form-tel2" type="tel" name="phone" placeholder="+7" required="">
                            </div>
                            <span class="icon position-absolute">
                                @svg('images/svg/call-answer.svg')
                            </span>
                        </div>
                        <input type="hidden" name="type" value="Позвоните мне">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-green w-100 mb-0">Получить консультацию</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
