<div {!! $attributes !!}>
    @if($model instanceof \App\Interfaces\IEditable)
        <a href="{{$model->getEditLink()}}">
            {!! $value !!}
        </a>
    @else
        {!! $value !!}
    @endif
    {!! $append !!}
    @if($small)
        <small class="clearfix">{!! $small !!}</small>
    @endif
</div>
@if($model instanceof \App\Models\Product && $model->remote_id > 0)
    <p class="text-sm">
        <a title="Открыть в библиотеке"
           class="label bg-orange color-white"
                                   href="{{\App\Services\API\LibraryConnector::relayLink($model->remote_id)}}"
                                   target="_blank">
            <i class="fa fa-cubes"></i>
            {{$model->remote_id}}
            <i class="fa fa-mail-forward"></i>
        </a>
    </p>
@endif
