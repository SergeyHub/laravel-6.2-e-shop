console.log('-- init --');
$(document).on('change', '.field-order', function () {
    if ($(this).val() != '') {
        $(this).parents('.order-form').submit();
    } else {
        $(this).val(
            $(this).parents('.order-form').find('[name="old"]').val()
        );
    }
});

Vue.directive('selecttwo', {
    inserted(el) {
        $(el).select2();
        $(el).on('select2:select', () => {
            const event = new Event('change', { bubbles: true, cancelable: true });
            el.dispatchEvent(event);
        });

        $(el).on('select2:unselect', () => {
            const event = new Event('change', {bubbles: true, cancelable: true})
            el.dispatchEvent(event)
        })
    },
});
Vue.component('multi-fields', require('./components/MultiFieldsComponent.vue').default);
function switchOnHandler(textareaId, config) {
    // textareaId - идентификатор поля ввода к которому необходимо подключить редактор
    // config - дополнительные настройки
 
    editor = new WYSIWYGEditor(textareaId)
    editor.setConfig(config)
    return editor
 }
 
 function switchOffHandler(editor, textareaId) {
    // editor - объект подключенного редактора
    // textareaId - идентификатор поля ввода к которому необходимо подключить редактор
 
    editor.destroy()
 }
 
 function execHandler(editor, command, textareaId, data) {
    // editor - объект подключенного редактора
    // command - команда, которую необходимо выполнить
    // textareaId - идентификатор поля ввода к которому необходимо подключить редактор
    // data - дополнительные данные
 
     switch (command) {
         case 'insert':
             editor.insertText(data);
             break;
     }
 }
Admin.setEditor = function () {
    Admin.WYSIWYG.register('ckeditor', switchOnHandler, switchOffHandler, execHandler);
    
    $('.js-ckeditor').each(function (index, element) {
        let id = $(this).attr('id');
        let token = Admin.token;
        let url = '/admin/save/image?_token='+token;
        Admin.WYSIWYG.switchOn(id, 'ckeditor',{defaultLanguage:'ru',extraPlugins: 'uploadimage,image2,justify,youtube,uploadfile',filebrowserUploadUrl: url,uploadUrl: url});
         
     });
}
console.log('-- rhis1 --');
$(document).ready(function () {
    if ($('.js-ckeditor').length) {
        Admin.setEditor();
        
    }
    function switchOnHandler(textareaId, config) {
        // textareaId - идентификатор поля ввода к которому необходимо подключить редактор
        // config - дополнительные настройки
     
        editor = new WYSIWYGEditor(textareaId)
        editor.setConfig(config)
        return editor
     }
     
     function switchOffHandler(editor, textareaId) {
        // editor - объект подключенного редактора
        // textareaId - идентификатор поля ввода к которому необходимо подключить редактор
     
        editor.destroy()
     }
     
     function execHandler(editor, command, textareaId, data) {
        // editor - объект подключенного редактора
        // command - команда, которую необходимо выполнить
        // textareaId - идентификатор поля ввода к которому необходимо подключить редактор
        // data - дополнительные данные
     
         switch (command) {
             case 'insert':
                 editor.insertText(data);
                 break;
         }
     }
    function setEditor() {
        Admin.WYSIWYG.register('ckeditor', switchOnHandler, switchOffHandler, execHandler);
        
        $('.js-ckeditor').each(function (index, element) {
           var id = $(this).attr('id');
           Admin.WYSIWYG.switchOn(id, 'ckeditor');
            
        });
    }
    $('body').on('click', '.js-add-multi-element', function () {
        $('.js-ckeditor').each(function (index, element) {
            var id = $(this).attr('id');
            Admin.WYSIWYG.switchOff(id);
             
         });
        var block = $(this).parents('.js-multi-elements').find('.js-multi_item:last').clone();
        
        var num = $(block).data('num');
        var new_num = num+1;
        
        $(block).attr('data-num', new_num);
        $(block).find('.form-control').each(function (index, element) {
            $(element).val('');
            name = $(element).attr('name');
            id = $(element).attr('id');
            $(element).attr('name',name.replace(num,new_num));
            $(element).attr('id',id.replace(num,new_num));
        });
        $(block).find('textarea').each(function (index, element) {
            $(element).val('');
            name = $(element).attr('name');
            id = $(element).attr('id');
            $(element).attr('name',name.replace(num,new_num));
            $(element).attr('id',id.replace(num,new_num));
        });
        
        $(block).find('label').each(function (index, element) {
            fr = $(element).attr('for');
            if (fr) {

                $(element).attr('for',fr.replace(num,new_num));
            }
        });
        $(this).before(block);  
         
        setEditor();    
    });
    $('body').on('click', '.js-remove-multi-element', function () {
        var pid = $(this).parents('.js-multi_item').data('pid');
        $('.js_remove-element--'+pid).remove();
        $(this).parents('.js-multi_item').remove();
    });
});