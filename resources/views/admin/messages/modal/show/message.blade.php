@php
    $rnd = str_random(8);
@endphp
<div class="panel panel-default">

    <div class="panel-heading">

        <div class="pull-left">
            @include("admin.messages.icon-infobox")
        </div>
        {{$message->type_name}}:
        <b>{{$message->description}}</b> &nbsp;&nbsp;&nbsp;
        <div class="pull-right">
            <i class="fa fa-history"></i> {{$message->created_at}}&nbsp;&nbsp;&nbsp;
            <i class="fa fa-user"></i> {{$message->user_name}}
        </div>

    </div>
    <div class="panel-body">
        <a href="{{$message->model_link}}" class="lead message-model" target="_blank">
            <i class="{{$message->model_icon}}"> </i> {{$message->model_name}}

            @if(strlen($message->instance_name) > 1)
                {{$message->instance_name}}
            @endif
            <span class="small">
                   <i class="fa fa-link"></i>
            </span>
        </a>
        <hr>
        @if($message->href)
            <i class="fa fa-link"></i>
            Ссылка: <a href="{{$message->href}}">{{$message->href}}</a><br><br>
        @endif
        @if (strlen($message->message_html) > 0)
            {!! $message->message_html !!}
        @else
            {!! $message->description !!}
        @endif
    </div>
    <div class="panel-footer">
        {{--        <a class="btn btn-primary btn-xs" data-toggle="collapse" data-target="#message{{$message->id}}_{{$rnd}}">
                    Развернуть
                    <i class="fa fa-chevron-down"></i>
                </a>
                |--}}
        @if($message->model_link)
            <a class="btn btn-info btn-xs" href="{{$message->model_link}}">
                Перейти к объекту
                <i class="fa fa-link"></i>
            </a>
            |
        @endif
        @if($message->type == "problem" || $message->type == "bug")
            <form method="post" class="inline" action="{{route('admin.messages.confirm',['message'=>$message->id])}}"
                  onsubmit="return adminMessages.submitMessageConfirm(this)">
                {{csrf_field()}}
                <button type="submit" class="btn btn-success btn-xs">
                    <i class="fa fa-check"></i>
                    Закрыть проблему
                </button>
            </form>

        @endif

        <div class="pull-right">
            <a class="btn btn-warning btn-xs" onclick="adminMessages.editMessage({{$message->id}})">
                Изменить
                <i class="fa fa-edit"></i>
            </a>
            |
            <form method="post" class="inline" action="{{route('admin.messages.remove',['message'=>$message->id])}}"
                  onsubmit="return adminMessages.submitMessageRemove(this)">
                {{csrf_field()}}
                <button type="submit" class="btn btn-danger btn-xs">
                    <i class="fa fa-remove"></i>
                    Удалить сообщение
                </button>
            </form>
        </div>

    </div>
</div>
{{--<div class="collapse" id="message{{$message->id}}_{{$rnd}}">
    @if($message->href)
        <i class="fa fa-link"></i>
        Ссылка: <a href="{{$message->href}}">{{$message->href}}</a><br>
    @endif
      {!! $message->message_html !!}
</div>--}}
<br>
<br>
