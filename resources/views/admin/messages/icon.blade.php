@switch($message->type)
    @case("problem")
        <span class="label label-danger">
           <i class="fa fa-flag"></i>
        </span>
    @break
    @case("resolved")
    <span class="label label-default">
           <i class="fa fa-check-circle"></i>
        </span>
    @break
    @case("bug")
        <span class="label label-success">
           <i class="fa fa-bug"></i>
        </span>
    @break
    @case("note")
        <span class="label label-warning">
             <i class="fa fa-warning"></i>
        </span>
    @break

    @default
         <span class="label label-info">
             <i class="fa fa-sticky-note-o"></i>
         </span>
    @break
@endswitch
