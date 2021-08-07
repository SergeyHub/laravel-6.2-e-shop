@foreach($messages->where("type","bug") as $message)
    @include("admin.messages.modal.show.message")
@endforeach
@foreach($messages->where("type","problem") as $message)
    @include("admin.messages.modal.show.message")
@endforeach
@foreach($messages->where("type","note") as $message)
    @include("admin.messages.modal.show.message")
@endforeach
@foreach($messages->where("type","message") as $message)
    @include("admin.messages.modal.show.message")
@endforeach
@foreach($messages->where("type","resolved") as $message)
    @include("admin.messages.modal.show.message")
@endforeach
@if(count($messages) == 0)
<p class="lead">Сообщений не найдено...</p>
@endif
