window.arrowLeft = '<button type="button" class="slick-prev icon-center slick-arrow"><svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 2L2 7L7 12" stroke="#F4364C" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg></button>';
window.arrowRight = '<button type="button" class="slick-next icon-center slick-arrow"><svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 12L7 7L2 2" stroke="#F4364C" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg></button>';
window.arrowBigLeft = '<button type="button" class="slick-prev btn btn-light"><svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.266622 5.51493L5.85645 0.251065C6.21203 -0.083953 6.78854 -0.083953 7.14395 0.251065C7.49938 0.585786 7.49938 1.12867 7.14395 1.46336L2.19782 6.12108L7.1438 10.7786C7.49924 11.1135 7.49924 11.6563 7.1438 11.991C6.78836 12.3259 6.21188 12.3259 5.8563 11.991L0.266478 6.7271C0.0887598 6.55965 1.33873e-06 6.34044 1.35304e-06 6.12111C1.36736e-06 5.90167 0.0889329 5.68229 0.266622 5.51493Z" fill="#007bff"/></svg></button>';
window.arrowBigRight = '<button type="button" class="slick-next btn btn-light"><svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.55442 7.66915L1.9646 12.933C1.60902 13.268 1.03251 13.268 0.6771 12.933C0.321663 12.5983 0.321663 12.0554 0.6771 11.7207L5.62323 7.063L0.677244 2.40544C0.321807 2.07059 0.321807 1.52776 0.677244 1.19304C1.03268 0.858181 1.60916 0.858181 1.96474 1.19304L7.55457 6.45699C7.73229 6.62443 7.82104 6.84365 7.82104 7.06297C7.82104 7.28241 7.73211 7.50179 7.55442 7.66915Z" fill="#007bff"/></svg></button>';
$(document).ready(() => {
    /* product images sliders */
    setTimeout(() => {
        let slidersNum = $('.photo-big__item').length;
        $('.photo-big').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: false,
            arrows: false,
            prevArrow: arrowLeft,
            nextArrow: arrowRight,
            dots: false,

        });
        $(document).on('click', '.js-product-slick-prev', function () {
            let current = $('.photo-big').slick('slickCurrentSlide');
            if (current) {
                $('.photo-big').slick('slickPrev');
            } else {
                $('.photo-big').slick('slickGoTo',slidersNum-1);
            }
        });
        $(document).on('click', '.js-product-slick-next', function () {
            let current = $('.photo-big').slick('slickCurrentSlide');
            if (current != +slidersNum-1) {
                $('.photo-big').slick('slickNext');
            } else {
                $('.photo-big').slick('slickGoTo', 0);
            }
        });
        $('.photo-big').on('beforeChange', function(event, slick, currentSlide, nextSlide){
            let num = nextSlide + 1;
            if (num < 10) {
                num = '0' + num.toString();
            }
            $('.js-photo-big-current').html(num);
        });
    },500)
    /* front page sliders */
    $('.types__slider').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        prevArrow: '<button type="button" class="slick-prev btn btn-light"><svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.266622 5.51493L5.85645 0.251065C6.21203 -0.083953 6.78854 -0.083953 7.14395 0.251065C7.49938 0.585786 7.49938 1.12867 7.14395 1.46336L2.19782 6.12108L7.1438 10.7786C7.49924 11.1135 7.49924 11.6563 7.1438 11.991C6.78836 12.3259 6.21188 12.3259 5.8563 11.991L0.266478 6.7271C0.0887598 6.55965 1.33873e-06 6.34044 1.35304e-06 6.12111C1.36736e-06 5.90167 0.0889329 5.68229 0.266622 5.51493Z" fill="#007bff"/></svg></button>',
        nextArrow: '<button type="button" class="slick-next btn btn-light"><svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.55442 7.66915L1.9646 12.933C1.60902 13.268 1.03251 13.268 0.6771 12.933C0.321663 12.5983 0.321663 12.0554 0.6771 11.7207L5.62323 7.063L0.677244 2.40544C0.321807 2.07059 0.321807 1.52776 0.677244 1.19304C1.03268 0.858181 1.60916 0.858181 1.96474 1.19304L7.55457 6.45699C7.73229 6.62443 7.82104 6.84365 7.82104 7.06297C7.82104 7.28241 7.73211 7.50179 7.55442 7.66915Z" fill="#007bff"/></svg></button>',
        responsive: [
            {
                breakpoint: 1270,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            }
        ]
    });
    if ($('.js-news__slider').length) {
        let newsSliderCount = $('.js-news__slider .blog-item').length;
        for (let index = 0; index < newsSliderCount; index++) {
            $('.js-news-next').before(
                '<a data-page="'+index+'" class="nav-number js-news-goto '+
                (!index ? 'active': '')+'" href="#">'+(index+1)+'</a>');
        }

        $('.js-news__slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            prevArrow: arrowLeft,
            nextArrow: arrowRight,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
        showNewsPages();
        $(document).on('click','.js-news-prev', function () {
            $('.js-news__slider').slick('slickPrev');
            return false;
        });
        $(document).on('click','.js-news-next', function () {
            $('.js-news__slider').slick('slickNext');
            return false;
        });
        $(document).on('click','.js-news-goto', function () {
            if (!$(this).hasClass('active')) {
                let index = +$(this).data('page');
                $('.js-news__slider').slick('slickGoTo',index);
            }
            return false;
        });
        $('.js-news__slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
            showNewsPages(nextSlide);
        });
        function showNewsPages(pageNum = 0) {

            $('.js-news-goto').addClass('d-none');
            let last = newsSliderCount - 1;
            if (pageNum == 0) {
                $('.js-news-goto[data-page="0"]').removeClass('d-none');
                $('.js-news-goto[data-page="1"]').removeClass('d-none');
                $('.js-news-goto[data-page="2"]').removeClass('d-none');
            } else if(pageNum == last) {
                $('.js-news-goto[data-page="'+(last - 1)+'"]').removeClass('d-none');
                $('.js-news-goto[data-page="'+last+'"]').removeClass('d-none');
                $('.js-news-goto[data-page="'+(last - 2)+'"]').removeClass('d-none');
            } else {
                $('.js-news-goto[data-page="'+(pageNum - 1)+'"]').removeClass('d-none');
                $('.js-news-goto[data-page="'+(pageNum)+'"]').removeClass('d-none');
                $('.js-news-goto[data-page="'+(pageNum + 1)+'"]').removeClass('d-none');
            }
            $('.js-news-goto').removeClass('active');
            $('.js-news-goto[data-page="'+pageNum+'"]').addClass('active');
        }
    }
    /* product additionals sliders */
    if ($('.js-additionals__slider').length) {
        $('.js-additionals__slider').each(function (index, element) {
            let sliderCount = $(element).find('.js-slider-item').length;
            for (let index = 0; index < sliderCount; index++) {
                $(element).next().find('.js-slider-next').before(
                    '<a data-page="'+index+'" class="nav-number js-slider-goto '+
                    (!index ? 'active': '')+'" href="#">'+(index+1)+'</a>');
            }
            $(element).slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                prevArrow: arrowLeft,
                nextArrow: arrowRight,
                responsive: [
                    {
                        breakpoint: 1270,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 574,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            arrows: false
                        }
                    }
                ]
            });
            showSliderPages(element, sliderCount);
            $(element).on('beforeChange', function(event, slick, currentSlide, nextSlide) {
                showSliderPages(element,sliderCount,nextSlide, element);
            });
        });
        $(document).on('click','.js-slider-prev', function () {
            $(this).parent().prev().slick('slickPrev');
            return false;
        });
        $(document).on('click','.js-slider-next', function () {
            $(this).parent().prev().slick('slickNext');
            return false;
        });
        $(document).on('click','.js-slider-goto', function () {
            if (!$(this).hasClass('active')) {
                let index = +$(this).data('page');
                $(this).parent().prev().slick('slickGoTo',index);
            }
            return false;
        });

        function showSliderPages(slider, last, pageNum = 0) {
            $(slider).next().find('.js-slider-goto').addClass('d-none');
            last--;
            if (pageNum == 0) {

                $(slider).next().find('.js-slider-goto[data-page="0"]').removeClass('d-none');
                $(slider).next().find('.js-slider-goto[data-page="1"]').removeClass('d-none');
                $(slider).next().find('.js-slider-goto[data-page="2"]').removeClass('d-none');
            } else if(pageNum == last) {
                $(slider).next().find('.js-slider-goto[data-page="'+(last - 1)+'"]').removeClass('d-none');
                $(slider).next().find('.js-slider-goto[data-page="'+last+'"]').removeClass('d-none');
                $(slider).next().find('.js-slider-goto[data-page="'+(last - 2)+'"]').removeClass('d-none');
            } else {
                $(slider).next().find('.js-slider-goto[data-page="'+(pageNum - 1)+'"]').removeClass('d-none');
                $(slider).next().find('.js-slider-goto[data-page="'+(pageNum)+'"]').removeClass('d-none');
                $(slider).next().find('.js-slider-goto[data-page="'+(pageNum + 1)+'"]').removeClass('d-none');
            }
            $(slider).next().find('.js-slider-goto').removeClass('active');
            $(slider).next().find('.js-slider-goto[data-page="'+pageNum+'"]').addClass('active');
        }
    }
    if ($('.js-blog__slider').length) {
        let blogSliderCount = $('.js-blog__slider .blog-item').length;
        for (let index = 0; index < blogSliderCount; index++) {
            $('.js-blog-next').before(
                '<a data-page="'+index+'" class="nav-number js-blog-goto '+
                (!index ? 'active': '')+'" href="#">'+(index+1)+'</a>');
        }

        $('.js-blog__slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            prevArrow: arrowLeft,
            nextArrow: arrowRight,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
        showBlogPages();
        $(document).on('click','.js-blog-prev', function () {
            $('.js-blog__slider').slick('slickPrev');
            return false;
        });
        $(document).on('click','.js-blog-next', function () {
            $('.js-blog__slider').slick('slickNext');
            return false;
        });
        $(document).on('click','.js-blog-goto', function () {
            if (!$(this).hasClass('active')) {
                let index = +$(this).data('page');
                $('.js-blog__slider').slick('slickGoTo',index);
            }
            return false;
        });
        $('.js-blog__slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
            console.log(currentSlide, nextSlide);
            showBlogPages(nextSlide);
        });
        function showBlogPages(pageNum = 0) {

            $('.js-blog-goto').addClass('d-none');
            let last = blogSliderCount - 1;
            if (pageNum == 0) {
                $('.js-blog-goto[data-page="0"]').removeClass('d-none');
                $('.js-blog-goto[data-page="1"]').removeClass('d-none');
                $('.js-blog-goto[data-page="2"]').removeClass('d-none');
            } else if(pageNum == last) {
                $('.js-blog-goto[data-page="'+(last - 1)+'"]').removeClass('d-none');
                $('.js-blog-goto[data-page="'+last+'"]').removeClass('d-none');
                $('.js-blog-goto[data-page="'+(last - 2)+'"]').removeClass('d-none');
            } else {
                $('.js-blog-goto[data-page="'+(pageNum - 1)+'"]').removeClass('d-none');
                $('.js-blog-goto[data-page="'+(pageNum)+'"]').removeClass('d-none');
                $('.js-blog-goto[data-page="'+(pageNum + 1)+'"]').removeClass('d-none');
            }
            $('.js-blog-goto').removeClass('active');
            $('.js-blog-goto[data-page="'+pageNum+'"]').addClass('active');
        }
    }
    if ($('.reviews__slider').length) {
        let sliderItemsCount = $('.reviews__item').length;
        let slideCount = sliderItemsCount;
        for (let index = 0; index < slideCount; index++) {
            $('.js-review-next-small').before(
                '<a data-page="'+index+'" class="nav-number js-review-goto '+
                (!index ? 'active': '')+'" href="#">'+(index+1)+'</a>');
        }
        showReviewPages();
        let slidersReviewNum = $('.reviews__item').length;
        $('.reviews__slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: false,
            infinite: false,
            prevArrow: arrowLeft,
            nextArrow: arrowRight,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 574,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false
                    }
                }
            ]
        });
        $(document).on('click','.js-review-prev', function () {
            let current = $('.reviews__slider').slick('slickCurrentSlide');
            console.log([slidersReviewNum,current]);
            if (current > 0) {
                $('.reviews__slider').slick('slickPrev');
            } else {
                let next = slidersReviewNum - 1;
                if (window.innerWidth > 992) {
                    next -= 2;
                } else if (window.innerWidth > 768) {
                    next -= 1;
                }
                $('.reviews__slider').slick('slickGoTo', next);
            }
            return false;
        });
        $(document).on('click','.js-review-next', function () {
            let current = $('.reviews__slider').slick('slickCurrentSlide');
            let next = slidersReviewNum - 1;
            if (window.innerWidth > 992) {
                next -= 2;
            } else if (window.innerWidth > 768) {
                next -= 1;
            }
            if (current != +next) {
                $('.reviews__slider').slick('slickNext');
            } else {
                $('.reviews__slider').slick('slickGoTo', 0);
            }
            return false;
        });
        $(document).on('click','.js-review-goto', function () {
            if (!$(this).hasClass('active')) {
                let index = +$(this).data('page') + 1;
                $('.reviews__slider').slick('slickGoTo',index);
                $('.js-review-goto').removeClass('active');
                $(this).addClass('active');
            }
            return false;
        });
        $('.reviews__slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
            let pageNum = (nextSlide);

            showReviewPages(pageNum);

        });
        function showReviewPages(pageNum = 0) {
            $('.js-review-goto').addClass('d-none');
            let last = slideCount - 1;
            if (pageNum == 0) {
                $('.js-review-goto[data-page="0"]').removeClass('d-none');
                $('.js-review-goto[data-page="1"]').removeClass('d-none');
                $('.js-review-goto[data-page="2"]').removeClass('d-none');
            } else if(pageNum == last) {
                $('.js-review-goto[data-page="'+(last - 1)+'"]').removeClass('d-none');
                $('.js-review-goto[data-page="'+last+'"]').removeClass('d-none');
                $('.js-review-goto[data-page="'+(last - 2)+'"]').removeClass('d-none');
            } else {
                $('.js-review-goto[data-page="'+(pageNum - 1)+'"]').removeClass('d-none');
                $('.js-review-goto[data-page="'+(pageNum)+'"]').removeClass('d-none');
                $('.js-review-goto[data-page="'+(pageNum + 1)+'"]').removeClass('d-none');
            }
            $('.js-review-goto').removeClass('active');
            $('.js-review-goto[data-page="'+pageNum+'"]').addClass('active');
        }
    }
    $('.others-promo__slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        prevArrow: arrowLeft,
        nextArrow: arrowRight,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
});
