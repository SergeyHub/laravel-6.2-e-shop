<div class="box box-danger" id="questions">
    <div class="box-header with-border">
        <h3 class="box-title">Необработанные <a href="/admin/questions">вопросы</a> (последние 5)</h3>
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
                @foreach($questions->take(5) as $question)
                    <tr>
                        <td>{{ $question->name }}<br>
                            {{ $question->email }}</td>
                        <td>
                            <p class="message"
                               style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 90px;">
                                {{ $question->question }}
                            </p>
                            <a class="btn btn-info btn-xs" data-toggle="expand-message">
                                <i class="fa fa-eye"></i> Раскрыть
                            </a>
                        </td>
                        <td>{{ $question->created_at }}</td>
                        <td style="width: 100px">
                            <a class="btn btn-success btn-xs" data-toggle="handle-qa" data-method="post" data-url="/admin/questions/{{$question->id}}/quick">
                                <i class="fa fa-comment"></i>
                            </a>
                            <a class="btn btn-primary btn-xs" href="{{$question->getEditLink()}}">
                                <i class="fa fa-reply"></i>
                            </a>
                            <a class="btn btn-danger btn-xs" data-toggle="handle" data-method="delete"
                               data-url="/admin/questions/{{$question->id}}/delete">
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
            defineHandlers("#questions");
        });
    </script>
</div>
