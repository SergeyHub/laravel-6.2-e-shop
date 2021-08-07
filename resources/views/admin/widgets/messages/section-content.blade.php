<li>
    <a class="text-muted">
        Сообщения для страницы:
    </a>
</li>
@switch(messages()->getPageInfo($url)->type)
    @case("instance")
    @foreach(messages()->getInstanceMessages($url)->problems()->get() as $message)
        <li>
            <a class="blink-bg" onclick="adminMessages.showMessage({{$message->id}})">
                @include("admin.messages.short", ["message"=>$message])
            </a>
        </li>
    @endforeach
    @foreach(messages()->getInstanceMessages($url)->any()->get() as $message)
        <li>
            <a onclick="adminMessages.showMessage({{$message->id}})">
                @include("admin.messages.short", ["message"=>$message])
            </a>
        </li>
    @endforeach
    @break;
    @case("section")
    @foreach(messages()->getPageMessages($url)->problems()->get() as $message)
        <li>
            <a class="blink-bg" onclick="adminMessages.showMessage({{$message->id}})">
                @include("admin.messages.short", ["message"=>$message])
            </a>
        </li>
    @endforeach
    @foreach(messages()->getSectionMessages($url)->any()->get() as $message)
        <li>
            <a onclick="adminMessages.showMessage({{$message->id}})">
                @include("admin.messages.short", ["message"=>$message])
            </a>
        </li>
    @endforeach
    @break;
    @case("backend")
    @foreach(messages()->getPageMessages($url)->problems()->get() as $message)
        <li>
            <a class="blink-bg" onclick="adminMessages.showMessage({{$message->id}})">
                @include("admin.messages.short", ["message"=>$message])
            </a>
        </li>
    @endforeach
    @foreach(messages()->getPageMessages($url)->any()->get() as $message)
        <li>
            <a onclick="adminMessages.showMessage({{$message->id}})">
                @include("admin.messages.short", ["message"=>$message])
            </a>
        </li>
    @endforeach
    @break;
@endswitch
    <li class="spacer">
        <hr>
    </li>
