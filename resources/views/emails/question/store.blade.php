@if($question->product)
Продукт: <strong><a href="{{ $question->product->getUrl() }}">{!! $question->product->name !!}</a></strong><br>
@endif
@if($question->name)
Имя: <strong>{{ $question->name }}</strong><br>
@endif
@if($question->phone)
Телефон: <strong>{{ $question->phone }}</strong><br>
@endif
@if($question->email)
Email: <strong>{{ $question->email }}</strong><br>
@endif
@if($question->title)
Заголовок: <strong>{{ $question->title }}</strong><br>
@endif
<br>
@if($question->question)
Вопрос: <strong>{{ $question->question }}</strong><br>
@endif
<br>
<br>
<a href="{{ config('app.url').'/admin/questions/'.$question->id.'/edit' }}">Ответить</a>
<br>
