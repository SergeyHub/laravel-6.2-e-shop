<div class="text-right" style="padding: 10px;">

    <form>
        Фильтры:
        @foreach($items as $key=>$value)
            <button type="submit" name="{{$key}}" value="1" class="btn btn-xs btn-default">
                {{$value}}
            </button>
            @if (!$loop->last)
                |
            @endif
        @endforeach
    </form>
</div>