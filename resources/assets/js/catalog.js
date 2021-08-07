function setMenuWidth() {
    let wrapperWidth = $('.js-filter').width();
    let width = 0;
    let margin = 18;
    let isOpen = $('.js-filter').hasClass('-is-open');
    if (isOpen) {
        $('.js-filter__item').show();
        $('.js-filter-more i').removeClass('fa-plus').addClass('fa-minus');
        return false;
    }
    $('.js-filter-more i').removeClass('fa-minus').addClass('fa-plus');
    $('.js-filter__item').each((index, element) => {
        width += $(element).width() + margin;
        if (width > wrapperWidth) {
            $('.js-filter-more').show();
            $(element).hide();
            /* $(element).prev('.js-filter__item').css('margin-right', width - wrapperWidth + margin); */
        } else {
            $(element).show();

            /* $(element).prev().css('margin-right', margin); */
        }
    });
}

$(document).on('click', '.js-filter-more', function () {
    $(this).parents('.js-filter').toggleClass('-is-open');
    setMenuWidth();
    return false;
});
if ($('.js-filter-mobile').length) {
    let mobileFilterFullWidth = $('.js-filter-mobile .js-mobile-filter__item:last-child')[0].offsetLeft + $('.js-mobile-filter__item:last-child').width();
    let mobileFilterWidth = $('.js-filter-mobile').width();
    if ($('.js-filter-mobile .js-mobile-filter__item').find('.-is-active').length) {
        let mobileActive = $('.js-filter-mobile .js-mobile-filter__item').find('.-is-active')[0].offsetLeft;
        let scrolled = mobileActive - 15;
        $('.js-filter-mobile').data('scroll',scrolled);
        $('.js-filter-mobile').css({'margin-left': -1 * scrolled});
    }
    function slideRight() {
        let scrolled = $('.js-filter-mobile').data('scroll');
        scrolled += mobileFilterWidth / 2;
        if (scrolled >= mobileFilterFullWidth - mobileFilterWidth) {
            scrolled = mobileFilterFullWidth - mobileFilterWidth;
        }
        $('.js-filter-mobile').data('scroll',scrolled);
        $('.js-filter-mobile').css({'margin-left': -1 * scrolled});
    }
    function slideLeft() {
        let scrolled = $('.js-filter-mobile').data('scroll');
        scrolled -= mobileFilterWidth / 2;
        if (scrolled < 0) {
            scrolled = 0;
        }
        $('.js-filter-mobile').data('scroll',scrolled);
        $('.js-filter-mobile').css({'margin-left': -1 * scrolled});
    }
    $(document).on('click', '.js-filter-mobile-next', function () {
        slideRight();
    });
    $(document).on('click', '.js-filter-mobile-prev', function () {
        slideLeft();
    });

    $(".js-filter-mobile").swipe( {
        swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
            if (direction == 'left') {
                slideRight();
            }
            if (direction == 'right') {
                slideLeft();
            }
        }
    });

    $(".js_show-all").click(function(e){
        e.preventDefault();
        let href = $(this).attr("href");
        $.ajax({
            method: "get",
            url:  href+"&json=1",
            success: function (res) {
                $(".js-catalog-list").html(res.content);
                setMenuWidth();
            }
        });
    });
}
$(window).on('resize', function(){
    setMenuWidth();
});
$('.filter-line .nav-link').on('shown.bs.tab', function (e) {
    setMenuWidth();
})
$(document).ready(function () {
    setMenuWidth();
    $(document).on('click', '.js-catalog-more', function () {
        setMenuWidth();
        $(this).parents('.js-catalog__tab').toggleClass('-is-open');

        return false;
    });
    $(document).on('click', '.js-brand-more', function () {
        $(this).parents('.js-brand__tab').toggleClass('-is-open');
        setMenuWidth();
        return false;
    });
});

