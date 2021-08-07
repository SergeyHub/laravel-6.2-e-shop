@if ($msg)
<div class="alert alert-success alert-message">
    <button type="button" data-dismiss="alert" aria-label="Close" class="close">
        <span aria-hidden="true">×</span>
    </button> <i class="fa fa-check fa-lg"></i> {{$msg}}
</div>
@endif
@if(request()->session()->has('msgs'))
    @foreach(session('msgs') as $msg)
        <div class="alert alert-{{$msg['status']}} alert-message">
            <button type="button" data-dismiss="alert" aria-label="Close" class="close">
                <span aria-hidden="true">×</span>
            </button> <i class="fa fa-check fa-lg"></i> {{$msg['message']}}
        </div>
    @endforeach
@endif
<form action="/admin/pages/front/" method="POST">
    {{csrf_field()}}
    <div role="tabpanel" class="nav-tabs-custom ">
        <ul role="tablist" class="nav nav-tabs">
            <li role="presentation" class="active">
                <a href="#main" aria-controls="main" role="tab" data-toggle="tab">Общая информация</a>
            </li> 
            <li role="presentation">
                <a href="#preim" aria-controls="preim" role="tab" data-toggle="tab">Преимущества</a>
            </li>
            <li role="presentation">
                <a href="#used" aria-controls="used" role="tab" data-toggle="tab">Для чего используются</a>
            </li>
        </ul> 
        <div class="tab-content" style="padding: 10px">
            <div role="tabpanel" id="main" class="tab-pane in active">
                {!! AdminFormElement::text('title', 'Заголовок')->setDefaultValue($page->title) !!} 
                {!! AdminFormElement::text('data[subtitle]', 'Подзаголовок')->setDefaultValue(isset($page->data['subtitle'])?$page->data['subtitle']:'') !!} 
                {!! AdminFormElement::text('data[catalog_title]', 'Заголовок перед каталогом')->setDefaultValue(isset($page->data['catalog_title'])?$page->data['catalog_title']:'') !!} 
                {!! AdminFormElement::text('meta_title', 'Заголовок META')->setDefaultValue($page->meta_title) !!} 
                {!! AdminFormElement::textarea('meta_description', 'Описание META')->setDefaultValue($page->meta_description) !!} 
                {!! AdminFormElement::text('meta_keys', 'Ключи META')->setDefaultValue($page->meta_keys) !!} 
            </div>
            <div role="tabpanel" id="preim" class="tab-pane">
                {!! AdminFormElement::text('data[preim][title]', 'Заголовок') !!} 
                @for($i = 1; $i <=6; $i++)
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Блок {{$i}}</div>
                            <div class="panel-body">
                                {!! AdminFormElement::text('data[preim][items][{{$i}}][title]', 'Заголовок')->setDefaultValue(isset($page->data['preim']['items'][$i]['title'])?$page->data['preim']['items'][$i]['title']:'') !!} 
                                {!! AdminFormElement::textarea('data[preim][items][{{$i}}][text]', 'Текст')->setRows(4)->setDefaultValue(isset($page->data['preim']['items'][$i]['text'])?$page->data['preim']['items'][$i]['text']:'') !!} 
                            </div>
                        </div>
                    </div>
                @endfor
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" id="used" class="tab-pane">
                {!! AdminFormElement::text('data[used][title]', 'Заголовок') !!} 
                {!! AdminFormElement::images('data[used][images]', 'Картинки') !!} 

                {{--  @for($i = 1; $i <=6; $i++)
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Блок {{$i}}</div>
                            <div class="panel-body">
                                {!! AdminFormElement::text('data[preim][items][{{$i}}][title]', 'Заголовок')->setDefaultValue(isset($page->data['preim']['items'][$i]['title'])?$page->data['preim']['items'][$i]['title']:'') !!} 
                                {!! AdminFormElement::textarea('data[preim][items][{{$i}}][text]', 'Текст')->setRows(4)->setDefaultValue(isset($page->data['preim']['items'][$i]['text'])?$page->data['preim']['items'][$i]['text']:'') !!} 
                            </div>
                        </div>
                    </div>
                @endfor  --}}
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="form-buttons">
        <div role="group" class="btn-group">
            <button type="submit" name="action" value="add" class="btn btn-primary"><i class="fa fa-check"></i> Сохранить
            </button> 
        </div>
    </div>
		
</form>
