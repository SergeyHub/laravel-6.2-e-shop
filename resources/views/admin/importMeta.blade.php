<div class="row">
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">Импорт метатегов</div>
            <div class="panel-body">
                <form action="{{ route('admin.importMeta') }}" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="price">Метатеги</label>
                        <input type="file" name="metas" id="metas">
                    </div>
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-success">Импортировать</button>
                </form>
            </div>
        </div>
    </div>
</div>
