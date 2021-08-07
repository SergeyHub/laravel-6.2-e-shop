
<!-- box-13 begin info -->

<section class="info more-info position-relative">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 position-relative d-none d-lg-block">
                <img class="more-info__image position-absolute" src="/images/project/boy-3.png" alt="">
            </div>
            <div class="col-lg-6 pl-xl-4">
                <h2 class="main-title">{!! rv($data['title']) !!}</h2>
                <div class="more-info__text d-flex align-items-center flex-lg-nowrap flex-wrap">
                    <div class="icon icon-center flex-shrink-0">@svg('images/svg/support.svg')</div>
                    {!! rv($data['text']) !!}
                </div>
                <div class="first-screen__image__wrapper overflow-hidden d-lg-none">
                    <img class="first-screen__image d-block mx-auto" src="/images/project/boy-3.png" alt="">
                </div>
                <div class="more-info__form__wrapper position-relative w-100">
                    <form onsubmit="yaCounterTemp.reachGoal('callback');" action="{{ route('callback.set') }}/" method="post"
                    class="more-info__form js-form--more-info3">
                        <div class="form-group position-relative mr-0">
                            <label class="form-label" for="more2-form-name">* Ваше имя</label>
                            <div class="form-control__wrapper">
                                <input class="form-control" id="more2-form-name" type="text" name="name" placeholder="Введите имя" required="">
                            </div>
                            <span class="icon position-absolute">
                                @svg('images/svg/user.svg')
                            </span>
                        </div>
                        <div class="form-group position-relative mr-0">
                            <label class="form-label" for="more2-form-tel">* Ваш телефон</label>
                            <div class="form-control__wrapper">
                                <input class="form-control" id="more2-form-tel" type="tel" name="phone" placeholder="+7" required="">
                            </div>
                            <span class="icon position-absolute">
                                @svg('images/svg/call-answer.svg')
                            </span>
                        </div>
                        <input type="hidden" name="type" value="Позвоните мне">
                        {{ csrf_field() }}
                        <button type="submit" class="btn w-100">Получить консультацию</button>
                    </form>

                </div>
            </div>
        </div>


    </div>
</section>
<!-- box-13 end info -->
