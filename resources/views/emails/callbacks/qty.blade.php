Новая заявка "Под заказ" от пользователя {{ $callback->name }}<br>
<br>
Имя: {{ $callback->name }}<br>
Телефон: {{ $callback->phone }}<br>
Город: {{ $callback->city }}<br>
CRM ID товара: {{$product->remote_id}}<br>
Название товара: {{$product->name}}<br>
Ссылка на товар: <a href="{{$product->getUrl()}}">{{$product->getUrl()}}</a><br>
<br>
