@switch($message->type)
    @case("problem")
    <span class="message-box-icon bg-red">
           <i class="fa fa-flag"></i>
        </span>
    @break
    @case("resolved")
    <span class="message-box-icon bg-gray">
           <i class="fa fa-check"></i>
        </span>
    @break
    @case("bug")
    <span class="message-box-icon bg-green">
           <i class="fa fa-bug"></i>
        </span>
    @break
    @case("note")
    <span class="message-box-icon bg-orange">
             <i class="fa fa-warning"></i>
        </span>
    @break
    @default
    <span class="message-box-icon bg-blue">
             <i class="fa fa-sticky-note-o"></i>
         </span>
    @break
@endswitch
