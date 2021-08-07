<div class="text-center">
    {{--    <a class="btn btn-info" onclick="downloadCSV()">
            <i class="fa fa-download"></i> Скачать CSV
        </a>--}}
    <a class="btn btn-info" onclick="save()">
        <i class="fa fa-save"></i> Сохранить
    </a>
</div>
<br>
<div class="spreadsheet_container">
    <div id="spreadsheet">Загрузка...</div>
</div>


<script type="text/javascript">
    let URI = "{{route("editor.meta.data")}}";
    let table = null;
    document.addEventListener("DOMContentLoaded", function () {

        $.ajax({
            method: "GET",
            url: URI,
            success: initTable,
            error: function () {
                swal.fire("Не удалось получить  данные!", "Произошла ошибка закгрузки данных", "error")
            }
        });
    });


    function initTable(data) {
        var container = document.getElementById('spreadsheet');
        table = new Handsontable(container, {
            data: data,
            rowHeaders: true,
            colHeaders: ['Class', "Модель", "ID", "Heading", 'URI', 'Page Title', 'Meta Description', 'Meta Keywords'],
            filters: true,
            dropdownMenu: true,
            height: 650,
            hiddenColumns:
                {
                    columns: [0]
                },

            columns: [
                {data: 'class', readOnly: true},
                {data: 'name', readOnly: true},
                {data: 'id', readOnly: true},
                {data: 'heading', width: 260},
                {data: 'path', width: 260},
                {data: 'title', width: 260},
                {data: 'description', width: 260},
                {data: 'keywords', width: 260},

            ],
            licenseKey: 'non-commercial-and-evaluation'
        });
    }

    /* function downloadCSV() {
         table.download("csv", "{{"meta_".($_SERVER['SERVER_NAME'])."_".date('d.m.Y')."_".date('H.i').".csv"}}")
    }*/

    function save() {
        let data = table.getData();
        swal.fire({
            title: 'Сохранение...',
            type: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
        });
        $.ajax({
            method: "POST",
            url: URI,
            data: {
                rows: data
            },
            success: function () {
                swal.fire("Сохранено!", "данные успешно сохранены", "success")
            },
            error: function () {
                swal.fire("Не удалось сохранить данные!", "Произошла ошибка сохранения данных", "error")
            }
        });
    }

</script>


<style>
    .spreadsheet_container {
        display: block;
        max-width: 100%;
        overflow: scroll;
    }
</style>
