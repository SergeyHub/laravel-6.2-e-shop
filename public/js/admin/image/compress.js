//compress single image
async function compressImage(image) {
    let regex = /^.*\.gif$/;
    if (image.match(regex)) {
        swal.fire(
            'Неподдерживаемое изображение!',
            'Изображения в формате GIF не поддерживаются сервисом сжатия',
            'error'
        );
        return null;
    }
    let token = await getToken();
    if (token === undefined || token === null) {
        swal.fire(
            'Ключ не установлен!',
            'Необходимо ввести верный ключ API сервиса сжатия',
            'error'
        );
        return null;
    }
    //alert(image);
    var sw = swal.fire({
        title: 'Идёт сжатие изображения...',
        allowOutsideClick: false,
        type: 'info',
        showConfirmButton: false,
    });
    $.ajax({
        url: "/admin/image/compress",
        data: {image: image, token: token},
        success: function (result) {
            if (result.status) {
                swal.fire({
                    title: 'Сжатие завершено!',
                    text: result.old / 1000.0 + "kb => " + result.new / 1000.0 + "kb, API " + result.api_count + "/500",
                    type: 'success'
                });
            } else {
                swal.fire({
                    title: 'Не удалось сжать изображение',
                    text: result.message,
                    type: 'error'
                })
            }

        },
        error: function () {
            swal.fire("Ошибка при обработке изображения");
        }
    });
}

//compress multiple images
async function compressImages(images) {
    let token = await getToken();
    if (token === undefined || token === null) {
        swal.fire(
            'Ключ не установлен!',
            'Необходимо ввести верный ключ API сервиса сжатия',
            'error'
        );
        return null;
    }
    //alert(image);
    var sw = swal.fire({
        title: 'Идёт сжатие '+images.length+' изображений...',
        type: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
    });
    $.ajax({
        url: "/admin/image/compress",
        data: {images: images, token: token},
        success: function (result) {
            if (result.status) {
                let result_txt = "Обработано "+result.success + " из " + result.count + "  изображений.<br>";
                result_txt += result.old / 1000.0 + "kb => " + result.new / 1000.0 + "kb, API " + result.api_count + "/500.<br>";
                if (result.message.length > 0) {
                    result_txt += "Ошибки: <br>" + result.message;
                }
                if (result.success === result.count)
                {
                    swal.fire({
                        title: 'Сжатие завершено!',
                        html: result_txt,
                        type: 'success'
                    });
                }
                if (result.success !== result.count && result.success > 0)
                {
                    swal.fire({
                        title: 'Сжатие завершено, с ошибками',
                        html: result_txt,
                        type: 'warning'
                    });
                }
                if (result.success !== result.count && result.success == 0)
                {
                    swal.fire({
                        title: 'Возникли ошибки при сжатии изображений!',
                        html: result_txt,
                        type: 'error'
                    });
                }

            } else {
                swal.fire({
                    title: 'Не удалось сжать изображения',
                    text: result.message,
                    type: 'error'
                })
            }

        },
        error: function () {
            swal.fire("Ошибка при обработке изображений");
        }
    });
}

function compressAll()
{
    let images = [];
    let regex = /^.*\.gif$/;

    $("div[data-toggle='images_imgContainer']").each(function () {
        let val = $(this).attr('data-value');
        if (!val.match(regex)) {
            images.push(val);
        }

    }).promise().done(function () {
        compressImages(images);
    });
}
//------------------------------ TOKEN MANAGEMENT ------------------------------------//
async function getToken() {
    let token = localStorage.getItem("ImageAPIKey");
    if (token === null) {
        let token = await setToken();
        return token;
    }
    return token;
}

async function setToken() {
    let {value: text} = await swal({
        title: 'Ввод ключа API',
        text: 'Введите Ваш ключ API сервиса сжатия изображений.\nОставьте поле пустым для сброса текущего ключа.',
        type: 'info',
        input: "text",
        inputValue: localStorage.getItem("ImageAPIKey"),
        showCancelButton: true,
        confirmButtonText: 'Сохранить',
        cancelButtonText: "Отмена"
    });
    if (text !== undefined) {
        if (text.length > 0) {
            localStorage.setItem("ImageAPIKey", text);
            let w = await swal({
                title: 'Ключ сохранён!',
                type: 'success',
            });
            return text;
        } else {
            window.localStorage.removeItem("ImageAPIKey");
            let w = await swal({
                title: 'Ключ сброшен!',
                type: 'warning',
            });
        }

    } else {
        return null;
    }
}
