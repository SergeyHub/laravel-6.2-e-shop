@php
    $message = $message ?? new \App\Models\Message(["model"=>$model, "model_id"=>$model_id]);
    $action = $message->id ? route("admin.messages.update",['message'=> $message->id]) : route("admin.messages.store");
@endphp
<form action="{{$action}}" method="post" onsubmit="return adminMessages.submitMessageForm(this)">
    {{csrf_field()}}
    <input type="hidden" name="model" value="{{$message->model}}">
    <input type="hidden" name="model_id" value="{{$message->model_id}}">
    <h3 class="text-center">Объект: {{$message->model_name}} <i class="{{$message->model_icon}}"></i> </h3>
    <p class="text-center small">{{$message->instance_name}}</p>
    <br>
    <div class="text-center">
        <h4>Тип сообщения</h4>
        <label class="badge label-info">
        <span class="lead">
            <i class="fa fa-sticky-note-o"></i>
               Сообщение
        </span>
            <input type="radio" name="type" value="message" {{$message->type == "message" ? "checked" : ""}}>
        </label>
        |
        <label class="badge label-warning">
        <span class="lead">
             <i class="fa fa-warning"></i>
             Заметка
        </span>

            <input type="radio" name="type" value="note" {{$message->type == "note" ? "checked" : ""}}>
        </label>
        |
        <label class="badge label-danger">
         <span class="lead">
            <i class="fa fa-flag"></i>
            Проблема
         </span>
            <input type="radio" name="type" value="problem" {{$message->type == "problem" ? "checked" : ""}}>
        </label>
        |
        <label class="badge label-success">
         <span class="lead">
            <i class="fa fa-bug"></i>
            Баг
         </span>
            <input type="radio" name="type" value="bug" {{$message->type == "bug" ? "checked" : ""}}>
        </label>
        |
        <label class="badge label-right">
          <span class="lead">
            <i class="fa fa-check"></i>
            Обработан
          </span>
            <input type="radio" name="type" value="resolved" {{$message->type == "resolved" ? "checked" : ""}}>
        </label>
        <hr>
        <h3>Краткое описание</h3>
        <input type="text" name="description" class="form-control" value="{{$message->description}}"  maxlength="191">
        <hr>
        <h3>Текст сообщения</h3>
        <textarea name="message" class="form-control w-100" style="resize:vertical;">{{$message->message}}</textarea>
        <hr>
        <h3>Выделенная ссылка (не обязательно)</h3>
        <input type="text" name="href" class="form-control" value="{{$message->href}}" maxlength="191">
        <br>
        <button type="submit" class="btn btn-primary">
            Сохранить
        </button>
    </div>


</form>
