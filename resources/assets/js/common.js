$(document).ready(function () {
    //слайдер шапки
    $(".main-slider").owlCarousel({
        navContainer: '.main-slider-nav',
        dotsContainer: '.main-slider-dots',
        animateIn: 'bounceIn',
        loop: true,
        items: 1,
        smartSpeed: 450,
        navText: ['<img src="images/bg/left-arr.png" alt=""/>', '<img src="images/bg/right-arrow.png" alt=""/>'],
    });

    //слайдер обзоров
    $(".review-slider").owlCarousel({
        margin: 20,
        responsiveClass: true,
        navContainer: '.review-nav',
        dotsContainer: '.review-dots',
        navText: ['<img src="images/bg/left-arr.png" alt=""/>', '<img src="images/bg/right-arrow.png" alt=""/>'],
        responsive: {
            0: {
                items: 1,
                nav: true,
                dots: true
            },
            820: {
                items: 2,
                nav: true,
                dots: true
            },
            1240: {
                items: 3,
                loop: false,
                nav: true,
                dots: true
            }
        }
    });

    //faq аккардеон
    $('.faq-list .faq-name').click(function() {
        var current = $(this);
        if (!current.hasClass('active')){
            $('.faq-list .faq-text').not(current.next()).slideUp();
            $('.faq-list li').not(current.parent()).removeClass('active');
            current.next().slideDown().parent().addClass('active');
        } else {
            $('.faq-list li').removeClass('active');
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


    //закрыть перезвон
    $('.recall-pop .close').click(function(){
        $(this).parent().fadeOut();
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
    $('header .cart-block a').click(function(){
        $('body').addClass('inactive');
        $('.overlay .cart-pop').fadeIn();
        return false;
    });

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
        return false;
    })

});

$(document).mouseup(function (e) {
    var container = $(".recall-pop, .dropdown");
    if (container.has(e.target).length === 0) {
        container.fadeOut();
    }
});

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

    if (items.eq(3).hasClass('active') || items.eq(8).hasClass('active')) {
        $('.left-fixed').addClass('white');
    } else {
        $('.left-fixed').removeClass('white')
    }
    if (items.eq(8).hasClass('active')) {
        $('.social-right').addClass('invert')
    } else {
        $('.social-right').removeClass('invert')
    }


}

$(document).on('click', 'a[href^=\\#]:not([href=\\#])', function (event) {
    var anchor = $(this).attr('href');
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
    showActiveMenuItem(this, '.left-fixed a');
});