<div class="form-group form-element-textarea {{ $errors->has($name) ? 'has-error' : '' }}">
    <label for="{{ $name }}" class="control-label">
        {!! $label !!}

        @if($required)
            <span class="form-element-required">*</span>
        @endif
    </label>

    @include(AdminTemplate::getViewPath('form.element.partials.helptext'))

    <textarea id="{{$name}}" {!! $attributes !!} style="display: none"
              @if($readonly) readonly @endif
	>{!! $value !!}</textarea>
    @include(AdminTemplate::getViewPath('form.element.partials.errors'))
</div>
<div id="code_{{$name}}" class="form-control" style="display: block; height: auto;"></div>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        var textarea = document.getElementById('code_{{$name}}');
        var schema = {};
                @if($schema)
                $.ajax({
                    async: false,
                    type: 'GET',
                    url: '{{$schema}}',
                    success: function(data) {
                        schema = data;
                    }
                });
                @endif
        var editor = new JSONEditor(textarea, {
                theme: 'bootstrap3',
                iconlib: "fontawesome4",
                schema: schema,
                form_name_root: "{{$name}}"

            });
        var value = JSON.parse('{!! $value !!}');
        editor.setValue(value);


        editor.on('ready', function () {
            // Now the api methods will be available
            editor.validate();
        });

        editor.on('change', function () {
            $('#{{$name}}').val(JSON.stringify(editor.getValue()));
        });
    });

</script>
