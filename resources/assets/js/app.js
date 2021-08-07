
require('./bootstrap');
require('./catalog');
require('./sliders');
require('./forms');
require("./promocode-handler")

window.yaCounterTemp = {
    reachGoal: function (goal) {
        console.log(goal);
    }
}
$(document).ready(function () {
    $('.lazy').Lazy();


    $(document).on('click', '.js-switch-category_link', function () {

        $('.js-switch-category_link').removeClass('active');
        $(this).addClass('active');
        $('.js-type-category-item').addClass('opacity');
        setTimeout(() => {
            $('.js-type-category_name').html($(this).find('.js-switch-category_name').html());
            $('.js-type-category_ico').html($(this).find('.js-switch-category_ico').html());
            $('.js-type-category_text').html($(this).data('text'));
            $('.js-type-category_image').attr('src',$(this).data('image'));
            $('.js-type-category-item').removeClass('opacity');
        },500);
        return false;
    });
    $('[type="tel"]').mask('+0 (000) 000-00-00', {
        placeholder: "+7 (___)___-__-__",
        //clearIfNotMatch: true,
        onKeyPress: function (cep, event, currentField, options) {
            //alert(cep);
            switch (cep) {
                case "+8":
                    $(currentField).val("+7 (");
                    break;
                case "+0":
                case "+1":
                case "+2":
                case "+3":
                case "+4":
                case "+5":
                case "+6":
                case "+9":
                    $(currentField).val("+7 ("+cep.slice(-1));
                    break;
            }
        }
    });
    $('form').on('keyup keypress', 'input', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
          e.preventDefault();
          return false;
        }
    });
    if ($('.js-types').length) {
        setInterval(() => {
            let index = $('.js-type-item.active').data('num');
            index++;
            if (!$('#main-types__tabs-'+index).length) {
                index = 1;
            }
            $('.js-type-link').removeClass('active');
            $('.js-type-item').removeClass('active');
            $('#js-type-link-'+index).addClass('active');
            $('#main-types__tabs-'+index).tab('show');
        },5000);
    }
    $('.js-delivery-tab').on('shown.bs.tab', function (e) {
        let title = $(e.target).data('title');
        let subtitle = $(e.target).data('subtitle');
        $('.js-delivery-title').html(title);
        $('.js-delivery-subtitle').html(subtitle);
    });
    $('[name="search_city"]').keyup(function (e) {
        var val = $(this).val().toLowerCase();
        if (val) {
            $('.city-name').each(function (index, element) {
                if ($(element).text().toLowerCase().indexOf(val) != -1) {
                    $(element).removeClass('d-none').addClass('show');
                } else {
                    $(element).removeClass('show').addClass('d-none');
                }
            });

        } else {
            $('.city-name.show-default').removeClass('d-none').addClass('show');
            $('.city-name.hide-default').addClass('d-none').removeClass('show');

        }
        $('.city_cart').each(function (index, element) {
            if ($(element).find('.show').length) {
                $(element).removeClass('d-none');
            } else {
                $(element).addClass('d-none');
            }

        });
    });
    $('.js-type-card').hover(function () {
        $(this).addClass('hover');

    }, function () {
        $(this).removeClass('hover');
    });


    $('body').on('click', function () {
        $('.catalog__item').removeClass('hover');
    });
    $('body').on('click', '.js-catalog-item-info', function () {
        $(this).parent().toggleClass('hover');
        return false;
    });
    $('body').on('click', '.js-show_description', function () {
        $(this).parents('.js-advantage_item').find('.js-advantage_description').removeClass('d-none');
        return false;
    });
    $('body').on('click', '.js-hide_description', function () {
        $(this).parents('.js-advantage_item').find('.js-advantage_description').addClass('d-none');
        return false;
    });
    $('body').on('click','.js-choose', function () {
        $('.js-choose').removeClass('active');
        $(this).addClass('active');
        var target = $(this).data('target');
        $('.js-unpacking__box').addClass('d-none');
        $(target).removeClass('d-none');
        return false;
    });

    //faq аккардеон
    $('.faq-list .faq-name').click(function() {
        var current = $(this);
        if (!current.hasClass('active')){
            $('.faq-list .faq-text').not(current.next()).slideUp();
            $('.faq-list li').not(current.parent()).removeClass('active');
            current.next().slideDown().parent().addClass('active');
            current.addClass('active');
        } else {
            $('.faq-list li').removeClass('active');
            current.removeClass('active');
            $('.faq-list .faq-text').slideUp();
        }
    });

    //скрытие оверлея
    $('.overlay .return a, .overlay .close-modal, .overlay-out').click(function(){
        $('.overlay-in').hide();
        $('.overlay').scrollTop(0);
        $('body').removeClass('inactive');
        return false;
    });
    //скрытие оверлея
    $('.overlay .js-close-modal').click(function(){
        $('.overlay-in').hide();
        $('.overlay').scrollTop(0);
        $('body').removeClass('inactive');

        return false;
    });


    //закрыть перезвон
    $('.recall-pop .close').click(function(){
        $(this).parents('.recall-pop').fadeOut();
    });

    //перезвон
    $('.recall-btn a').click(function(){
        $(this).next().fadeIn();
        return false;
    });

    //скролл к верху
    $('.slide-to-top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    //открытие корзины
    /* $('header .cart-block a').click(function(){
        $('body').addClass('inactive');
        $('.overlay .cart-pop').fadeIn();
        return false;
    });
    $('.js-open_cart').click(function(){
        $('.overlay-in').hide();
        $('body').addClass('inactive');
        $('.overlay .cart-pop').fadeIn();
        return false;
    });  */

    //pop-up с благодарочкой
    $('.pop-up-show').click(function(){
        $('body').addClass('inactive');
        $('.overlay .thankfulness, .overlay .take-price').fadeIn();
        return false;
    });

    //список городов
    $('.contact-header .current-location').click(function(){
        $('body').addClass('inactive');
        $('.overlay .city-list-box').fadeIn();
        return false;
    });

    //left-fixed
    var vh = $('.left-fixed').height();
    $('.left-fixed').css('margin-top', -vh/2 + 'px');

    //dropdown filter
    $('.popularity .current').click(function(){
        $(this).next('.dropdown').fadeToggle();
    });
    $('.dropdown a').click(function(){
        var value = $(this).text();
        $('.popularity .current').text(value);
        $('.dropdown').fadeOut();
        $('.js-filter-form [name="order"]').val($(this).data('order'));
        $('.js-filter-form [name="sort"]').val($(this).data('sort'));
        $('.js-filter-form').submit();
        return false;
    })
    $(document).on('click','.js-filter-cat', function () {
        $('.js-filter-cat').removeClass('active');
        $(this).addClass('active');
        $('.js-filter-form [name="cat"]').val($(this).data('id'));
        $('.js-filter-form').submit();
        return false;
    });

    $(document).on('click','.js-more__link', function () {
        $(this).text('Свернуть');
        $(this).prev('.description').addClass('-is-open');
        $(this).addClass('js-hide__link');
        $(this).removeClass('js-more__link');
        /* $(this).parents('.js-review_item').find('.description .js-add_description').removeClass('d-none');
        $(this).parents('.js-review_item').find('.description .js-dots').addClass('d-none'); */
        changeReviewSize();
        return false;
    });
    $(document).on('click','.js-open-description', function () {
        $(this).removeClass('js-open-description').addClass('js-close-description');
        $(this).parents('.js-catalog__item').addClass('-is-open').find('.js-description').removeClass('d-none');
    });
    $(document).on('click','.js-close-description', function () {
        $(this).removeClass('js-close-description').addClass('js-open-description');
        $(this).parents('.js-catalog__item').removeClass('-is-open').find('.js-description').addClass('d-none');
    });
    $(document).on('click','.js-upload-btn', function () {
        $('[type="file"]').click();
        return false;
    });
    $('.js-file-upload').change(function() {
        console.log($(this)[0].files);
        let files = Array.from($(this)[0].files);
        let title = 'До 20 файлов (общий размер файлов — до 20 МБ).';
        let names = '';
        if (files.length > 20) {
            $('.js-file-upload-error').removeClass('d-none')
                                    .addClass('d-block')
                                    .text('Вы выбрали больше 20ти файлов');
            $('.js-file-upload-names').html(names);
            $(this).val('');
            return;
        }
        let size = files.reduce((size, file) => {return size + file.size},0);
        size = size / 1024 / 1024;
        if (size > 20) {
            $('.js-file-upload-error').removeClass('d-none')
                                    .addClass('d-block')
                                    .text('Общий размер файлов больше 20 МБ');
            $('.js-file-upload-names').html(names);
            $(this).val('');
            return;
        }
        $('.js-file-upload-error').removeClass('d-block')
                                    .addClass('d-none')
                                    .text('');
        names = files.reduce((name, file) => {return name +'<br>'+ file.name},'');
        $('.js-file-upload-names').html(names);
        console.log(size);
        let file = $(this)[0].files[0].name;
        $(this).prev('label').find('.text').text(file);
    });
    $(document).on('click','.js-show-brand-more' , function () {
        if ($(this).hasClass('-is-open')) {
            $(this).removeClass('-is-open').text('Показать еще...').prev().removeClass('-is-open');
        } else {
            $(this).addClass('-is-open').text('Свернуть').prev().addClass('-is-open');
        }
        return false;
    });
    setTimeout(showCategories, 500)
    function showCategories() {
        $('.js-brand__list').each(function (index, wp) {
            let wrapper = $(wp).width();
            $(wp).find('.js-brand__item').each(function (index, element) {
                let width = $(element).width();
                wrapper -= width;
                if (wrapper >= 0) {
                    $(element).prev().removeClass('last')
                    $(element).addClass('show').addClass('last');
                } else {
                    $(element).removeClass('show');
                }

            });

        });
    }
    $('.filter-line a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        showCategories();
    })
    function changeReviewSize() {
        var height = 0;
        $('.js-review_item').css('height','auto');
        $('.js-review_item').each(function (index, element) {
            if ($(element).height() > height) {
                height = $(element).height();
            }
            //console.log(height);
        });

        $('.js-review_item').css('height',height);

    };
    $(document).on('click','.js-hide__link', function () {
        $(this).html('Читать полностью');
        $(this).prev('.description').removeClass('-is-open');
        $(this).addClass('js-more__link');
        $(this).removeClass('js-hide__link');
        $(this).parents('.js-review_item').find('.description .js-add_description').addClass('d-none');
        $(this).parents('.js-review_item').find('.description .js-dots').removeClass('d-none');
        changeReviewSize();
        return false;
    });
    $(document).on('click','.js-reviews-more', function () {
        $('.review').removeClass('adds');
        $(this).remove();
        return false;
    });

    //focus on modal open
    $( "#callbackorder-pop" ).on('shown.bs.modal', function(){
        $(this).find("input[type=text]:first").focus();
    });

    //focus on first field if exist
    $(".js-focus:first").focus();
});

$(document).mouseup(function (e) {
    var container = $(".recall-pop, .dropdown");
    if (container.has(e.target).length === 0) {
        container.fadeOut();
    }
});
$(document).ready(function ($) {
    let selectedTab = window.location.hash;
    if (window.innerWidth >= 992 && $('img').hasClass('first-screen__image__gif')) {
        let image = document.getElementById('first-screen__image__gif');
        if (image.complete) {
            $('.first-screen__image__preview').addClass('hide');
            $('.first-screen__image__gif').addClass('show');
            //alert('loaded');
        }
        $('.first-screen__image__gif').attr('src',$('.first-screen__image__gif').data('src'));
    }
    function restartMarkAnimation() {
        $('.types__item__mark').removeClass('animated');
        setTimeout(() => {$('.types__item__mark').addClass('animated')},300);
    }
    $(document).on('click', function (e) {
        if ($('div').hasClass('js-types-link')) {
            $('.types__item__tooltip').removeClass('d-block').addClass('d-none');
            $(this).find('.types__item__mark').removeClass('-is-open');
            $('.js-types-link').removeClass('-is-open');
            restartMarkAnimation();
        }

    });

    $(document).on('click','.types__item__mark.-is-open', function (e) {
        $(this).parents('.js-types-link').find('.types__item__tooltip')
                .removeClass('d-block')
                .addClass('d-none');
        $(this).removeClass('-is-open');
        $(this).parents('.js-types-link').removeClass('-is-open');
        restartMarkAnimation();
        return false;
    });
    $(document).on('click','.js-types-link', function (e) {
        $(this).find('.types__item__tooltip').removeClass('d-none').addClass('d-block');
        $(this).find('.types__item__mark').addClass('-is-open');
        $(this).addClass('-is-open');
        return false;
    });
    if (selectedTab.includes('question-')) {
        $('.nav-link[data-target="#product-desc-04"]' ).trigger('click');
        setTimeout(function () {
            $(selectedTab)[0].scrollIntoView({behavior:'smooth'});
        },500);


    } else {
        $('.nav-link[data-target="' + selectedTab + '"]' ).trigger('click');
    }
})
function showActiveMenuItem(e, e2) {
    var top = window.pageYOffset;
    var itemTop;
    var items = $(e2);
    var itemI;
    var itemH;
    var anchor;
    var height = parseInt($(window).height() / 3);

    items.each(function (i, elem) {
        anchor = $(this).attr('href');
        if ($(anchor).length > 0) {
            itemTop = window.pageYOffset + $(anchor)[0].getBoundingClientRect().top;
            if (top >= (itemTop - height)) {
                itemI = i;
                itemH = itemTop;
            }
        }

    });

    if (itemI >= 0) {
        $(items).removeClass('active');
        items.eq(itemI).addClass('active');
    }

    if (items.eq(0).hasClass('active') || items.eq(6).hasClass('active')) {
        $('.js-left-fixed').addClass('white');
    } else {
        $('.js-left-fixed').removeClass('white')
    }/*
    if (items.eq(8).hasClass('active')) {
        $('.js-left-fixed').addClass('invert')
    } else {
        $('.social-right').removeClass('invert')
    } */


}
$(document).on('click', 'a[href^=\\#]:not([href=\\#]),a[href^=\\/\\#]:not([href=\\#])', function (event) {
    var anchor = _.replace($(this).attr('href'), '/', '');
    var itemTop = window.pageYOffset + $(anchor)[0].getBoundingClientRect().top;

    if ($(anchor).length > 0) {
        $('html, body').stop().animate({
            scrollTop: itemTop
        }, 500);
        $('.left-fixed a').removeClass('active');
        $(this).addClass('active')
        if (anchor == ('#box-04') || anchor == ('#box-09')){
            $('.left-fixed').addClass('white')
        } else {
            $('.left-fixed').removeClass('white')
        }
        if(anchor == ('#box-09')){
            $('.social-right').addClass('invert');
        } else {
            $('.social-right').removeClass('invert');
        }
        return false;
    }
});

$(document).on('load resize scroll ready', function () {
    showActiveMenuItem(this, '.js-left-fixed a');
});
$('#callbackorder-pop').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var title = button.data('title')
    if (!title) {
        title = 'Получить консультацию';
    }
    //console.log(title)
    var modal = $(this)
    modal.find('.js-title').html(title)

})

$(document).ready(function () {
    $('#order-pop').on('hidden.bs.modal', function (e) {
        location.href = '/';
    });
    if(window.location.hash) {
       // console.log(window.location.hash);
        $('.nav-tabs a[href="' + window.location.hash + '"]').tab('show');
      } else {
        //console.log('net');
      }
    $(document).on('click', '.js-header-recall_link', function () {
        $('.recall-pop').removeClass('d-none');
        $('.recall-pop').show();
        return false;
    });
    function getCatalog(showall = false) {
        var cats = [];
        $('.js-filter-line__item-cat.active').each(function (index, element) {
            var id = $(element).data('id');
            cats.push(id);
        });
        var brands = [];
        $('.js-filter-line__item-brand.active').each(function (index, element) {
            var id = $(element).data('id');
            brands.push(id);
        });

        $.get($('.js-filter-form').attr('action'), {brands:brands, cats:cats, showall:showall},
            function (data, textStatus, jqXHR) {
                $.each(data.fields, function (indexInArray, valueOfElement) {
                    $(indexInArray).html(valueOfElement);
                });
                if (data.popup) {
                    $('.overlay-in').hide();
                    $('body').addClass('inactive');
                    $('.overlay '+data.popup).fadeIn();
                }
                if (data.location) {
                    location.href = data.location;
                }
                //console.log(data);
            },
            "json"
        );
        return false;
    }
    $(document).on('click','.js-filter-all', function () {
        getCatalog(true)
        return false;
    });
    $(document).on('click', '.js-filter-line__item-link',function () {
        $(this).parents('.js-filter-line__item').addClass('active');
        getCatalog();
        return false;
    });
    $(document).on('click', '.js-filter-line__item-remove',function () {
        $(this).parents('.js-filter-line__item').removeClass('active');
        getCatalog();
        return false;
    });


    $(document).on('submit','.js-filter-form', function () {
        $.post($(this).attr('action'), $(this).serialize(),
            function (data, textStatus, jqXHR) {
                console.log(data);
                $.each(data.fields, function (indexInArray, valueOfElement) {
                    $(indexInArray).html(valueOfElement);
                });
                if (data.popup) {
                    $('.overlay-in').hide();
                    $('body').addClass('inactive');
                    $('.overlay '+data.popup).fadeIn();
                }
                if (data.location) {
                    location.href = data.location;
                }
                //console.log(data);
            },
            "json"
        );
        return false;
    });
    $(document).on('submit','.js-form__to-cart', function () {
        $.post($(this).attr('action'), $(this).serialize(),
            function (data, textStatus, jqXHR) {

                $.each(data.fields, function (indexInArray, valueOfElement) {
                    $(indexInArray).html(valueOfElement);
                });
                if (data.popup) {
                    $('.modal').modal('hide');
                    $(data.popup).modal('show');
                }
                if (data.location) {
                    location.href = data.location;
                }
                if (!data.quantity) {
                    $('.js-cart-form').html(data.orderform);
                }
            },
            "json"
        );
        return false;
    });
    $(document).on('change', '[name="cart_delivery"]', function () {
        if ($(this).val() == 'pickup') {
            $('[name="address"]').attr("disabled","disabled");
            $('[name="address"]').addClass("disabled");
            $('[name="address"]').parents('.form-group').addClass("d-none");
            $('.js-pick-up-address').show();
        } else {
            $('[name="address"]').removeAttr("disabled");
            $('[name="address"]').removeClass("disabled");
            $('[name="address"]').parents('.form-group').removeClass("d-none");
            $('.js-pick-up-address').hide();
        }
    });
    $(document).on('change','[name="cart_delivery"]', function () {
        let val = $(this).val();
        $('.js-depended-address').find('.js-depended-address-input').addClass('d-none');
        $('.js-depended-address').find('.js-depended-address-input input').removeAttr('required');
        $('[value="'+val+'"]')
            .parents('.js-depended-address')
            .find('.js-depended-address-input')
            .removeClass('d-none')
            .find('input').attr('required','required');
       // $(this).parents('.js-depended-address').find('.js-depended-address-input').toggleClass('d-none');
    });
    $(document).on('click', '.js-minus', function () {
        let val = parseInt($(this).parents('.js-plusminus').find('[name="count"]').val());
        val -= 1;
        if (val < 1) {
            val = 1;
        }
        setQuickLink(val);
        $(this).parents('.js-plusminus').find('[name="count"]').val(val);

        let price = parseFloat($(this).parents('.js-plusminus').find('[name="count"]').data('price'));
        let oldPrice = parseFloat($(this).parents('.js-plusminus').find('[name="count"]').data('old_price'));
        $('.js-product-sum').text((val*price).toLocaleString('ru'));
        $('.js-product-old_sum').text((val*oldPrice).toLocaleString('ru'));
        if ($(this).hasClass('js-up')) {
            $(this).parents('.js-plusminus').submit();
        }
    });
    $(document).on('click', '.js-plus', function () {
        var val = parseInt($(this).parents('.js-plusminus').find('[name="count"]').val());
        val += 1;
        if (val < 1) {
            val = 1;
        }
        setQuickLink(val);
        let price = parseFloat($(this).parents('.js-plusminus').find('[name="count"]').data('price'));
        let oldPrice = parseFloat($(this).parents('.js-plusminus').find('[name="count"]').data('old_price'));
        $('.js-product-sum').text((val*price).toLocaleString('ru'));
        $('.js-product-old_sum').text((val*oldPrice).toLocaleString('ru'));
        $(this).parents('.js-plusminus').find('[name="count"]').val(val);
        if ($(this).hasClass('js-up')) {
            $(this).parents('.js-plusminus').submit();
        }
    });
    function setQuickLink(count = 1) {
        if ($('a').hasClass('js-quick-btn')) {
            let id = $('.js-quick-btn').data('id');
            let params = $.param({id:id, count:count});
            $('.js-quick-btn').attr('href','/quick?'+params);
        }
    }
    $(document).on('click', '.js-form__to-cart .js-cart-remove', function () {
        $(this).parents('.js-form__to-cart').find('[name="count"]').val(0);
        $(this).parents('.js-form__to-cart').submit();
    });
});
function getTimeRemaining(endtime) {
    var t = Date.parse(endtime) - Date.parse(new Date());
    var seconds = Math.floor((t / 1000) % 60);
    var minutes = Math.floor((t / 1000 / 60) % 60);
    var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
    var days = Math.floor(t / (1000 * 60 * 60 * 24));
    return {
        'total': t,
        'days': days,
        'hours': hours,
        'minutes': minutes,
        'seconds': seconds
    };
}

function initializeClock(id, endtime) {

    function updateClock() {
        var t = getTimeRemaining(endtime);
            $('.days').text(t.days);
            $('.hours').text(('0' + t.hours).slice(-2));
            $('.minutes').text(('0' + t.minutes).slice(-2));
            $('.seconds').text(('0' + t.seconds).slice(-2));
        if (t.total <= 0) {
            clearInterval(timeinterval);
            $('.js-disable_timer').attr('disabled','disabled');
        }
    }
    updateClock();
    var timeinterval = setInterval(updateClock, 1000);
}
var deadline = new Date(Date.parse(new Date()) + actions_minutes * 60 * 1000); // for endless timer
initializeClock('clockdiv', deadline);

function replaceImages() {
    /* $('[data-src]').each(function (index, element) {
        $(element).attr('src',$(element).data('src'));
        $(element).removeAttr('data-src');
    }); */
}
$(window).scroll(function(){

    initMap()
});
let mapInited = false;
function initMap() {
    if ($('div').hasClass('map-init') && !mapInited) {
        let winScrollTop = $(window).scrollTop();
        let winHeight = $(window).height();
        let scrollToElem = $('.map-init').offset().top; - winHeight;
        if(winScrollTop + 500 > scrollToElem){
            mapInited = true;
            let script = document.createElement('script');
            script.src = 'https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=83d10336-7739-4029-bcf5-b752f2542769';
            script.async = false;
            document.body.append(script);
            script.onload = function() {
                ymaps.ready(() => {
                    let myMap = new ymaps.Map('ya-map', {
                        center: [mapLat, mapLng],
                        zoom: 16
                    });
                    myMap.geoObjects
                        .add(new ymaps.Placemark([mapLat, mapLng], {
                            hintContent: mapText,
                        }, {
                            iconLayout: 'default#image',
                            iconImageHref: '/images/project/mapIcon.png',
                            iconImageSize: [38, 55],
                            iconImageOffset: [-19, -55]
                    }));
                    myMap.controls.remove('searchControl');
                });
            };
        }
    }
}
$(document).ready(function () {
    initMap();
    replaceImages();
    setTimeout(() => {$('body').removeClass('loading')},500);
});



$('.collapse').on('show.bs.collapse', function () {
    $(this).parents('.card').addClass('-is-open');
});
$('.collapse').on('hide.bs.collapse', function () {
    $(this).parents('.card').removeClass('-is-open');
});
/* ------------------------- UNDER ORDER POPUP ----------------------------------- */

window.callOrderQTYPopup = function(id)
{
    $('#qty-pop').find("[name='product']").attr('value',id);
    $('#qty-pop').modal('show');
};

window.sendOrderQTYPopup = function (e) {
    $('#qty-pop').find("#qty_status").text("Отправка...");
    let data = $('#qty-pop').find('form').serialize();
    let url = $('#qty-pop').find('form').attr('action');
    $.post({
        url: url,
        data: data,
        error: function()
        {
            $('#qty-pop').find("#qty_status").text("ОШИБКА ПРИ ОТПРАВКЕ ФОРМЫ");
        },
        success: function (e) {
            document.location = e.location;
            $('#qty-pop').modal('hide');
            console.log(e);
            //$('#qty-pop-success .js-order-name').text(e.name);
            //$('#qty-pop-success').modal('show');
            //$('#qty-pop-success').on('hidden.bs.modal', function () {
            //    document.location = "/";
            //});
        }
    });
};
