<div {!! $attributes !!}>
    <div class="text-center">

        @if($model instanceof \App\Interfaces\IDisplayable)
            <a class="btn btn-xs btn-info mb-1" href="{{$model->getShowLink()}}" target="_blank"  style="margin-bottom: 2px">
                <i class="fa fa-mail-forward"></i>
            </a>
        @endif
        @if(get_class($model) != \App\Models\History::class)

            <a class="btn btn-xs btn-success mb-1"
               href="/admin/history?model={{get_class($model)}}&id={{$model->id}}"
               target="_blank"
            style="margin-bottom: 2px">
                <i class="fa fa-history"></i>
            </a>
        @endif

        @foreach($buttons as $button)
            {!! $button->render() !!}
        @endforeach
        @if($model && $model->deleted_at)
            <span class="model_deleted" style="display:none"></span>
        @endif
        @if(messages()->hasForModel($model))
            <div style="padding-top: 4px;" class="text-center">
                @if(messages()->hasProblemsForModel($model))
                    <a class="btn btn-xs btn-danger" style="width: 48px; cursor: pointer"
                       onclick="adminMessages.showMessagesFor('{{$model->getTable()}}',{{$model->id}})">
                        <i class="fa fa-flag"></i>
                    </a>
                @elseif(messages()->hasNotesForModel($model))
                    <a class="btn btn-xs btn-warning" style="width: 48px; cursor: pointer"
                       onclick="adminMessages.showMessagesFor('{{$model->getTable()}}',{{$model->id}})">
                        <i class="fa fa-warning"></i>
                    </a>
                @else
                    <a class="btn btn-xs btn-info" style="width: 48px; cursor: pointer"
                       onclick="adminMessages.showMessagesFor('{{$model->getTable()}}',{{$model->id}})">
                        <i class="fa fa-sticky-note"></i>
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
