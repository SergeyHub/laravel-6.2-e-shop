<div class="form-group form-element-multiselect {{ $errors->has($name) ? 'has-error' : '' }}">
        <label for="{{ $id }}" class="control-label">
            {!! $label !!}
    
            @if($required)
                <span class="form-element-required">*</span>
            @endif
        </label>
    
        <deselect :value="{{ json_encode($value) }}"
                  :id="'{{ $id }}'"
                  :multiple="true" :options="{{ json_encode($options) }}" inline-template>
            <div>
                <select v-show="true" id="{{ $id }}" multiple @if($required)required="required" style="height:0;opacity:0;width:1px"@endif name="{{ $name }}" {!! $attributes !!}>
                        <option :selected="hasOption(opt.id)" :value="opt.id"
                                v-for="opt in options">
                            @{{ opt.text }}
                        </option>
                </select>
                <multiselect @if($readonly)
                             :disabled="true"
                             @endif
                             v-model="val"
                             track-by="id"
                             label="text"
                             :multiple="multiple"
                             @if($limit)
                             :limit="{!! $limit !!}"
                             @endif
                             :searchable="true"
                             :options="options"
                             @if(count($options))
                             placeholder="{{ trans('sleeping_owl::lang.select.placeholder') }}"
                             @else
                             placeholder="{{ trans('sleeping_owl::lang.select.no_items') }}"
                             @endif
                             @tag="addTag"
                             :taggable="{{ $taggable ? 'true' : 'false'}}"
                             :select-label="'{{ trans('sleeping_owl::lang.select.init') }}'"
                             :selected-label="'{{ trans('sleeping_owl::lang.select.selected') }}'"
                             :deselect-label="'{{ trans('sleeping_owl::lang.select.deselect') }}'"
                >
                </multiselect>
    
                
            </div>
        </deselect>
    
        @include(AdminTemplate::getViewPath('form.element.partials.helptext'))
        @include(AdminTemplate::getViewPath('form.element.partials.errors'))
    </div>
    