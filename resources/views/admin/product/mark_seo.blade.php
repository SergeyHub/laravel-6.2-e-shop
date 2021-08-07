<strong>Заголовок</strong>
@if ($model->meta_title)
    <span class="label label-success">Да</span>
@else
    <span class="label label-danger">Нет</span>
@endif
<br>
<strong>Описание</strong>
@if ($model->meta_description)
    <span class="label label-success">Да</span>
@else
    <span class="label label-danger">Нет</span>
@endif
<br>
<strong>Ключи</strong>
@if ($model->meta_tags)
    <span class="label label-success">Да</span>
@else
    <span class="label label-danger">Нет</span>
@endif
<br>