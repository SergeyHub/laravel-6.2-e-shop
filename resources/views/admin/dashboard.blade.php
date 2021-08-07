<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box info-box-small">
            <span class="info-box-icon bg-aqua"><i class="fa fa-product-hunt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Товаров</span>
                <span class="info-box-number">{{ $counts['products'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box info-box-small">
            <span class="info-box-icon bg-red"><i class="fa fa-fw fa-file-image-o"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Городов</span>
                <span class="info-box-number">{{ $counts['cities'] }}</span>
            </div>
        </div>
    </div>
    <div class="clearfix visible-sm-block"></div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box info-box-small">
            <span class="info-box-icon bg-yellow"><i class="fa fa-fw fa-quote-right"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Отзывов</span>
                <span class="info-box-number">{{ $counts['reviews']  }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box info-box-small">
            <span class="info-box-icon bg-green"><i class="fa fa-shopping-cart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Всего заказов</span>
                <span class="info-box-number">{{  $counts['orders']}}</span>
            </div>
        </div>
    </div>
</div>
<div id="handleActionsContainer">
    <div class="row" id="handleActions">
        @if (count($reviews))
            <div class="col-md-4">
                @include("admin.dashboard.reviews")
            </div>
        @endif
        @if (count($comments))
            <div class="col-md-4">
                @include("admin.dashboard.comments")
            </div>
        @endif
        @if (count($questions))
            <div class="col-md-4">
                @include("admin.dashboard.questions")
            </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-md-5">
        @include("admin.dashboard.history")
    </div>
    <div class="col-md-7">
        @include("admin.dashboard.messages")
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @include("admin.dashboard.orders")
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @include("admin.dashboard.callbacks")
    </div>
</div>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        let count = {{count($reviews) + count($comments) + count($questions)}};
        if (count > 0)
        {
            swal("Новые запросы!", count+" запросов требуют внимания", "warning");
        }

    });

    function reloadContainer(target, source, callback) {
        $(target).load(document.location.href + " " + source, callback);


    }

    function defineHandlers(container) {

        console.log("Define handlers for "+container);

        let csrf = "{{csrf_token()}}";

        $(container).find("a[data-toggle='expand-message']").click(function () {
            swal($(this).parent().find("p.message").text());
        });

        $(container).find("a[data-toggle='handle']").click(function () {
            let method = $(this).data("method");
            let url = $(this).data("url");
            let name = $(this).data("name");
            let value = $(this).data("value");

            let data = {_token: csrf, _method: method};
            if (name !== undefined)
            {
                data[name] = value;
            }

            swal.fire({
                title: 'Обработка...',
                allowOutsideClick: false,
                type: 'info',
                showConfirmButton: false,
            });

            $.ajax({
                method: "post",
                url: url,
                data: data,
                complete: () => {

                    reloadContainer("#handleActionsContainer","#handleActions",()=>{
                        swal.close();
                        defineHandlers("#reviews");
                        defineHandlers("#questions");
                        defineHandlers("#comments");
                    });
                }
            })
        });

        $(container).find("a[data-toggle='handle-qa']").click(function () {
            let method = $(this).data("method");
            let url = $(this).data("url");
            let value = null;

            let apply = function (value)
            {
                swal.fire({
                    title: 'Обработка...',
                    allowOutsideClick: false,
                    type: 'info',
                    showConfirmButton: false,
                });

                $.ajax({
                    method: "post",
                    url: url,
                    data: {_token: csrf, _method: method, answer: value},
                    complete: () => {
                        reloadContainer("#handleActionsContainer","#handleActions",()=>{
                            swal.close();
                            defineHandlers("#reviews");
                            defineHandlers("#questions");
                            defineHandlers("#comments");
                        });
                    }
                })
            }

            swal({
                input: "textarea",
                title: "Быстрый ответ",
            }).then((result) => {
                if(result.value)
                {
                    //console.log("Result: " + result.value)
                    apply(result.value);
                }

            });

        });
    }
</script>
