window.resetPromocodeForm = function () {
    $(".js-promocode form").validate({
        messages: {
            code: {
                required: 'Необходимо ввести код!',
            },
        },
        submitHandler: function submitHandler(form) {
            $(".js-promocode").html("<div class=\"loader-spinner\">Проверка...</div>")
            $.post($(form).attr('action'), $(form).serialize(),
                function (data, textStatus, jqXHR) {
                    $.each(data.fields, function (indexInArray, valueOfElement) {
                        $(indexInArray).html(valueOfElement);
                    });
                    resetPromocodeForm();
                    resetPhoneInput($(".js-cart_content"));
                },
                "json"
            );
            return false;
        }
    });
}

window.resetPhoneInput = function (container) {
    $(container).find('[type="tel"]').mask('+0 (000) 000-00-00', {
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
                    $(currentField).val("+7 (" + cep.slice(-1));
                    break;
            }
        }
    });
}

window.resetLazy = function(container)
{
    $(container).find('.lazy').Lazy();
}

document.addEventListener("DOMContentLoaded", function () {
    resetPromocodeForm();
});
