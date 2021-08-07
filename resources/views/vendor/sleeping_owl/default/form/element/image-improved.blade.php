<div class="form-group form-element-image{{ $class ? ' ' . $class : '' }} {{ $errors->has($name) ? 'has-error' : '' }}"{!! $style ? ' style="' . $style . '"' : '' !!}>
    <label for="{{ $name }}" class="control-label">
        {!! $label !!}

        @if($required)
            <span class="form-element-required">*</span>
        @endif
    </label>

    @include(AdminTemplate::getViewPath('form.element.partials.helptext'))

    <element-image
            url="{{ route('admin.form.element.image', [
				'adminModel' => AdminSection::getModel($model)->getAlias(),
				'field' => $path,
				'id' => $model->getKey()
			]) }}"
            value="{{ $value }}"
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
            <div class="form-element-files clearfix" v-if="has_value">
                <div class="form-element-files__item">
                    <a :href="image" class="form-element-files__image" data-toggle="lightbox">
                        <img :src="image"/>
                    </a>
                    <div class="form-element-files__info">
                        <a :href="image" class="btn btn-default btn-xs pull-right">
                            <i class="fa fa-cloud-download"></i>
                        </a>
                        <a :class="'btn btn-default btn-xs '+btnGifClass(image)"
                           :onclick="'compressImage(\''+extractUri(image)+'\')'">
                            <i class="fa fa-magic"></i>
                        </a>
                        <button type="button" v-if="has_value && !readonly" class="btn btn-danger btn-xs"
                                @click.prevent="remove()">
                            <i class="fa fa-times"></i> {{ trans('sleeping_owl::lang.image.remove') }}
                        </button>
                    </div>
                </div>
            </div>

            <div v-if="!readonly">
                <div class="btn btn-primary upload-button">
                    <i :class="uploadClass"></i> {{ trans('sleeping_owl::lang.image.browse') }}
                </div>
                |
                <a class="btn btn-default" onclick="setToken()">
                    <i class="fa fa-code"></i> Ввод ключа API
                </a>
            </div>

            <input :name="name" type="hidden" :value="val">
        </div>
    </element-image>


    <div class="errors">
        @include(AdminTemplate::getViewPath('form.element.partials.errors'))
    </div>
</div>

<script type="text/javascript" src="/js/admin/image/compress.js"></script>
<script type="text/javascript">
    function btnGifClass(uri) {
        let regex = /^.*\.gif$/;
        if (uri.match(regex)) {
            return "disabled";
        }
        return "";
    }

    function extractUri(url) {
        //create a new element link with your link
        var a = document.createElement("a");
        a.href = url;

        //hide it from view when it is added
        a.style.display = "none";

        //add it
        document.body.appendChild(a);

        //read the links "features"
        let uri = a.pathname;

        //remove it
        document.body.removeChild(a);
        return uri
    }

    document.addEventListener('DOMContentLoaded', function () {
        @if(getConfigValue("TinyPNGApiKey"))
        localStorage.setItem('ImageAPIKey', "{{getConfigValue("TinyPNGApiKey")}}");
        @endif
    });

</script>