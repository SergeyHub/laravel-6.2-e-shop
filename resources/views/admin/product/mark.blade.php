<strong>Описание в тизере</strong>
@if ($model->short_description)
    <span class="label label-success">Да</span>
@else
    <span class="label label-danger">Нет</span>
@endif
<br>
<strong>Описание</strong>
@if ($model->description)
    <span class="label label-success">Да</span>
@else
    <span class="label label-danger">Нет</span>
@endif
<br>

<strong>Характеристики</strong>
@if ($model->feature)
    <span class="label label-success">Да</span>
@else
    <span class="label label-danger">Нет</span>
@endif
<br>
<strong>Параметры</strong>
@php
    $pc = 0;
    if(!is_null($model->channels) && strlen($model->channels) > 0) $pc++;
    if(!is_null($model->bandwidth) && strlen($model->bandwidth) > 0) $pc++;
    if(!is_null($model->frequency) && strlen($model->frequency) > 0) $pc++;
    if(!is_null($model->depth) && strlen($model->depth) > 0) $pc++;

@endphp
@if ($pc == 4)
    <span class="label label-success">{{$pc}} / 4</span>
@else
    <span class="label label-danger">{{$pc}} / 4</span>
@endif
{{--<strong>Обзор</strong>
@if ($model->review)
    <span class="label label-success">Да</span>
@else
    <span class="label label-danger">Нет</span>
@endif
<br>--}}
<strong>Фотографии</strong>
@if (count($model->visibleImages) > 2)
    <span class="label label-success">{{count($model->visibleImages)}} / {{count($model->images)}}</span>
@else
    <span class="label label-danger">{{count($model->visibleImages)}} / {{count($model->images)}}</span>
@endif
