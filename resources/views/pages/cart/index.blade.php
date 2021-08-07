@extends('layouts.app')
@section('content')


<div class="cart-page">
    <div class="cart-page__top">
        <div class="container">
            @include('shared.breadcrumb')
            <h1 class="main-title text-center"><strong>Корзина</strong></h1>
            <div class="cart-page__content js-cart-page-content">
                @include('pages.cart.page-content')
            </div>
        </div>
    </div>

    @include('pages.cart.helper')
</div>

<div class="js-empty-form">
    @if (cart()->empty)
        @include("pages.cart.cart-empty-form")
    @endif
</div>
@endsection

{{--  --}}
