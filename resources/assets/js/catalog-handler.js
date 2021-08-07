import Vue from 'vue';

Vue.component('filters-base', require('./components/catalog/filters-base').default);
Vue.component('filter-price', require('./components/catalog/filter-price').default);
Vue.component('filter-group', require('./components/catalog/filter-group').default);
Vue.component('filter-instance', require('./components/catalog/filter-instance').default);
Vue.component('filter-buttons', require('./components/catalog/filter-buttons').default);
Vue.component('catalog-pagination', require('./components/catalog/pagination').default);
Vue.component('catalog-controls', require('./components/catalog/controls').default);

document.addEventListener("DOMContentLoaded", function () {
    //================== SETUP MAIN HANDLER =======================
    let handler = new Vue({
        el: "#catalog",

        data: {
            //----- Working dataset --------
            "price_from": 0,
            "price_to": 0,
            "price_min": 0,
            "price_max": 0,
            //
            "availability": null,
            "availability_count": null,
            "promote": null,
            "promote_count": null,
            "latest": null,
            "latest_count": null,
            "discount": null,
            "discount_count": null,
            //
            "groups": null,
            //
            "paginate": null,
            "pagination_count": null,
            "pagination_current": null,
            //
            "order": "popular",
            "view": "grid",
            "filters_active": false,
            //
            "mount": "/catalog/",
            "currency": "₽",
            xhr: null,
            ready: false,
        },
        methods: {
            //apply controls/filters
            apply(force) {
                if($(window).width() > 992 || force)
                {
                    if (this.ready) {
                        this.load(this.compile());
                    }
                }

            },
            //clear filters (for reset button)
            clear() {
                if (this.ready) {
                    this.filters_active = false;
                    this.load(this.mount);
                }
            },
            //load content from compiled href
            load: function (href) {
                let handler = this;
                if (handler.xhr) {
                    handler.xhr.abort();
                }
                handler.xhr = $.ajax({
                    method: "GET",
                    url: href,
                    success: function (data) {
                        handler.xhr = null;
                        handler.reset(data.controls);
                        $(".js-catalog-list").html(data.teasers);
                        $(".js-catalog-heading").html(data.heading);
                        $(".js-catalog-count").html(data.count);
                        $(".js-breadcrumbs").html(data.breadcrumbs);
                        window.document.title = data.title;
                        window.history.pushState({}, data.title, data.url);
                    }
                });
            },
            //reset controls from remote data
            reset(controls) {
                $.each(controls, (i, v) => {
                    this[i] = v;
                });

                if (!this.ready) {
                    //enable flow buttons
                    getBtnWrapperSize();
                    fixBtns();
                    window.onscroll = function() { fixBtns(); };
                    //
                    this.ready = true;
                }
            },
            //compile filters and controls to request
            compile() {
                let builder = new URLSearchParams("");
                //
                if (this.availability) {
                    builder.append("availability", 1);
                }
                if (this.latest) {
                    builder.append("latest", 1);
                }
                if (this.promote) {
                    builder.append("promote", 1);
                }
                if (this.discount) {
                    builder.append("discount", 1);
                }
                if (this.price_to < this.price_max) {
                    builder.append("price_to", this.price_to);
                }
                if (this.price_from > this.price_min) {
                    builder.append("price_from", this.price_from);
                }
                if (this.view === "list") {
                    builder.append("view", "list");
                }
                if (this.order !== "popular") {
                    builder.append("order", this.order);
                }
                $.each(this.groups, function (i, v) {
                    $.each(v.filters, function (i, v) {
                        if (v.checked) {
                            builder.append('filters[]', v.alias);
                        }
                    });
                });
                //
                return this.mount + "?" + builder.toString();
            }
        },
        created: function () {
            let handler = this;
            //console.log(handler);
            $.ajax({
                method: "GET",
                url: document.location.href,
                success: function (data) {
                    handler.reset(data.controls);
                }
            });
        },
        watch: {
            view:function (value) {
                this.apply();
            }
        }
    });

    //====================== SETUP MISC =========================

    //fix price field currency rewrite
    $(document).on("focus", ".filters__price__input", fixPriceInputCursor);
    $(document).on("mouseup", ".filters__price__input", fixPriceInputCursor);
    $(document).on("keyup", ".filters__price__input", fixPriceInputCursor);

    //setup order-control events
    $(document).on('click', '.js-filters-select', function () {
        $(this).toggleClass('-is-open');
        $(this).next('.js-filters-select-list').toggleClass('d-none');
        return false;
    });

    $(document).on('click', '.js-filters-select-option', function () {
        handler.order = $(this).data("value");
        handler.apply();
        $('.js-filters-select').removeClass('-is-open');
        $('.js-filters-select-list').addClass('d-none');
    });

    $(document).on('click',function(){
        $('.js-filters-select').removeClass('-is-open');
        $('.js-filters-select-list').addClass('d-none');
    });

    //remove default events from elements
    $(document).on('click', ".js-catalog-pagination-page", function (e) {
        e.preventDefault();
    });

    $(document).on('click', ".filter-apply", function (e) {
        e.preventDefault();
        $('.js-filters__mobile').toggleClass('d-none');
        $('body').toggleClass('overflow-hidden');
    });

    //setup mobile buttons
    $(document).on('click', '.js-filters__mobile__btn', function () {
        console.log("HURR DURR");
        $('.js-filters__mobile').toggleClass('d-none');
        $('body').toggleClass('overflow-hidden');
        getBtnWrapperSize();
        return false;
    });

});

//======================= HELPERS =====================



//----------- set order values -------------
function setOrderValue(val, title) {
    $('.js-filters-select .text').text(title);
    $('.js-filters-select').removeClass('-is-open');
    $('.js-filters-select-list').addClass('d-none');
}

//--------------- cursor moving helpers ----------------
function fixPriceInputCursor() {
    let len = $(this).val().length;
    let pos = getCaretPos($(this)[0]);
    console.log(len + " " + pos);
    if (pos === len) {
        setCaretToPos($(this)[0], len - 1);
    }
}

function setSelectionRange(input, selectionStart, selectionEnd) {
    if (input.setSelectionRange) {
        input.focus();
        input.setSelectionRange(selectionStart, selectionEnd);
    } else if (input.createTextRange) {
        var range = input.createTextRange();
        range.collapse(true);
        range.moveEnd('character', selectionEnd);
        range.moveStart('character', selectionStart);
        range.select();
    }
}

function setCaretToPos(input, pos) {
    setSelectionRange(input, pos, pos);
}

function getCaretPos(input) {
    // Internet Explorer Caret Position (TextArea)
    if (document.selection && document.selection.createRange) {
        var range = document.selection.createRange();
        var bookmark = range.getBookmark();
        var caret_pos = bookmark.charCodeAt(2) - 2;
    } else {
        // Firefox Caret Position (TextArea)
        if (input.setSelectionRange)
            var caret_pos = input.selectionStart;
    }

    return caret_pos;
}

//-------------- forms and buttons -------------


let btnWrapperSizes = {
    height: null,
    windowHeight: null,
    windowWidth: null,
};

let btnFix = true;

function getBtnWrapperSize() {
    let widths = [];
    let heights = [];
    let elements = document.querySelectorAll('.js-filters__bar');
    elements.forEach((element) => {
        widths.push(element.clientWidth);
        heights.push(element.clientHeight);
    });
    btnWrapperSizes.height = Math.max(...heights);
    let btns = document.querySelectorAll('.js-clear-btn');
    btns.forEach((btn) => {
        btn.style.cssText = 'width: ' + (Math.max(...widths) - 45) +'px !important';
    });
    btnWrapperSizes.windowHeight = document.documentElement.clientHeight;
    btnWrapperSizes.windowWidth = document.documentElement.clientWidth;
}
function fixBtns() {
    let btns = document.querySelectorAll('.js-clear-btn');
    btns.forEach((btn) => {
        let bounding = btn.parentElement.parentElement.getBoundingClientRect();

        if (bounding.height + bounding.y - btnWrapperSizes.windowHeight <= 0) {
            btn.style.position = 'static';
        } else {
            if (btnFix || btnWrapperSizes.windowWidth >= 992) {
                btn.style.position = 'fixed';
            } else {
                btn.style.position = 'static';
            }
        }
    });
}
