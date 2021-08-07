<div class="box box-info">
    <div class="box-header with-border">
         <h3 class="box-title">Последние <a href="/admin/messages">сообщения</a></h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table no-margin no-head-bg">
                <thead>
                <tr>
                    <th>Сообщение</th>
                    <th>Автор</th>
                    <th>Дата</th>
                </tr>
                </thead>
                <tbody>
                @foreach(\App\Models\Message::orderBy("created_at","desc")->take(10)->get() as $message)
                    <tr>
                        <td>
                            <a onclick="adminMessages.showMessage({{$message->id}})" style="cursor: pointer">
                                @include("admin.messages.short", ["message"=>$message])
                            </a>
                        </td>
                        <td>
                            {{$message->user_name}}
                        </td>
                        <td>
                            {{ $message->created_at }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded",()=>{
        window.messagesPage = true;
    })
</script>