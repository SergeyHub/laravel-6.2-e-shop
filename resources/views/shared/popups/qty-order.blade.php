<div class="callback-pop modal fade" id="qty-pop" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content position-relative">
            <div class="modal-header">
                <div class="modal-header__icon image__wraper icon-center">
                    @svg('images/svg/phone-big.svg')
                </div>
                <div class="close position-absolute" data-dismiss="modal" aria-label="Закрыть">
                    <img data-src="{{ asset('images/svg/close.svg') }}" class="lazy" alt="Закрыть">
                </div>
            </div>
            <div class="modal-body text-center">
                <div id="qty_status">
                    <div class="main-title color-black">Товар под заказ</div>
                    <div class="modal-body__text">
                        Оставьте свои данные и наш менеджер свяжется с Вами <strong>в течение 3 минут</strong>
                    </div>
                </div>
                <form action="{{ route('callback.qty') }}/" method="post" class="mx-auto js-form--more-info5">
                    <div class="row justify-content-center text-left ">
                        <div class="col-lg-4">
                            <div class="form-group position-relative">
                                <label class="form-label" for="modal-preorder-form-name">* Ваше имя</label>
                                <div class="form-control__wrapper">
                                    <input class="form-control" id="modal-preorder-form-name" type="text" name="name"
                                           placeholder="Введите имя" required="required">
                                </div>
                                <span class="icon position-absolute">
                                    @svg('images/svg/user.svg')
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group position-relative">
                                <label class="form-label" for="modal-preorder-form-tel">* Ваш телефон</label>
                                <div class="form-control__wrapper">
                                    <input class="form-control" id="modal-preorder-form-tel" type="tel" name="phone"
                                           placeholder="+7" required="required">
                                </div>
                                <span class="icon position-absolute">
                                    @svg('images/svg/call-answer.svg')
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body__btns d-flex justify-content-center">
                        <input type="hidden" name="product" value="">
                        {{csrf_field()}}
                        <a onclick="sendOrderQTYPopup()" class="btn btn-under-order-card color-white">Отправить</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
