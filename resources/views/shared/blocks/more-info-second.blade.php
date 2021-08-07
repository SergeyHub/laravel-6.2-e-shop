<section class="front-form  position-relative">
    <div class="container ">
        <h2 class="main-title title-sm text-center mb-2">{!! rv($data['title']) !!}</h2>
        <div class="front-form__text text-center">{{ rv($data['sub']) }}</div>
        <form onsubmit="yaCounterTemp.reachGoal('callback');" action="{{ route('callback.set') }}/" method="post" class="js-form--more-info3">
            <div class="d-flex justify-content-around flex-wrap px-150">
                <div class="form-group">
                    <input class="form-control" type="text" name="name" placeholder="Ваше имя" required>
                </div>
                <div class="form-group">
                    <input class="form-control" type="tel" name="phone" placeholder="Ваш телефон" required>
                </div>
                <input type="hidden" name="type" value="Позвоните мне">
                {{ csrf_field() }}
                <button type="submit" class="btn">Хочу консультацию</button>
            </div>
        </form>
    </div>
</section>
