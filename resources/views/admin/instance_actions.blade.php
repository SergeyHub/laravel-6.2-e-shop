<div class="text-right" style="padding: 10px;">
    @if(isset($model) && $model instanceof \App\Models\Product && $model->remote_id > 0)
       @include("admin.library_widget",["product"=>$model])
    @endif
    <button type="submit" class="btn btn-info" name="next_action" value="save_and_continue">
        <i class="fa fa-save"></i>
        Сохранить
    </button>
    <a class="btn btn-default" target="_blank" href="{{$href}}">
        <i class="fa fa-mail-forward"></i>
        Открыть на сайте
    </a>
</div>
