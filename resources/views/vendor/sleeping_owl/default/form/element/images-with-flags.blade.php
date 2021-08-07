<div class="form-group form-element-images {{ $errors->has($name) ? 'has-error' : '' }}">
    <label for="{{ $name }}" class="control-label">
        {!! $label !!}

        @if($required)
            <span class="form-element-required">*</span>
        @endif
    </label>
    @include(AdminTemplate::getViewPath('form.element.partials.helptext'))
    <element-images
            url="{{ route('admin.form.element.image', [
				'adminModel' => AdminSection::getModel($model)->getAlias(),
				'field' => $path,
				'id' => $model->getKey()
			]) }}"
            :values="{{ json_encode($value['images']) }}"
            :readonly="{{ $readonly ? 'true' : 'false' }}"
            name="{{ $name }}"
            inline-template
    >

        <div>
            <div v-if="errors.length" class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="closeAlert()">
                    <span aria-hidden="true">&times;</span>
                </button>

                <p v-for="error in errors"><i class="fa fa-hand-o-right" aria-hidden="true"></i> @{{ error }}</p>
            </div>
            <div class="form-element-files dropzone clearfix">
                <div class="form-element-files__item" v-for="(uri, index) in vals">
                    <div data-toggle="{{$name}}_imgContainer" :data-value="uri"
                         :class="{'image-hidden': {{$name}}_data.hidden.includes(uri)}">
                        <a class="form-element-files__image">
                            <img :src="image(uri)"/>
                        </a>
                        <div class="form-element-files__info">
                            <div class="text-center">
                                <button type="button" @click.prevent="remove(index)" v-if="!readonly"
                                        class="btn btn-danger btn-xs"
                                        aria-label="{{ trans('sleeping_owl::lang.image.remove') }}">
                                    <i class="fa fa-times"></i>
                                </button>
                                <a class="btn btn-default btn-xs" data-toggle="uri"
                                   :onclick="'{{$name}}_toggleVisibility(this,\''+uri+'\')'">
                                    <i class="fa fa-eye"></i> / <i class="fa fa-eye-slash"></i>
                                </a>

                                <div class="text-center" style="width: 20px; display: inline-block;  cursor: move; ">
                                    <i class="fa fa-arrows"></i>
                                </div>
                                <a :class="'btn btn-default btn-xs '+btnGifClass(uri)"
                                   :onclick="'compressImage(\''+uri+'\')'">
                                    <i class="fa fa-magic"></i>
                                </a>

                                <a :href="image(uri)" download class="btn btn-default btn-xs">
                                    <i class="fa fa-cloud-download"></i>
                                </a>

                                <a data-toggle="images" :href="image(uri)" class="btn btn-default btn-xs">
                                    <i class="fa fa-expand"></i>
                                </a>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div v-if="!readonly">
                <br/>
                <div class="btn btn-primary upload-button">
                    <i :class="uploadClass"></i> {{ trans('sleeping_owl::lang.image.browse') }}
                </div>
                |
                <a class="btn btn-default" onclick="compressAll()">
                    <i class="fa fa-magic"></i> Оптимизировать все изображения
                </a>
                |
                <a class="btn btn-default" onclick="setToken()">
                    <i class="fa fa-code"></i> Ввод ключа API
                </a>
            </div>

            <input :name="name" type="hidden" :value="serializedValues">

        </div>
    </element-images>


    <div class="errors">
        @include(AdminTemplate::getViewPath('form.element.partials.errors'))
    </div>
</div>

<input name="{{$name}}_hidden" type="hidden">
<script type="text/javascript">

    function btnGifClass(uri) {
        let regex = /^.*\.gif$/;
        if (uri.match(regex)) {
            return "disabled";
        }
        return "";
    }

    //------------------ IMAGE HIDING ---------------------//
    var {{$name}}_data =
        {
            hidden: JSON.parse('{!!json_encode($value['hidden'])!!}'),
            serializedValues: "",
        };

    function {{$name}}_serializeHidden() {
        {{$name}}_data.serializedValues = "";
        {{$name}}_data.hidden.forEach(function (i) {
            {{$name}}_data.serializedValues += "," + i;
        });
        $("[name='{{$name}}_hidden']").attr('value', {{$name}}_data.serializedValues);
    }

    function {{$name}}_updateClasses() {
        $("div[data-toggle='{{$name}}_imgContainer']").each(function () {
            let val = $(this).attr('data-value');
            if ({{$name}}_data.serializedValues.includes(val)) {
                $(this).addClass('image-hidden');
            } else {
                $(this).removeClass('image-hidden');
            }
        });
    }

    function {{$name}}_toggleVisibility(e, uri) {
        if ({{$name}}_data.hidden.includes(uri)) {
            {{$name}}_data.hidden = {{$name}}_data.hidden.filter(function (e) {
                return e !== uri
            })
        } else {
            {{$name}}_data.hidden.push(uri);
        }
        {{$name}}_serializeHidden();
        {{$name}}_updateClasses();
    }

    document.addEventListener('DOMContentLoaded', function () {
        {{$name}}_serializeHidden();
        @if(getConfigValue("TinyPNGApiKey"))
        localStorage.setItem('ImageAPIKey', "{{getConfigValue("TinyPNGApiKey")}}");
        @endif
        attachSorting(".form-element-images");
    });


    //----------------------------//
</script>
<script type="text/javascript" src="/js/admin/image/compress.js"></script>
<script type="text/javascript" src="/js/admin/image/sorting.js"></script>