<div class="text-left">
    {{--    <a class="btn btn-info" onclick="downloadCSV()">
            <i class="fa fa-download"></i> Скачать CSV
        </a>--}}

    <input type="date" name="date_from" class="btn" value="{{\Carbon\Carbon::now()->format("Y-m-d")}}">
    <input type="date" name="date_to" class="btn" value="{{\Carbon\Carbon::now()->format("Y-m-d")}}">

    <a class="btn btn-info" onclick="fillDates()">
        <i class="fa fa-calendar"></i> Проставить дату
    </a>
    |
    <a class="btn btn-success" onclick="check()">
        <i class="fa fa-check"></i> Проверить
    </a>
    |
    <a class="btn btn-info" onclick="commit()">
        <i class="fa fa-save"></i> Сохранить
    </a>

</div>
<br>
<div class="spreadsheet_container">
    <div id="spreadsheet">Загрузка...</div>
</div>


<script type="text/javascript">
    //let URI = "";
    window.table = null;

    let tpl = ['', 'Товар', 'Имя', 'Отзыв'];
    let data = [["", "", "", ""]];


    document.addEventListener("DOMContentLoaded", function () {
        initTable();
        /* $.ajax({
             method: "GET",
             url: URI,
             success: initTable,
             error: function () {
                 swal.fire("Не удалось получить  данные!", "Произошла ошибка закгрузки данных", "error")
             }
         });*/
    });

    function isEmptyRow(instance, row) {
        var rowData = instance.countRows();

        for (var i = 0, ilen = rowData.length; i < ilen; i++) {
            if (rowData[i] !== null) {
                return false;
            }
        }

        return true;
    }

    function defaultValueRenderer(instance, td, row, col, prop, value, cellProperties) {
        var args = arguments;

        if (args[5] === null && isEmptyRow(instance, row)) {
            args[5] = tpl[col];
            td.style.color = '#999';
        } else {
            td.style.color = '';
        }
        Handsontable.renderers.TextRenderer.apply(this, args);
    }

    function initTable() {

        /*
            ---------------------------------------------------------------------
                   Понятия не имею, как это работает, код из документации
            ---------------------------------------------------------------------
         */


        var container = document.getElementById('spreadsheet');
        table = new Handsontable(container, {
            rowHeaders: true,
            //startRows: 16,
            colHeaders: ['Дата дд.мм.гггг', 'Товар', 'Имя', 'Отзыв'],
            //startCols: 4,
            filters: true,
            dropdownMenu: true,
            height: 650,
            colWidths: 200,
            licenseKey: 'non-commercial-and-evaluation',

            startRows: 8,
            startCols: 4,
            minSpareRows: 1,
            contextMenu: true,

            cells: function (row, col, prop) {
                var cellProperties = {};

                cellProperties.renderer = defaultValueRenderer;

                return cellProperties;
            },

            beforeChange: function (changes) {
                var instance = table,
                    ilen = changes.length,
                    clen = instance.countCols(),
                    rowColumnSeen = {},
                    rowsToFill = {},
                    i,
                    c;

                for (i = 0; i < ilen; i++) {
                    // if oldVal is empty
                    if (changes[i][2] === null && changes[i][3] !== null) {
                        if (isEmptyRow(instance, changes[i][0])) {
                            // add this row/col combination to cache so it will not be overwritten by template
                            rowColumnSeen[changes[i][0] + '/' + changes[i][1]] = true;
                            rowsToFill[changes[i][0]] = true;
                        }
                    }
                }
                for (var r in rowsToFill) {
                    if (rowsToFill.hasOwnProperty(r)) {
                        for (c = 0; c < clen; c++) {
                            // if it is not provided by user in this change set, take value from template
                            if (!rowColumnSeen[r + '/' + c]) {
                                changes.push([r, c, null, tpl[c]]);
                            }
                        }
                    }
                }
            }
        });
    }

    function fillDates() {
        let date_from = moment($("[name='date_from']").val());
        let date_to = moment($("[name='date_to']").val());
        let length = table.countRows();
        let data = table.getData;
        for (let i = 0; i < length - 1; i++) {
            let date = moment(date_from + Math.random() * (date_to - date_from));
            let value = date.format("DD.MM.YYYY");

            table.setDataAtCell(i, 0, value);


        }


    }

    function commit() {
        let data = table.getData();
        swal.fire({
            title: 'Сохранение...',
            type: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
        });
        $.ajax({
            method: "POST",
            url: "{{route("admin.review.generator.commit")}}",
            data: {
                rows: data
            },
            success: function (data) {
                if (data.status) {
                    window.location.href = "/admin/reviews?status=0";
                } else {
                    swal.fire("Данные некорректны", data.message, "warning");
                }
            },
            error: function () {
                swal.fire("Не удалось сохранить данные!", "Произошла ошибка сохранения данных", "error")
            }
        });
    }

    function check() {
        let data = table.getData();
        swal.fire({
            title: 'Проверка...',
            type: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
        });
        $.ajax({
            method: "POST",
            url: "{{route("admin.review.generator.check")}}",
            data: {
                rows: data
            },
            success: function (data) {
                if (data.status) {
                    swal.fire("Корректно", "Ошибок нет", "success");
                } else {
                    swal.fire("Данные некорректны", data.message, "warning");
                }

            },
            error: function () {
                swal.fire("Не удалось проверить данные!", "Произошла ошибка передачи данных", "error")
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