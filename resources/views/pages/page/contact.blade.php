@extends('layouts.app')
@section('content')

<div class="contacts-page">
    <div class="grey-borders position-relative">
        <div class="container">
            @include('shared.breadcrumb')
            <h1 class="main-title text-center">Контакты</h1>
            <div class="d-flex contacts-page__row position-relative flex-wrap mx-auto">
                <div class="advantage__item">
                    <div class="image__wraper icon-center mx-auto">
                        @svg('images/svg/map-pin-big.svg')
                    </div>
                    <div class="text-lg text-center">Адрес</div>
                    <div class="text-sm text-center">
                        @if (currentCity())
                        г.<span itemprop="addressLocality">{{ currentCity()->name }}</span><br>
                        @endif
                        <span itemprop="streetAddress">{!! rv(getAddress()) !!}</span>
                    </div>
                </div>
                <div class="advantage__item">
                    <div class="image__wraper icon-center mx-auto">
                        @svg('images/svg/mail-big.svg')
                    </div>
                    <div class="text-lg text-center">Email</div>
                    <div class="text-sm text-center">
                        <a href="mailto:{{ getEmail() }}" itemprop="email">{{ getEmail() }}</a>
                    </div>
                </div>
                <div class="advantage__item time">
                    <div class="image__wraper icon-center mx-auto">
                        @svg('images/svg/time-big.svg')
                    </div>
                    <div class="text-lg text-center">Режим работы</div>
                    <div class="text-sm text-center">
                        {!! rv(getScheduleHtml()) !!}
                    </div>
                </div>
                <div class="advantage__item">
                    <div class="image__wraper icon-center mx-auto">
                        @svg('images/svg/support-big.svg')
                    </div>
                    <div class="text-lg text-center">Городской номер</div>
                    <div class="text-sm text-center">
                        <a onclick="yaCounterTemp.reachGoal('call');" href="tel:{{ getPhone()['clear'] }}" itemprop="telephone">{{ getPhone()['format'] }}</a>
                    </div>
                </div>
                <div class="advantage__item">
                    <div class="image__wraper icon-center mx-auto">
                        @svg('images/svg/support-big.svg')
                    </div>
                    <div class="text-lg text-center">Бесплатный<br>федеральный номер</div>
                    <div class="text-sm text-center">
                        <a onclick="yaCounterTemp.reachGoal('call');" href="tel:{{ getPhone2()['clear'] }}">{{ getPhone2()['format'] }}</a><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="contacts-page__info">
        <div class="container">
            <div class="contacts-page__info__in text-center">
                <div class="icon icon-center mx-auto">
                    @svg('images/svg/phone-big.svg')
                </div>
                <div class="contacts-page__info__text">
                    Если у Вас срочный вопрос, позвоните в службу поддержки:
                </div>
                <div class="contacts-page__info__text__big">
                    <a class="color-red" onclick="yaCounter54742531.reachGoal('call');" href="tel:{{ getPhone2()['clear'] }}">
                        <strong>{{ getPhone2()['format'] }}</strong>
                    </a>
                    (звонок бесплатный)
                </div>
                <div class="contacts-page__info__text">
                    Также Вы можете обратиться к нам через форму обратной связи.
                </div>
            </div>
        </div>
    </div>
    <div class="contacts-page__form">
        <div class="container">
            <div class="col-xl-8 col-lg-9 mx-auto px-0">
                <h2 class="title text-center">Обратная связь</h2>
                <h3 class="subtitle text-center">* Обязательные поля для заполнения</h3>
                <form action="{{ route('callback.set.captcha') }}/" method="post" class="mx-auto js-form--contacts" enctype="multipart/form-data">
                    {{captcha()->inputs}}
                    @csrf
                    <div class="d-flex top-row flex-wrap">
                        <div class="form-group position-relative">
                            <label class="form-label" for="contacts-page-form-name">* Ваше имя</label>
                            <div class="form-control__wrapper">
                                <input class="form-control" id="contacts-page-form-name" type="text" name="name" placeholder="Введите имя" required="required">
                            </div>
                            <span class="icon position-absolute">
                                @svg('images/svg/user.svg')
                            </span>
                        </div>
                        <div class="form-group position-relative email">
                            <label class="form-label" for="contacts-page-form-email">* E-mail, на который будет отправлен ответ</label>
                            <div class="form-control__wrapper">
                                <input class="form-control" id="contacts-page-form-email" type="email" name="email" placeholder="Введите e-mail" required="required">
                            </div>
                            <span class="icon position-absolute">
                                @svg('images/svg/email.svg')
                            </span>
                        </div>
                    </div>
                    <div class="middle-row">
                        <label class="form-label">Выберите ваш вопрос</label>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="checkbox">
                                    <input type="radio" name="theme" class="" value="cooperation" >
                                    <span class="checkbox__text">Хочу предложить сотрудничество</span>
                                </label>
                                <label class="checkbox">
                                    <input type="radio" name="theme" class="" value="order-question" >
                                    <span class="checkbox__text">Вопрос по заказу</span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="checkbox">
                                    <input type="radio" name="theme" class="" value="complaint" >
                                    <span class="checkbox__text">Оставить жалобу на сотрудника</span>
                                </label>
                                <label class="checkbox">
                                    <input type="radio" name="theme" class="" value="question" checked="checked" >
                                    <span class="checkbox__text">Другой вопрос</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group textarea mr-0">
                        <label class="form-label" for="contacts-page-form-msg">* Ваше сообщение</label>
                        <div class="form-control__wrapper">
                            <textarea class="form-control" id="contacts-page-form-msg" placeholder="Введите текст сообщения" name="message" required="required"></textarea>
                        </div>
                    </div>
                    <div class="form-group file">
                        <label class="form-label">Приложите фотографию (скриншот)</label>
                        <div class="d-flex align-items-center">
                            <input type="file" multiple accept="image/*" class="d-none js-file-upload" name="upload_files[]" id="upload-files">
                            <button type="button" class="js-upload-btn btn btn-light btn-sm btn-upload">
                                <span class="icon">@svg('images/svg/cloud.svg')</span> Загрузить</button>
                            <div>
                                <label for="upload-files" class="js-file-upload-label upload-files-label">До 20 файлов (общий размер файлов — до 20 МБ).</label>
                                <label class="error js-file-upload-error d-none position-static" for="upload-files"></label>
                                <small class="text-muted js-file-upload-names"></small>
                            </div>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-submit mx-auto">Отправить</button>
                </form>
            </div>
        </div>
    </div>
    <div class="contacts" >
        @include('shared.mapContacts')
    </div>
</div>
@endsection

