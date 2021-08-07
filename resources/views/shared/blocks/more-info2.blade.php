<!-- box-04 begin more-info2 -->
<section class="more-info position-relative">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 position-relative d-none d-lg-block">
                <img class="more-info__image position-absolute" src="/images/project/boy.png" alt="">
            </div>
            <div class="col-lg-6">
                <h2 class="main-title">{!! rv($data['title']) !!}</h2>
                <div class="more-info__text"> {!! rv($data['description'] ) !!}</div>
                <div class="first-screen__image__wrapper overflow-hidden d-lg-none">
                    <img class="first-screen__image d-block mx-auto" src="/images/project/boy.png" alt="">
                </div>
                <div class="more-info__form__wrapper position-relative w-100">
                    <form onsubmit="yaCounterTemp.reachGoal('callback');" action="{{ route('callback.set') }}/" method="post"
                    class="more-info__form js-form--more-info">
                        <div class="form-group position-relative mr-0">
                            <label class="form-label" for="more-form-name">* Ваше имя</label>
                            <div class="form-control__wrapper">
                                <input class="form-control" id="more-form-name" type="text" name="name" placeholder="Введите имя" required="">
                            </div>
                            <span class="icon position-absolute">
                                @svg('images/svg/user.svg')
                            </span>
                        </div>
                        <div class="form-group position-relative mr-0">
                            <label class="form-label" for="more-form-tel">* Ваш телефон</label>
                            <div class="form-control__wrapper">
                                <input class="form-control" id="more-form-tel" type="tel" name="phone" placeholder="+7" required="">
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
<!-- box-04 end more-info2 -->
