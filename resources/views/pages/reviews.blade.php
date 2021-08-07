@extends('layouts.app')
@section('content')
@include('shared.breadcrumb')
<div class="container">
    <div class="product-card">
        <div class="row">
            @foreach ($reviews as $review)
            <div class="product-desc__review d-flex align-items-start flex-column flex-md-row">
                <img class="review__image d-block lazy" data-src="{{ asset($review->image) }}" alt="{{ rv($review->name) }}">
                <div class="review__content">
                    <div class="d-flex align-items-center mb-3 flex-column flex-md-row">
                        <h3 class="review__content__title">{{ rv($review->name) }}</h3>
                        <div class="d-flex justify-content-center">
                            @for ($i = 1; $i < 6; $i++)
                            <div class="star mr-1 {{ $i <= $review->rate ? 'active': '' }}"></div>
                            @endfor
                        </div>
                    </div>
                    <div class="review__content__text">
                        {!! rv($review->message_full) !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
