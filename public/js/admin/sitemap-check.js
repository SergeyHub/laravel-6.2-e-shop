var spinner;
var progress;

var links = [];
var total = 0;
var link_errors = 0;
var page_errors = 0;

function Log(entry, type = "default") {
    let icon = "asterisk";
    switch (type) {
        case "danger":
            icon = "times"
            break;
        case "warning":
            icon = "warning"
            break;
        case "info":
            icon = "info"
            break;
        case "success":
            icon = "check"
            break;
    }
    let time = moment().format("h:mm:ss");
    let contents = `<p><b><i class="fa fa-history"></i> ${time} :</b>&nbsp;<span class="label label-${type}"><i class="fa fa-${icon}"></i> ${entry}</span></p>`;
    $("#diag").append($(contents));
}

function parseUrls(xml) {
    Log("Извлекаю ссылки...");
    xml = (new XMLSerializer()).serializeToString(xml.documentElement);
    //
    let re = /<loc>(.*)<\/loc>/g;
    while ((matches = re.exec(xml)) !== null) {
        links.push(matches[1]);
    }
    if (links.length > 0) {
        Log(`Найдено ${links.length} ссылок`, "success");
        checkLinks();
    } else {
        Log(`Найдено ${links.length} ссылок`, "danger");
    }

}

function checkLinks() {
    let re = /http.*:\/\/.*/;
    $.each(links, function (i, v) {
        if (!v.match(re)) {
            Log(`Некорретная ссылка: ${v}`, "warning");
            link_errors++;
        }
    });
    setProgress(0);
    if (link_errors > 0) {
        Log(`Проверка ссылок завершена, обнаружено ${link_errors} проблем`, "warning");
        swal("Обнаружены ошибки!", `Во время проверки ссылок были обнаружены проблемы в написании адресов`, "warning");
    } else {
        Log("Проверка ссылок завершена, проблем не обнаружено", "success");
    }
    Log("Не забудьте запустить проверку страниц!", "info");
    spinner.fadeOut();
    $(".check-pages").fadeIn();
}

function checkNextLink() {
    if (links.length > 0) {
        link = links.pop();
        var xhr = new XMLHttpRequest();
        xhr.open("GET", link, true);
        let time = Date.now();
        xhr.onload = function () {
            let code = xhr.status;
            if (code >= 400 && code <= 499) {
                Log(`ОШИБКА ДАННЫХ (${code}) - ${link}`, "danger");
                page_errors++;
            }
            if (code >= 500 && code <= 599) {
                Log(`ОШИБКА СЕРВЕРА (${code}) - ${link}`, "danger");
                page_errors++;
            }
            if (xhr.responseURL !== link) {
                Log(`РЕДИРЕКТ - ${link} > ${xhr.responseURL}`, "danger");
                page_errors++;
            }
            let TFB = Date.now() - time;
            if (TFB > 400 && TFB < 1000) {
                Log(`TFB превышен (${TFB} мс) - ${link}`, "warning");
            }
            if (TFB > 1000) {
                Log(`TFB <b>сильно</b> превышен (${TFB} мс) - ${link}`, "danger");
                page_errors++;
            }
            setProgress(total - links.length, total);
            checkNextLink();
        }
        xhr.send()
    } else {
        setProgress(0);
        if (page_errors > 0) {
            Log(`Проверка страниц завершена, обнаружено ${page_errors} ошибок`, "warning");
            swal("Обнаружены ошибки!", `Были обнаружены страницы с ошибками данных, сервера или перенаправлениями`, "warning");
        } else {
            Log("Проверка страниц завершена, проблем не обнаружено", "success");
        }
        spinner.fadeOut();
    }
}

function loadSitemap() {
    let time = Date.now();
    Log("Скачиваю Sitemap.xml...");
    setProgress(25);
    $.get({
        url: "/sitemap.xml",
        success: function (result) {
            let passed = Date.now() - time;
            Log(`Sitemap.xml загружен, ${passed} мс`, "success");
            //
            setProgress(75);
            parseUrls(result);
        },
        error: function () {
            spinner.fadeOut();
            swal("Ошибка", "Не удалось получить Sitemap.xml", "error");
            Log("Не удалось получить карту сайта", "danger");

        }
    });
}

function startLinksChecking() {
    $(".check-links").fadeOut();
    spinner.fadeIn();
    Log("Проверка ссылок запущена", "info");
    loadSitemap();
}

function startPagesChecking() {
    $(".check-pages").fadeOut();
    spinner.fadeIn();
    Log("Проверка страниц запущена", "info");
    total = links.length;
    checkNextLink();
}

function setProgress(current, from = 100) {
    let step = 100 / from;

    progress.css("width",Math.round(step*current)+"%");
}

document.addEventListener("DOMContentLoaded", function () {
    spinner = $(".loader");
    progress = $("#progress");
    spinner.fadeOut();
});


