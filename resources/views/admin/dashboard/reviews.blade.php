<div class="box box-danger" id="reviews">
    <div class="box-header with-border">
        <h3 class="box-title">Необработанные <a href="/admin/reviews">отзывы</a> (последние 5)</h3>
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
                @foreach($reviews->take(5) as $review)
                    <tr>
                        <td>{{ $review->name }}<br>
                            {{ $review->phone }}</td>
                        <td>
                            <p class="message"
                               style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 90px;">
                                {{ $review->message_full }}
                            </p>
                            <a class="btn btn-info btn-xs" data-toggle="expand-message">
                                <i class="fa fa-eye"></i> Раскрыть
                            </a>
                        </td>
                        <td>{{ $review->created_at }}</td>
                        <td  style="width: 100px">
                            <a class="btn btn-success btn-xs" data-toggle="handle" data-method="post" data-url="/admin/reviews/{{$review->id}}/quick">
                                <i class="fa fa-check"></i>
                            </a>
                            <a class="btn btn-primary btn-xs" href="{{$review->getEditLink()}}">
                                <i class="fa fa-reply"></i>
                            </a>
                            <a class="btn btn-danger btn-xs" data-toggle="handle" data-method="delete"
                               data-url="/admin/reviews/{{$review->id}}/delete">
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
            defineHandlers("#reviews");
        });
    </script>
</div>

