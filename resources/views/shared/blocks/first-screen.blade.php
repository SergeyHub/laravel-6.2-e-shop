<!-- box-01 begin first-screen -->
<section class="first-screen position-relative">
    <a name="box-01" id="box-01"></a>
    <div class="container">
        <div class="row">
            <div class="col-lg-7 position-relative">
                <h1 class="first-screen__title">
                    {!! rv($data['title'] ?? '') !!}
                </h1>
                <div class="in-stock">
                    <ul class="list-unstyled mb-0">
                        <li>
                            <span class="icon">@svg('images/svg/in-stock-check.svg')</span>
                            {!! rv(str_replace("\n",'</li><li><span class="icon">@svg('images/svg/in-stock-check.svg')</span>',($data['description'] ?? ''))) !!}
                        </li>
                    </ul>
                </div>
                <form onsubmit="yaCounterTemp.reachGoal('callback');" action="{{ route('callback.set') }}/" method="post" class="first-screen__form d-none d-lg-block js-form--first-screen">
                    <div class="form-group position-relative">
                        <label class="form-label" for="first-form-name">* Ваше имя</label>
                        <div class="form-control__wrapper">
                            <input class="form-control" id="first-form-name" type="text" name="name" placeholder="Введите имя" required="">
                        </div>
                        <span class="icon position-absolute">
                            @svg('images/svg/user.svg')
                        </span>
                    </div>
                    <div class="form-group position-relative">
                        <label class="form-label" for="first-form-tel">* Ваш телефон</label>
                        <div class="form-control__wrapper">
                            <input class="form-control" id="first-form-tel" type="tel" name="phone" placeholder="+7" required="">
                        </div>
                        <span class="icon position-absolute">
                            @svg('images/svg/call-answer.svg')
                        </span>
                    </div>
                    <div class="form-group mb-0">
                        <input type="hidden" name="type" value="Позвоните мне">
                        {{ csrf_field() }}
                        <button type="submit" class="btn d-block w-100">Получить консультацию</button>
                    </div>
                </form>
                <div class="first-screen__image__wrapper overflow-hidden d-lg-none">
                    <img class="first-screen__image d-block mx-auto" src="{{ asset($data['image'] ?? '') }}" alt="{{ rv(strip_tags($data['title'] ?? '')) }}">
                </div>
                <div class="first-screen__get-consult position-absolute mx-auto d-lg-none">
                    <a href="#" data-toggle="modal" data-target="#callbackorder-pop" data-title="Заказать звонок" class="btn w-100" >Получить консультацию</a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block position-relative">
                <img class="first-screen__image position-absolute" src="{{ asset($data['image'] ?? '') }}" alt="{{ rv(strip_tags($data['title'] ?? '')) }}">
            </div>
        </div>
    </div>
</section>



<!-- box-01 end first-screen -->
