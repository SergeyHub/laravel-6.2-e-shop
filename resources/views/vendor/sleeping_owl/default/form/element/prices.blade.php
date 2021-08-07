<div class="form-group form-element-prices {{ $errors->has($name) ? 'has-error' : '' }}">
    <div class="text-center">
        <h4 class="text-center">
            <i class="fa fa-product-hunt"></i>
            {!! $label !!}

            @if($required)
                <span class="form-element-required">*</span>
            @endif
        </h4>
    </div>
    <hr>
    <table class="table table-striped w-auto prices">
        <thead>
        <tr>
            <th>

            </th>
            @foreach($countries as $country)
                <th>
                    Цена {{$country->name}}
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($fields as $qty=>$qty_fieldset)
            <tr>
                <td>
                    {{$qty_fieldset['name']}}
                </td>
                @foreach($qty_fieldset['fields'] as $country_id=>$field)
                    <td>

                        <div class="form-inline">

                            <input type="number" step="{{$step}}" min="0" class="form-control" name="{{$field['name']}}"
                                   value="{{$model->getPrice($qty, $country_id, true)}}">
                            <span class="h4 currency">{{$field['currency']}}</span>
                        </div>
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
    @include(AdminTemplate::getViewPath('form.element.partials.helptext'))
    @include(AdminTemplate::getViewPath('form.element.partials.errors'))
    <hr>
</div>


