<section class="more-info fourth">
    <div class="container">
        <div class="contact-form__wrapper">
        <div class="contact-form w-100">
            <h2 class="main-title title-white text-center">{!! rv($data['title']) !!}</h2>
            <form onsubmit="yaCounterTemp.reachGoal('callback');" action="{{ route('callback.set') }}/" method="post" class="js-form--more-info4">
                <div class="d-flex justify-content-around flex-wrap">
                    <div class="form-group">
                        <input class="form-control" type="text" name="name" placeholder="Как Вас зовут" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="tel" name="phone" placeholder="Ваш телефон" required>
                    </div>
                    <input type="hidden" name="type" value="Позвоните мне">
                    {{ csrf_field() }}
                    <div class="form-group button">
                        <button type="submit" class="btn text-uppercase">
                            <span class="icon">@include('icons.arrow-down')</span>
                            <span class="txt">Заказать сейчас</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>
</section>
