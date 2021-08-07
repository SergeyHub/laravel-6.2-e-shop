<div class="text-right" style="padding: 10px;">
    @foreach($items as $key=>$item)
        <form class="inline">
            <label for="{{$key}}">
                {{$item['name']}}
            </label>
            <select name="{{$key}}" class="">
                @foreach($item['options'] as $value=>$text)
                    <option value="{{$value}}">{{$text}}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-xs btn-default">
                Показать
            </button>
            @if (!$loop->last)
                |
            @endif
        </form>
    @endforeach
</div>
