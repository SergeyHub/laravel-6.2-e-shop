<li class="dropdown fast-actions">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            <span class="hidden-xs">
                <i class="fa fa-bolt"></i>
                Быстрые действия
            </span>
    </a>
    <ul class="dropdown-menu">
        <li class="spacer">
            <hr>
        </li>
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
        <li>
            <a href="{{ route('admin.catalog.update') }}">
                <i class="fa fa-btn fa-table"></i> Обновить каталог
            </a>
        </li>
        <li class="spacer">
            <hr>
        </li>
        <li>
            <a href="{{ route('admin.products.download') }}">
                <i class="fa fa-btn fa-download"></i> Получить всё
            </a>
        </li>
        <li>
            <a href="{{ route('admin.products.upload') }}">
                <i class="fa fa-btn fa-upload"></i> Отправить всё
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
