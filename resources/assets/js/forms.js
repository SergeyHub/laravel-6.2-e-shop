import {load as recaptcha} from 'recaptcha-v3'

//check captcha if field r_key if defined
//use as wrapper for sumbitHanler's
window.captcha = function (form, callback) {
    if ($(form).find("[name='r_key']").length) {
        let key = $(form).find("[name='r_key']").val()
        recaptcha(key).then((handler) => {
            handler
                .execute()
                .then((token) => {
                    $(form)
                        .find("[name='r_token']")
                        .attr('value', token);
                    callback(form);
                });
        });
    } else {
        callback(form);
    }
}

$.validator.addMethod(
    "phone_ru",
    function(value, element) {
        var re = new RegExp(/\+7\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}/);
        return this.optional(element) || re.test(value);
    },
    "Неверный формат номера"
);


$(document).ready(function () {
    $(".js-form--first-screen").each(function (index, element) {
        $(this).validate({
            rules: {
                phone: {
                    required: true,
                    phone_ru: true
                },
                name: {
                    required: true,
                },
            },
            messages: {
                phone: {
                    required: 'Введите телефон',
                    phone_ru: 'Неверный формат номера телефона',
                },
                name: {
                    required: 'Введите имя',
                },
            },
            submitHandler: function submitHandler(form) {
                $.post($(form).attr('action'), $(form).serialize(),
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
                        $('form').trigger("reset");
                        //console.log(data);
                    },
                    "json"
                );
                return false;
            }
        });
    });
    $(".js-form--more-info").validate({
        rules: {
            phone: {
                required: true,
                phone_ru: true
            },
            name: {
                required: true,
            },
        },
        messages: {
            phone: {
                required: 'Введите телефон',
                phone_ru: 'Неверный формат номера телефона',
            },
            name: {
                required: 'Введите имя',
            },
        },
        submitHandler: function submitHandler(form) {
            $.post($(form).attr('action'), $(form).serialize(),
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
                    $('form').trigger("reset");
                    //console.log(data);
                },
                "json"
            );
            return false;
        }
    });
    $(".js-form--more-info3").validate({
        rules: {
            phone: {
                required: true,
                phone_ru: true
            },
            name: {
                required: true,
            },
        },
        messages: {
            phone: {
                required: 'Введите телефон',
                phone_ru: 'Неверный формат номера телефона',
            },
            name: {
                required: 'Введите имя',
            },
        },
        submitHandler: function submitHandler(form) {
            $.post($(form).attr('action'), $(form).serialize(),
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
                    $('form').trigger("reset");
                    //console.log(data);
                },
                "json"
            );
            return false;
        }
    });
    $(".js-form--modal").validate({
        rules: {
            phone: {
                required: true,
                phone_ru: true
            },
            name: {
                required: true,
            },
        },
        messages: {
            phone: {
                required: 'Введите телефон',
                phone_ru: 'Неверный формат номера телефона',
            },
            name: {
                required: 'Введите имя',
            },
        },
        submitHandler: function submitHandler(form) {
            $.post($(form).attr('action'), $(form).serialize(),
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
                    $('form').trigger("reset");
                    //console.log(data);
                },
                "json"
            );
            return false;
        }
    });
    $(".js-form--more-info4").validate({
        rules: {
            phone: {
                required: true,
                phone_ru: true
            },
            name: {
                required: true,
            },
            email: {
                required: true,
            },
            message: {
                required: true,
            },
        },
        messages: {
            phone: {
                required: 'Введите телефон',
                phone_ru: 'Неверный формат номера телефона',
            },
            name: {
                required: 'Введите имя',
            },
            message: {
                required: 'Введите сообщение',
            },
            email: {
                required: 'Введите email',
            },
        },
        submitHandler: function submitHandler(form) {
            $.post($(form).attr('action'), $(form).serialize(),
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
                    $('form').trigger("reset");
                    //console.log(data);
                },
                "json"
            );
            return false;
        }
    });
    $(".js-form--contacts").validate({
        rules: {
            phone: {
                required: true,
                phone_ru: true
            },
            name: {
                required: true,
            },
            email: {
                required: true,
            },
            message: {
                required: true,
            },
        },
        messages: {
            phone: {
                required: 'Введите телефон',
                phone_ru: 'Неверный формат номера телефона',
            },
            name: {
                required: 'Введите имя',
            },
            message: {
                required: 'Введите сообщение',
            },
            email: {
                required: 'Введите email',
                email: 'Введите корректный e-mail адрес.'
            },
        },
        submitHandler: function submitHandler(form) {
            captcha(form, (form) => {
                $.post($(form).attr('action'), $(form).serialize(),
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
                        $('form').trigger("reset");
                        //console.log(data);
                    },
                    "json"
                );
            });

            return false;
        }
       /*  submitHandler: function submitHandler(form) {
            let file_data = $(form).prop('files')[0];
            let form_data = new FormData($(form));
            form_data.append('file', file_data);
            alert(form_data);
            $.ajax({
                url: $(form).attr('action'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(data){
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
                    $('form').trigger("reset");
                }
            });

            return false;
        } */
    });
    $(".js-form--more-info5").validate({
        rules: {
            phone: {
                required: true,
                phone_ru: true
            },
            name: {
                required: true,
            },
        },
        messages: {
            phone: {
                required: 'Введите телефон',
                phone_ru: 'Неверный формат номера телефона',
            },
            name: {
                required: 'Введите имя',
            },
        },
        submitHandler: function submitHandler(form) {
            $.post($(form).attr('action'), $(form).serialize(),
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
                    $('form').trigger("reset");
                    //console.log(data);
                },
                "json"
            );
            return false;
        }
    });
    $(".js-review__form").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            name: {
                required: true,
            },
            title: {
                required: true,
            },
            message: {
                required: true,
            },
        },
        messages: {
            email: {
                required: 'Введите e-mail',
                email: 'Введите корректный e-mail адрес',
            },
            name: {
                required: 'Введите имя',
            },
            title: {
                required: 'Введите заголовок',
            },
            message: {
                required: 'Введите текст отзыва',
            },
        },
        submitHandler: function submitHandler(form) {
            console.log($(form).serialize());
            captcha(form, (form) => {
                $.post($(form).attr('action'), $(form).serialize(),
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
                        $('form').trigger("reset");
                        //console.log(data);
                    },
                    "json"
                );
            });

            return false;
        }
    });
    $(".js-review__form1").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            name: {
                required: true,
            },
            message: {
                required: true,
            },
        },
        messages: {
            email: {
                required: 'Введите e-mail',
                email: 'Введите корректный e-mail адрес',
            },
            name: {
                required: 'Введите имя',
            },
            message: {
                required: 'Введите текст вопроса',
            },
        },
        submitHandler: function submitHandler(form) {
            captcha(form, (form) => {
                $.post($(form).attr('action'), $(form).serialize(),
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
                        $('form').trigger("reset");
                        //console.log(data);
                    },
                    "json"
                );
            });

            return false;
        }
    });
    $(".js-review__quick").validate({
        rules: {

            name: {
                required: true,
            },
            phone: {
                required: true,
                phone_ru: true
            },
        },
        messages: {
            name: {
                required: 'Введите имя',
            },
            phone: {
                required: 'Введите номер телефона',
                phone_ru: 'Неверный формат номера телефона',
            },
        },

    });
    $(".js-order__quick").validate({
        rules: {
            phone: {
                required: true,
                phone_ru: true,
            },
        },
        messages: {
            phone: {
                required: 'Введите номер телефона',
            },
        },

    });
    $(".js-form--wholesale").validate({
        rules: {
            phone: {
                required: true,
                phone_ru: true
            },
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
        },
        messages: {
            phone: {
                required: 'Введите телефон',
                phone_ru: 'Неверный формат номера телефона',
            },
            name: {
                required: 'Введите имя',
            },
            email: {
                required: 'Введите E-mail',
                email: 'Введите корректный E-mail адрес',
            },
        },
        submitHandler: function submitHandler(form) {
            //console.log($(form).serialize());
            $.post($(form).attr('action'), $(form).serialize(),
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
                    $('.recall-pop').fadeOut();
                    $('form').trigger("reset");
                    //console.log(data);
                },
                "json"
            );
            return false;
        }
    });
    $(".js-recall-pop-header").validate({
        rules: {
            phone: {
                required: true,
                phone_ru: true
            },
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
        },
        messages: {
            phone: {
                required: 'Введите телефон',
                phone_ru: 'Неверный формат номера телефона',
            },
            name: {
                required: 'Введите имя',
            },
            email: {
                required: 'Введите E-mail',
                email: 'Введите корректный E-mail адрес',
            },
        },
        submitHandler: function submitHandler(form) {
            //console.log($(form).serialize());
            $.post($(form).attr('action'), $(form).serialize(),
                function (data, textStatus, jqXHR) {
                    $.each(data.fields, function (indexInArray, valueOfElement) {
                        $(indexInArray).html(valueOfElement);
                    });
                    if (data.popup) {
                        $('.recall-pop').hide();
                        $(data.popup).modal('show');
                    }
                    if (data.location) {
                        location.href = data.location;
                    }
                    $('.recall-pop').fadeOut();
                    $('form').trigger("reset");
                    //console.log(data);
                },
                "json"
            );
            return false;
        }
    });
    $(".js-recall-pop-footer").validate({
        rules: {
            phone: {
                required: true,
                phone_ru: true
            },
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
        },
        messages: {
            phone: {
                required: 'Введите телефон',
                phone_ru: 'Неверный формат номера телефона',
            },
            name: {
                required: 'Введите имя',
            },
            email: {
                required: 'Введите E-mail',
                email: 'Введите корректный E-mail адрес',
            },
        },
        submitHandler: function submitHandler(form) {
            //console.log($(form).serialize());
            $.post($(form).attr('action'), $(form).serialize(),
                function (data, textStatus, jqXHR) {
                    $.each(data.fields, function (indexInArray, valueOfElement) {
                        $(indexInArray).html(valueOfElement);
                    });
                    if (data.popup) {
                        $('.recall-pop').hide();
                        $(data.popup).modal('show');
                    }
                    if (data.location) {
                        location.href = data.location;
                    }
                    $('.recall-pop').fadeOut();
                    $('form').trigger("reset");
                    //console.log(data);
                },
                "json"
            );
            return false;
        }
    });
    $(".js-form__cart-submit").validate({
        rules: {
            phone: {
                required: true,
                phone_ru: true
            },
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
        },
        messages: {
            phone: {
                required: 'Введите телефон',
                phone_ru: 'Неверный формат номера телефона',
            },
            name: {
                required: 'Введите имя',
            },
            email: {
                required: 'Введите E-mail',
                email: 'Введите корректный E-mail адрес',
            },
        },
        submitHandler: function submitHandler(form) {
            return true;
        }
    });
    $(".js-form__cart-submit1").validate({
        rules: {
            phone: {
                required: true,
                phone_ru: true
            },
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
        },
        messages: {
            phone: {
                required: 'Введите телефон',
                phone_ru: 'Неверный формат номера телефона',
            },
            name: {
                required: 'Введите имя',
            },
            email: {
                required: 'Введите E-mail',
                email: 'Введите корректный E-mail адрес',
            },
        },
        submitHandler: function submitHandler(form) {
            return true;
        }
    });
    $(document).on('submit','.js-form__quick-cart', function () {
        $.post($(this).attr('action'), $(this).serialize(),
            function (data, textStatus, jqXHR) {
                $.each(data.fields, function (indexInArray, valueOfElement) {
                    $(indexInArray).html(valueOfElement);
                });
            },
            "json"
        );
        return false;
    });
});
