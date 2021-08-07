<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Последние <a href="/admin/history">действия</a></h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table no-margin no-head-bg">
                <thead>
                <tr>
                    <th>Действие</th>
                    <th>Автор</th>
                    <th>Дата</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach(\App\Models\History::orderBy("id","desc")->take(10)->get() as $instance)
                    <tr>
                        <td>
                            {!! $instance->label !!}
                        </td>
                        <td>
                            {{$instance->user_name}}
                        </td>
                        <td>
                            {{ $instance->created_at }}
                        </td>
                        <td>
                            <a class="btn btn-info btn-xs" href="{{route("admin.history.show", ["history" => $instance->id])}}"><i class="fa fa-eye" ></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
