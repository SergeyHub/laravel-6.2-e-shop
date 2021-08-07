<a
    @if ($instance->model_edit_link)
      href="{{$instance->model_edit_link}}"
      target="_blank"
    @endif
>
    <div class="label label-info">
        <i class="{{$instance->model_icon}}"></i>
        {{$instance->model_name}} #{{$instance->model_id}}
        <span class="badge">
           <i class="{{$instance->type_icon}}"></i>
        </span>
        @if ($instance->model_edit_link)
            <i class="fa fa-link"></i>
        @endif
    </div>
</a>
