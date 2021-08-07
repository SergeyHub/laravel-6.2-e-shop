//Класс управления виджетом сообщений
function AdminMessages() {
    this.loader = '<div class="loader">Loading...</div>';
    this.modal = $("#messagesModal");
    this.modalContent = $("#messagesModal .modal-body");
    this.form_loaded = false;
    this.lastUrl = null;
}

AdminMessages.prototype = {
    //Перезагрузка страницы (если это страница с сообщениями)
    reloadPage: function () {
        if (window.messagesPage ) {
            location.reload();
        }
    },

    //Перезагрузка контента модального окна
    reloadModal: function () {
        if(this.lastUrl !== null)
        {
            this.modalContent.html(this.loader).load(this.lastUrl, (responseText, textStatus, req) => {
                if (textStatus === "error")
                    adminMessages.modal.modal("hide");
            });
        }

    },

    //Перезагрузка виджета
    reloadWidget: function () {
        let url = window.location.pathname;
        $("#messagesWidget").load(`/admin/messages/widget?url=${url}`);
    },

    //Показать сообщение по ID
    showMessage: function (message_id) {
        this.modal.modal("show");
        this.lastUrl = `/admin/messages/${message_id}/modal`;
        this.modalContent.html(this.loader).load(this.lastUrl);
        this.form_loaded = false;
    },

    //показать сообщения для раздела/объекта
    showMessagesFor: function (model, id = 0) {
        this.modal.modal("show");
        this.lastUrl = `/admin/messages/${model}/${id}/modal`;
        this.modalContent.html(this.loader).load(this.lastUrl);

        this.form_loaded = false;
    },

    //создать сообщение для раздела/объекта
    createMessageFor: function (model, id = 0) {
        this.modal.modal("show");
        if (this.form_loaded !== "create") {
            this.modalContent.html(this.loader).load(`/admin/messages/store?model=${model}&id=${id}`);
            this.form_loaded = "create";
        }
    },

    //изменить сообщение по ID
    editMessage: function (message_id) {
        this.modal.modal("show");
        if (this.form_loaded !== "edit") {
            this.modalContent.html(this.loader).load(`/admin/messages/${message_id}/edit`);
            this.form_loaded = "edit";
        }
    },

    //сохранить сообщение
    submitMessageForm: function (form) {
        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: $(form).serialize(),
            success: function (response) {
                swal({type: "success", title: response.message}).then(() => {
                    adminMessages.reloadWidget();
                    adminMessages.form_loaded = false;
                    adminMessages.modal.modal("hide");
                    adminMessages.reloadPage();
                });

            }
        });
        return false;
    },

    //подтвердить решение проблемы
    submitMessageConfirm: function (form) {
        swal({
            type: "question",
            title: "Вы уверены что хотите подтвердить?",
            showCancelButton: true
        }).then((value) => {
            if (value.value) {
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: $(form).serialize(),
                    success: function (response) {
                        swal({type: "success", title: response.message}).then(() => {
                            adminMessages.reloadModal();
                            adminMessages.reloadWidget();
                            adminMessages.reloadPage();
                        });
                    }
                });
            }
        });
        return false;
    },

    //подтвердить удаление
    submitMessageRemove: function (form) {
        swal({
            type: "question",
            title: "Вы уверены что хотите удалить объект?",
            showCancelButton: true
        }).then((value) => {
            if (value.value) {
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: $(form).serialize(),
                    success: function (response) {
                        swal({type: "success", title: response.message}).then(() => {
                            adminMessages.reloadModal();
                            adminMessages.reloadWidget();
                            adminMessages.reloadPage();
                        });

                    }
                });
            }
        });
        return false;
    }
}

document.addEventListener("DOMContentLoaded", function () {


    $("#messagesModal").appendTo($("body"));

    window.adminMessages = new AdminMessages();

});
