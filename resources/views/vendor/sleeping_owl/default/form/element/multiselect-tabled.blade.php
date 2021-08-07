@php
    $node_id = str_random(8);
@endphp
<div id="{{$node_id}}" class="form-group form-element-multiselect-tabled {{ $errors->has($name) ? 'has-error' : '' }}">
    <div class="text-center">
        <label for="{{ $id }}" class="control-label">
            {!! $label !!}

            @if($required)
                <span class="form-element-required">*</span>
            @endif
        </label>
    </div>
    @if($display_search)
        <div class="text-right">

            <div class="form-inline">

                <a class="btn btn-info btn-outline-secondary" data-role="toggle">
                    <i class="fa fa-eye-slash "></i>
                    Показать только выбранные
                </a>

                <input type="text" class="form-control" data-role="search" placeholder="Поиск...">

                <a class="btn btn-danger" data-role="clear">
                    <i class="fa fa-remove"></i>
                </a>

            </div>
        </div>
    @endif
    <table class="table table-striped w-auto multiselect-tabled">
        <thead>
        <tr>
            {{--  <th class="field_id">
                  ID
              </th>--}}
            @foreach($fields as $field)
                <th class="field_value">
                    @php
                        $field_name = $field->field_name;
                        $count = $model->$field_name->count();
                    @endphp
                    {{$field->display_name}}
                   (  <span data-toggle="calc" data-target="{{$field->field_name}}[]">{{$count}}</span> / {{$options->count()}} )
                </th>
            @endforeach
            <th class="field_option text-center">
                {{$name}}
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($options as $option)
            <tr>
                {{-- <td class="field_id">
                     {{$option->id}}
                 </td>--}}
                @foreach($fields as $field)
                    @php
                        $field_name = $field->field_name;
                        $contains = $model->$field_name->contains($option->id);
                    @endphp
                    <td class="field_value">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-select btn-xs {{$contains ? "active" : ""}}">
                                <input type="checkbox" name="{{$field_name}}[]" value="{{$option->id}}"
                                       {{$contains ? "checked" : ""}}  autocomplete="off"> Связать
                            </label>
                        </div>
                    </td>
                @endforeach
                <td class="field_option">

                    {{$option->$option_fieldname}}
                    @if($option instanceof \App\Interfaces\IDisplayable)
                        <a class="btn btn-info btn-xs" href="{{$option->getShowLink()}}" target="_blank">
                            <i class="fa fa-mail-forward"></i>
                        </a>
                    @endif
                    @if($option instanceof \App\Interfaces\IEditable)
                        <a class="btn btn-warning btn-xs" href="{{$option->getEditLink()}}" target="_blank">
                            <i class="fa fa-edit"></i>
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@include(AdminTemplate::getViewPath('form.element.partials.helptext'))
@include(AdminTemplate::getViewPath('form.element.partials.errors'))

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        new Multiselect($("#{{$node_id}}"));
    });

</script>
