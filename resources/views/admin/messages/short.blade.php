@include("admin.messages.icon")&nbsp;
{{\mb_substr(strip_tags($message->description ?? $message->message), 0, 30)}}
{{mb_strlen($message->description ?? $message->message) > 30 ? "..." : ""}}
в  {{$message->model_name}} <i class="{{$message->model_icon}}"></i>
