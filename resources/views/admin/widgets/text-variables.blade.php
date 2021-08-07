<div class="variables-help">

    <div class="card">
        <h2>Текстовые переменные</h2>
        <p class="small">Нажмите по переменной для <i class="fa fa-paste"></i> копирования в буфер обмена </p>
        @foreach(\App\Services\AdminHelperService::GetTextVariablesHelp() as $section)
            <h4>
                <a class="btn btn-primary btn-xs" data-toggle="collapse" href="#vars_{{$section->section}}"
                   role="button"
                   aria-expanded="false">
                    <i class="fa fa-caret-square-o-down"></i>
                </a>
                <i class="{{$section->icon}}"></i>
                {{$section->title}}
            </h4>
            <div id="vars_{{$section->section}}" class="collapse">
                <h5>{{$section->description}}</h5>
                <hr>
                @foreach($section->variables as $var=>$desc)
                    <p>
                        <span data-toggle="copy" class="var-name">{{$var}}</span> -
                        {{$desc}}
                    </p>
                @endforeach
                <hr>
            </div>

        @endforeach
    </div>
    <a class="shortcut">
        <i class="fa fa-file-text-o"></i>
        <span>
            Текстовые переменные
        </span>
    </a>
</div>


