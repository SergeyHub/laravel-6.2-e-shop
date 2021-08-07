<div class="row">
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">Импорт контактов</div>
            <div class="panel-body">
                <form action="{{ route('admin.import') }}" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="price">Контакты</label>
                        <input type="file" name="cities" id="cities">
                    </div>
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-success">Импортировать</button>
                </form> 
            </div>
        </div>
    </div>
</div>