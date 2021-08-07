function getTinyPNGStatus() {
    let $badge = $("span[data-role='tiny-png']");
    $.get({
        url: "/api/status/tinypng",
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
