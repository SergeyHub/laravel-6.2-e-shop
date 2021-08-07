<a class="btn btn-success" href="{{ route('admin.updatePrices') }}"><i class="fa fa-ruble"></i> Обновить цены с CRM</a>
<a class="btn btn-success" href="{{ route('admin.updateNames') }}"><i class="fa fa-barcode"></i> Загрузить имена товаров из CRM</a>
<a class="btn btn-warning" onclick="createByRemote()" ><i class="fa fa-level-down"></i> Добавить товар из CRM</a>
<script type="text/javascript">

    function createByRemote()
    {
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
            if(result.value !== undefined && result.value.length > 0)
            {
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
                        if (result.count > 0)
                        {
                            swal({
                                title: 'Добавлено '+result.count+" товаров!",
                                text: result.error,
                                type: "success"
                            }).then(function () {
                                document.location.reload();
                            });
                        }
                        else
                        {
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