<div class="row">

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box info-box-small">
            @if ($instance->type == "create")
                <span class="info-box-icon bg-green"><i class="{{$instance->type_icon}}"></i></span>
            @elseif ($instance->type == "update")
                <span class="info-box-icon bg-blue"><i class="{{$instance->type_icon}}"></i></span>
            @elseif ($instance->type == "delete")
                <span class="info-box-icon bg-red"><i class="{{$instance->type_icon}}"></i></span>
            @else
                <span class="info-box-icon bg-gray"><i class="fa fa-fw fa-cog"></i></span>
            @endif
            <div class="info-box-content">
                <span class="info-box-text">Действие</span><br>
                <span class="info-box-number">{{$instance->type_name}}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box info-box-small">
            <span class="info-box-icon bg-light"><i class="fa fa-history"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Дата и время</span><br>
                <span
                    class="info-box-number">{{ $instance->created_at}}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box info-box-small">
            <span class="info-box-icon bg-aqua"><i class="{{$instance->model_icon}}"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Объект</span>

                <br>
                <span class="info-box-number">
                    {{ $instance->model_name }} : ID {{$instance->model_id}}
                    @if($instance->model_edit_link)
                        <a class="btn btn-xs btn-info d-inline" href="{{$instance->model_edit_link}}" target="_blank">
                            <i class="fa fa-window-restore"></i>
                            Открыть
                        </a>
                    @endif
                </span>

            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box info-box-small">
            <span class="info-box-icon bg-yellow-gradient"><i class="fa fa-user"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Пользователь</span><br>
                <span class="info-box-number">{{  $instance->user_name }}</span>
            </div>
        </div>
    </div>
</div>
@if($instance->description)
    <h2>Описание</h2>
    <div class="panel panel-default">
        <div class="panel-body">
            <p class="lead">
                {{$instance->description}}
            </p>
        </div>
    </div>
@endif
<div class="panel panel-default">
    <div class="panel-body">
        <table class="table" style="table-layout:auto;">
            <thead>
            <tr>
                @if ($instance->type == "update" || $instance->type == "delete")
                    <td class="lead" colspan="2">
                        Старое значение
                    </td>
                @endif
                @if ($instance->type == "update" || $instance->type == "create")
                    <td class="lead" colspan="2">
                        Новое значение
                    </td>
                @endif

            </tr>
            </thead>
            @foreach($instance->fields as $field)
                <tr>
                    <td colspan="{{$instance->type == "update" ? 4 : 2}}">
                        <h3>[{{$field}}]</h3>
                    </td>
                </tr>
                <tr class="compare">
                    <div class="lead">

                        @if ($instance->type == "update" || $instance->type == "delete")
                            <td>
                                @if ($instance->type == "delete")
                                    <i class="fa fa-minus-circle"></i>
                                @endif
                            </td>
                            <td style="min-width: 45%;">
                                <div class="d-block" style="max-width: 700px">
                                    <i class="old">@include("admin.history.instance.field",["value"=>$instance->old[$field]])</i>
                                </div>
                            </td>
                        @endif

                        @if ($instance->type == "update" || $instance->type == "create")
                            <td>
                                @if ($instance->type == "update")
                                    <i class="fa fa-arrow-right"></i>
                                @else
                                    <i class="fa fa-plus-circle"></i>
                                @endif
                            </td>
                            <td style="min-width: 45%;">
                                <div class="d-block" style="max-width: 700px">
                                    <i class="new">@include("admin.history.instance.field",["value"=>$instance->new[$field]])</i>
                                </div>
                            </td>
                        @endif

                    </div>
                </tr>
            @endforeach
        </table>
    </div>
    @if($instance->type == "update")
        <script type="text/javascript">

            document.addEventListener("DOMContentLoaded", function () {
                runCompare();
            });

        </script>
    @endif
</div>

