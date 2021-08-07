<label class="filter-instance checkbox d-flex align-items-center justify-content-between {{$filter->count ? "" : "disabled"}}">
    <input type="checkbox" name="filters[]"
           value="{{$filter->alias}}" {{$filter->checked ? "checked=\"checked\"" : ""}} {{$filter->count ? "" : "disabled"}}>
    <span class="checkbox__text filter-instance__name">{{$filter->name}}</span>
    @if($filter->count > 0)
        <span class="filter-instance__count">{{$filter->count}}</span>
    @endif
</label>

