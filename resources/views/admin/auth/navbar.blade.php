@if ($user)
    <style>.admin-image {
            border-radius: 50%;
        }</style>
    <li class="dropdown fast-actions" style="margin-right: 20px;">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            <span class="hidden-xs">
                <i class="fa fa-bolt"></i>
                Быстрые действия
            </span>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ route('admin.updatePrices') }}">
                    <i class="fa fa-btn fa-product-hunt"></i> Обновить цены
                </a>
            </li>
            <li>
                <a href="{{ route('admin.updateNames') }}">
                    <i class="fa fa-btn fa-edit"></i> Обновить названия
                </a>
            </li>
            <li>
                <a href="{{ route('admin.updateCities') }}">
                    <i class="fa fa-btn fa-map-marker"></i> Обновить города
                </a>
            </li>
            <li class="spacer">
                <hr>
            </li>
            <li>
                <a onclick="createByRemote()" style="cursor: pointer">
                    <i class="fa fa-btn fa-barcode"></i> Добавить товар из CRM
                </a>
            </li>
            <li class="spacer">
                <hr>
            </li>
            <li>
                <a href="{{ route('editor.meta') }}">
                    <i class="fa fa-btn fa-code"></i> Редактор мета
                </a>
            </li>
            <li class="spacer">
                <hr>
            </li>
            <li>
                <a href="/admin/editmode/{{_em()? 0 : 1}}">
                    <i class="fa fa-btn fa-pencil"></i> Режим редактора
                    @if(_em())
                        <span class="badge">ON</span>
                    @endif
                </a>
            </li>
            <li class="spacer">
                <hr>
            </li>
        </ul>
    </li>
    <li>
        <a style="cursor: pointer" onclick="getTinyPNGStatus()">
            <i class="fa fa-refresh"></i>
            TinyPNG
            <span class="badge" data-role="tiny-png"></span>
        </a>
    </li>
    <li>
        <a href="/" target="_blank">
            На сайт
        </a>
    </li>
    <li class="dropdown user user-menu" style="margin-right: 20px;">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            <span class="hidden-xs">{{ $user->email }}</span>
        </a>
        <ul class="dropdown-menu">
            <li class="user-footer">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-btn fa-sign-out"></i> Выход
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </li>
    <script type="text/javascript">
        function getTinyPNGStatus() {
            let $badge = $("span[data-role='tiny-png']");
            $.get({
                url: "{{route("api.status.tinypng")}}",
                error: function () {
                    $badge.html("<i class='fa fa-times'></i> Ошибка");
                },
                success: function (res) {
                    if (res.status >= 0) {
                        $badge.html(res.status + " / 500");
                    }
                    if (res.status > 400) {
                        $badge.html("<i class='fa fa-warning'></i> " + res.status + " / 500");
                    }
                    if (res.status < 0) {
                        $badge.html("<i class='fa fa-times'></i> Ошибка");
                        swal.fire("Ошибка ключа TinyPNG", res.message, "error");
                    }
                }
            })

        }
    </script>
    <script type="text/javascript">

        function createByRemote() {
            swal({
                title: 'Введите CRM ID',
                text: 'Введите один или несколько CRM ID через запятую',
                type: 'info',
                input: "text",
                inputValue: "",
                inputPlaceholder: "000, 000, 000",
                showCancelButton: true,
                confirmButtonText: 'Сохранить',
                cancelButtonText: "Отмена"
            }).then(function (result) {
                if (result.value !== undefined && result.value.length > 0) {
                    var sw = swal.fire({
                        title: 'Добавление товаров из CRM...',
                        allowOutsideClick: false,
                        type: 'info',
                        showConfirmButton: false,
                    });
                    $.ajax({
                        url: "/admin/products/create_by_remote",
                        data: {ids: result.value},
                        success: function (result) {
                            if (result.count > 0) {
                                swal({
                                    title: 'Добавлено ' + result.count + " товаров!",
                                    text: result.error,
                                    type: "success"
                                }).then(function () {
                                    document.location.href = "/admin/products";
                                });
                            } else {
                                swal({
                                    title: "Не было добавлено ни одного товара",
                                    text: result.error,
                                    type: "warning"
                                });
                            }

                        }
                    });
                }
            })
        }


    </script>
@endif
