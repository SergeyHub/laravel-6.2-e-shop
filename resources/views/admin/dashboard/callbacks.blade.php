<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">Последние <a href="/admin/callbacks">запросы</a></h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table no-margin no-head-bg">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Тип</th>
                    <th>Дата</th>
                    <th>Клиент</th>
                    <th>Сообщение</th>

                </tr>
                </thead>
                <tbody>
                @foreach($callbacks as $callback)
                    <tr>
                        <td>{{ $callback->id }}</td>
                        <td>{{ $callback->type }}</td>
                        <td>{{ $callback->created_at }}</td>
                        <td>
                            Имя: {{ $callback->name }}<br>
                            Телефон: {{ $callback->phone }}<br>
                            Email: {{ $callback->email }}<br>
                            Город: {{ $callback->city }}<br>
                            IP: {{ $callback->ip }}
                        </td>
                        <td>{{ $callback->message }}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
