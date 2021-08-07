document.addEventListener('DOMContentLoaded', function () {
    $("[data-toggle='copy']").click(function () {
        copyToClipboard($(this).text());
    });
    $(".variables-help a.shortcut").click(function(){
        $(this).parent().toggleClass("expanded");
    });
    $(".content.body").click(function(){
        $(".variables-help").removeClass("expanded");
    })
});

function copyToClipboard(str) {
    let el = document.createElement('textarea');
    el.value = str;
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
}
