<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0">
                    <tr class="top-line">
                        <td width="50%" colspan="2">Мы ответили на Ваш вопрос</td>
                        <td width="50%" colspan="2" class="text-right"><a href="{{ route('answer',$question->mail_hash) }}">Посмотреть письмо в браузере</a></td>
                    </tr>
                    <tr class="header">
                        <td width="25%" class="header-logo">
                            <a href="{{ route('front') }}">
                                <img class="logo" src="{{ asset('/images/icons/logotype.svg') }}" alt="izmermag.ru">
                            </a>
                        </td>
                        <td width="75%" colspan="3" class="header-td-center">
                            <div class="header-right">
                                <div class="header-helper">
                                    <img src="{{ asset('/images/project/mail-glob.png') }}" alt=" ">
                                    <a href="{{ route('front') }}">website</a>
                                </div>
                                <div class="header-item">
                                    <a href="mailto:{{ cv('email') }}">{{ cv('email') }}</a>
                                </div>
                            </div>
                            <div class="header-center">
                                <div class="header-helper">
                                    <img src="{{ asset('/images/project/mail-phone.png') }}" alt=" ">
                                    <span>Для всех регионов (звонок бесплатный)</span>
                                </div>
                                <div class="header-item">
                                    <a href="tel:{{ getPhone2()['clear'] }}">{{ getPhone2()['format'] }}</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="menu">
                        <td><a href="/catalog/">Каталог</a></td>
                        <td><a href="/news/">Новости</a></td>
                        <td><a href="/delivery/">Доставка и оплата</a></td>
                        <td><a href="/contacts/">Контакты</a></td>
                    </tr>
                    <!-- Email Body -->
                    <tr>
                        <td colspan="4" class="body" width="100%" cellpadding="0" cellspacing="0">
                            <div class="title">
                                Мы ответили на <strong>Ваш вопрос</strong>
                            </div>
                            <div class="question">
                                <div class="question__header d-flex">
                                    <span class="question-avatar">
                                        <img src="{{ asset($question->image ? $question->image : 'images/project/avatar.png') }}"
                                             alt="{{ $question->name }}">
                                    </span>
                                    <div class="question__title__wrapper">
                                        <div class="question__date">{{ $question->created_at->format('d.m.Y') }}</div>
                                        <h3 class="question__title">{!! rv($question->name) !!}</h3>
                                    </div>
                                </div>
                                <div class="question__text">
                                    {{ rv($question->question) }}
                                </div>
                            </div>
                            <div class="btn-wrapper">
                                <a class="btn" href="{{ $question->product->getUrl() }}#question-{{ $question->id }}">Посмотреть ответ</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="footer-top" width="100%" cellpadding="0" cellspacing="0">
                            {{ cv('coord') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="footer-bottom" width="100%" cellpadding="0" cellspacing="0">
                            Все права защищены <a href="{{ config('app.url') }}">{{ cv('site_name') }}</a> {{ date('Y') }} &copy;
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
        @media (max-width: 490px) {
            .header-td-center {
                padding: 0 !important;
            }
            .header-center {
                margin: 20px 30px !important;
            }
            .header-right {
                margin: 20px 30px 0 0 !important;
            }
        }
        .body {
            padding: 0 67px;
            background: #f6f6f6 !important;
        }

    </style>

</body>
</html>
