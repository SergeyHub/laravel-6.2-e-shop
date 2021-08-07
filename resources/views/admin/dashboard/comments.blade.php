<div class="box box-danger" id="comments">
    <div class="box-header with-border">
        <h3 class="box-title">Необработанные <a href="/admin/comments">комментарии</a> (последние 5)</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table no-margin no-head-bg">
                <thead>
                <tr>
                    <th>Клиент</th>
                    <th>Сообщение</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($comments->take(5) as $comment)
                    <tr>
                        <td>{{ $comment->name }}<br>
                            {{ $comment->email }}</td>
                        <td>
                            <p class="message"
                               style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 90px;">
                                {{ $comment->message }}
                            </p>
                            <a class="btn btn-info btn-xs" data-toggle="expand-message">
                                <i class="fa fa-eye"></i> Раскрыть
                            </a>
                        </td>
                        <td>{{ $comment->created_at }}</td>
                        <td  style="width: 100px">
                            <a class="btn btn-success btn-xs" data-toggle="handle" data-method="post" data-url="/admin/comments/{{$comment->id}}/quick">
                                <i class="fa fa-check"></i>
                            </a>
                            <a class="btn btn-primary btn-xs" href="{{$comment->getEditLink()}}">
                                <i class="fa fa-reply"></i>
                            </a>
                            <a class="btn btn-danger btn-xs" data-toggle="handle" data-method="delete"
                               data-url="/admin/comments/{{$comment->id}}/delete">
                                <i class="fa fa-remove"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            defineHandlers("#comments");
        });
    </script>
</div>

