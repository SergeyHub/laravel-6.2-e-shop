<div class="form-group form-element-prices {{ $errors->has($name) ? 'has-error' : '' }}">
    <div class="text-center">
        <h4 class="text-center">
            <i class="fa fa-tags"></i>
            {!! $label !!}
        </h4>
    </div>
    <hr>

    <div class="bg-gray">
        <br>
        @foreach($groups as $group)
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                {{$group->name}}
                            </h3>
                            <div class="box-tools pull-right">
                                <!-- Buttons, labels, and many other things can be placed here! -->
                                <a class="label label-primary" href="{{$group->getEditLink()}}" target="_blank">
                                    <i class="fa fa-edit"></i>
                                </a>
                                @if(!$group->status)
                                    <span class="label label-danger">
                                    <i class="fa fa-arrow-down"></i>
                                    Скрыта
                                </span>
                                @endif
                                @if($group->chained)
                                    <span class="label label-danger">
                                    <i class="fa fa-chain"></i>
                                </span>
                                @endif

                            </div><!-- /.box-tools -->
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            @foreach($group->filters as $filter)
                                <label>
                                    <input data-toggle="toggle" type="checkbox" name="filters[]"
                                           value="{{$filter->id}}" {{$filters->contains($filter->id) ? "checked" : ""}}>
                                    {{$filter->name}}
                                    <a class="label label-primary" href="{{$filter->getEditLink()}}" target="_blank">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @if(!$filter->status)
                                        <span class="label label-danger">
                                    <i class="fa fa-arrow-down"></i>
                                    Скрыт
                                </span>
                                    @endif
                                </label>
                                <br>
                            @endforeach
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            @if($group->display_name)
                                <label class="label label-info">
                                    <i class="fa fa-info"></i>
                                </label>
                                (В списке как "{{$group->display_name}}")
                            @endif
                        </div><!-- box-footer -->
                    </div><!-- /.box -->
                </div>
            </div>
        @endforeach
    </div>



    @include(AdminTemplate::getViewPath('form.element.partials.helptext'))
    @include(AdminTemplate::getViewPath('form.element.partials.errors'))
    <hr>
</div>
