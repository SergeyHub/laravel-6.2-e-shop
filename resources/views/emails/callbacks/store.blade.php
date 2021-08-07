@if($callback->themes)
Вопрос:
<strong>
@switch($callback->themes)
    @case('cooperation')
        Хочу предложить сотрудничество
        @break
    @case('order-question')
        Вопрос по заказу
        @break
    @case('complaint')
        Оставить жалобу на сотрудника
        @break
    @case('question')
        Другой вопрос
        @break
    @default
      {{ $theme }}
@endswitch
</strong><br>
@endif
@if($callback->name)
Имя: <strong>{{ $callback->name }}</strong><br>
@endif
@if($callback->phone)
Телефон: <strong>{{ $callback->phone }}</strong><br>
@endif
@if($callback->city)
Город: <strong>{{ $callback->city }}</strong><br>
@endif
@if($callback->email)
Email: <strong>{{ $callback->email }}</strong><br>
@endif
<br>
@if($callback->message)
Сообщение клиента: <strong>{{ $callback->message }}</strong><br>
@endif
@if ($callback->files && count($callback->files))
<br>Вложения:<br>
    @foreach ($callback->files as $key => $file)
        <a href="{{ route('front')}}/admin/download/callback/{{ $callback->id }}/{{ $key }}">{{ \basename($file) }}</a><br>
    @endforeach
@endif
