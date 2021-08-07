@php
    $url = $url ?? null;
@endphp
<a href="#" class="dropdown-toggle  {{messages()->getPageMessages($url)->problems()->count() ? "blink-text" : ""}}"
   data-toggle="dropdown" aria-expanded="true">
    <i class="fa fa-sticky-note"></i>

    <span class="hidden-xs">
                Сообщения
        </span>
    @if(messages()->getProblemsCount())
        <span class="badge label-danger">
                 {{messages()->getProblemsCount()}}
            </span>
    @endif
</a>
<ul class="dropdown-menu">
    <li>
        <br>
        <a data-toggle="createAdminMessage" onclick="adminMessages.createMessageFor('{{messages()->getPageInfo($url)->model}}',{{messages()->getPageInfo($url)->id}})">
                 <span class="label label-success">
                        <i class="fa fa-btn fa-plus"></i>
                 </span>&nbsp;
            Добавить сообщение
        </a>
    </li>
    <li class="spacer">
        <hr>
    </li>
    @if(messages()->getProblemsCount())

        <li>
            <a href="/admin/messages?type=problem">
                     <span class="label label-danger">
                         <i class="fa fa-flag"></i>
                      </span>&nbsp;
                {{messages()->getProblemsCount()}} проблем требуют внимания!
            </a>
        </li>
        <li class="spacer">
            <hr>
        </li>
    @endif

    @include('admin.widgets.messages.section-content')

    @if(messages()->getLastMessages()->count())
        <li>
            <a class="text-muted">
                Последние {{messages()->getLastMessages()->count()}} сообщений:
            </a>
        </li>
        @foreach(messages()->getLastMessages() as $message)
            <li>
                <a onclick="adminMessages.showMessage({{$message->id}})" >
                    @include("admin.messages.short", ["message"=>$message])
                </a>
            </li>
        @endforeach
        <li class="spacer">
            <hr>
        </li>
    @endif
    <li>
        <a href="/admin/messages">
                 <span class="label label-info">
                        <i class="fa fa-btn fa-sticky-note-o"></i>

                 </span>&nbsp;
            Перейти к сообщениям
        </a>
    </li>
    <li class="spacer">
        <hr>
    </li>

</ul>
