@if(is_null($value))
    "null"
@elseif(is_bool($value))
    {{$value ? 'true' : 'false'}}
@else
    {{escape_sequence_decode($value)}}
@endif
