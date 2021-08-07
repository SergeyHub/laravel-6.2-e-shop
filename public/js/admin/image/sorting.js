function attachSorting(node)
{
    $(node).find('.form-element-files a').on('mousedown', function (e) {
        e.stopPropagation();
    });
    $(node).find('.form-element-files button').on('mousedown', function (e) {
        e.stopPropagation();
    });
    $(node).find('.dz-message').remove();
    $(node).find('.form-element-files').jesse({
        selector: '.form-element-files__item',
        placeholder: '<div class="form-element-files__placeholder"></div>',
        onStop: function (position, prevPosition, item) {
            console.log('Sorting ends, serializing');
            var result = [];
            $(node).find(".form-element-files").find(".form-element-files__item div[data-toggle='images_imgContainer']").each(function (i, v) {
                result.push($(this).attr("data-value"));
            });
            $(node).find(".form-element-files").parents('.form-group').find('input').attr("value",result.join());
            console.log(result);
        }

    });
}
/*
$(document).ready(function () {
    $('.form-element-files a').on('mousedown', function (e) {
        e.stopPropagation();
    });
    $('.form-element-files button').on('mousedown', function (e) {
        e.stopPropagation();
    });
    $('.dz-message').remove();
    $('.form-element-files').jesse({
        selector: '.form-element-files__item',
        placeholder: '<div class="form-element-files__placeholder"></div>',
        onStop: function (position, prevPosition, item) {
            console.log('Sorting ends, serializing');
            var result = [];
            $(".form-element-files").find(".form-element-files__item div[data-toggle='images_imgContainer']").each(function (i, v) {
                result.push($(this).attr("data-value"));
            });
            $(".form-element-files").parents('.form-group').find('input').attr("value",result.join());
            console.log(result);
        }

    });
});*/
