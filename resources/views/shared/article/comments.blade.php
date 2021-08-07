<div class="container">
    <h2 class="main-title text-center my-5 font-weight-bold">Комментарии</h2>
    @if ($article->comments->where('status',1)->count())
    @foreach ($article->comments->where('status',1) as $comment)
    <div class="product-description__review {{ $loop->last ? 'last' : '' }}">
        <div class="col-xl-8 col-lg-10 px-lg-0 mx-auto">
            <div class="d-flex align-items-start">
                <div class="review__icon">
                    <img class="rounded-circle" src="/images/project/review-avatar.jpg" alt="avatar">
                </div>
                <div>
                    <div class="review__date">{{ $comment->updated_at->format('d.m.Y') }}</div>
                    <h3 class="review__title">
                        {!! rv($comment->name) !!}
                        {{-- @if ($comment->city)
                            <span class="ml-1">({{ $comment->city }})</span>
                        @endif --}}
                    </h3>
                    <div class="review__text"> {!! rv($comment->message) !!}</div>
                </div>
            </div>
        </div>
    </div>


    @endforeach
    @else
    <div class="product-description__review__empty-text mx-auto text-center">
        <img class="image d-block mx-auto" src="/images/project/review-empty.png" alt="">
        На данный момент у статьи нет комментариев.
        Оставьте свой комментарий, чтобы стать первым!
    </div>
    @endif
    <div class="col-xl-7 col-lg-10 mx-auto px-0">
        <form action="{{ route('comments.add') }}/" method="POST" class="review__form js-review__form">
            {{captcha()->inputs}}
            <h3 class="review__form__title text-center">Оставить комментарий</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group position-relative">
                        <label class="form-label" for="review-form-name">* Ваше имя</label>
                        <div class="form-control__wrapper">
                            <input class="form-control" id="review-form-name" type="text" name="name" placeholder="Введите имя" required="required">
                        </div>
                        <span class="icon position-absolute">
                            @svg('images/svg/user.svg')
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group position-relative">
                        <label class="form-label" for="review-form-email">* Ваш e-mail</label>
                        <div class="form-control__wrapper">
                            <input class="form-control" id="review-form-email" type="email" name="email" placeholder="Введите e-mail" required="required">
                        </div>
                        <span class="icon position-absolute">
                            @svg('images/svg/email.svg')
                        </span>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group position-relative">
                        <label class="form-label"
                                for="review-form-message">* Ваш комментарий
                        </label>
                        <div class="form-control__wrapper">
                            <textarea class="form-control"
                                    id="review-form-message"
                                    name="message"
                                    placeholder="Текст комментария"
                                    rows="3"
                                    required="required"></textarea>
                        </div>
                    </div>
                </div>
                <div class="d-none">
                    <label for="review-agreement">
                        <input type="checkbox" name="agreement" id="review-agreement">
                        Я согласен с политикой.
                    </label>
                </div>
                <div class="w-100"></div>
                <input type="hidden" name="type" value="Отправить отзыв">
                <input type="hidden" name="blog_id" value="{{ $article->id }}">
                {{ csrf_field() }}
                <button type="submit" class="btn mx-auto">Отправить</button>
            </div>
        </form>
    </div>
</div>
