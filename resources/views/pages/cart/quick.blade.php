@extends('layouts.app')
@section('content')
<div class="quick-page cart-page">
    <div class="container">
        @include('shared.breadcrumb')
        <h1 class="main-title text-center">Быстрый заказ</h1>
        <div class="js-quick-content">
            @include('shared.cart.quick')
        </div>
        <form action="{{ route('order.quick') }}/" method="POST" class="col-lg-8 px-0 mx-auto quick__form js-order__quick">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group position-relative">
                        <label class="form-label" for="quick-form-name">Ваше имя</label>
                        <div class="form-control__wrapper">
                            <input class="form-control js-focus" id="quick-form-name" type="text" name="name" placeholder="Введите имя">
                        </div>
                        <span class="icon position-absolute">
                            @svg('images/svg/user.svg')
                        </span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group position-relative">
                        <label class="form-label" for="quick-form-phone">* Ваш телефон</label>
                        <div class="form-control__wrapper">
                            <input class="form-control" id="quick-form-phone" type="tel" name="phone" placeholder="Ваш телефон" required="required">
                        </div>
                        <span class="icon position-absolute">
                            @svg('images/svg/call-answer.svg')
                        </span>
                    </div>
                </div>
                <div class="d-none">
                    <label for="review-agreement">
                        <input type="checkbox" name="agreement" id="review-agreement">
                        Я согласен с политикой.
                    </label>
                </div>
                <div class="col-sm-6 ">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    {{ csrf_field() }}
                    <button type="submit" class="btn ml-auto">Оформить заказ</button>
                </div>
                <div class="col-sm-6">
                    <a href="/" class="btn btn-light ">Вернуться на сайт</a>

                </div>

            </div>
        </form>
    </div>
</div>
@endsection

