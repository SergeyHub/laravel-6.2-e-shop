<div class="panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <button class="btn btn-success" onclick="adminMessages.createMessageFor('_backend')">
                    <i class="fa fa-plus"></i>
                    Добавить сообщение
                </button>
            </div>
            <div class="col-md-8 text-right">
                <form method="get" class="form-inline">
                    <label>
                        <i class="fa fa-cog"></i>
                        Объект
                    </label>
                    <select name="model" class="form-control">
                        <option value="">Не выбрано</option>
                        @foreach(config("admin-messages.sections") ?? [] as $model=>$item)
                            <option value="{{$model}}">{{$item['section_name']}}</option>
                        @endforeach
                    </select>
                    |
                    <label>
                        <i class="fa fa-user"></i>
                        Пользователь
                    </label>
                    <select name="user" class="form-control">
                        <option value="">Не выбрано</option>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                    |
                    <label>
                        <i class="fa fa-sticky-note"></i>
                        Тип
                    </label>
                    <select name="type" class="form-control">
                        <option value="">Не выбрано</option>
                        <option value="bug">Баг</option>
                        <option value="problem">Проблема</option>
                        <option value="note">Заметка</option>
                        <option value="message">Сообщение</option>
                        <option value="resolved">Закрыто</option>
                    </select>
                    |
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search"></i>
                        Выбрать
                        @if($sorted)
                            / Сбросить
                        @endif
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
<br>
<div class="panel">
    <div class="panel-body">
        <h2>Сообщения</h2>
        <hr>
        @if($sorted->user)
            <p>
                <i class="fa fa-user"></i>
                Пользователь: {{$sorted->user}}
            </p>
        @endif
        @if($sorted->model)
            <p>
                <i class="fa fa-cog"></i>
                Объект: {{$sorted->model}}
            </p>
        @endif
        @if($sorted->type)
            <p>
                <i class="fa fa-sticky-note"></i>
                Тип: {{$sorted->type}}
            </p>
        @endif
        @if($sorted->type || $sorted->model || $sorted->user)
           <hr>
        @endif
        @include("admin.messages.modal.show")
    </div>
</div>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded",()=>{
        window.messagesPage = true;
    })
</script>
