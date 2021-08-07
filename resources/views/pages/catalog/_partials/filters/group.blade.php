<div class="form-group filters__group">
    <label class="filters__bar__label d-flex align-items-center justify-content-between cursor-pointer"
        data-toggle="collapse" data-target="#filters-group-content_{{$group->alias}}" aria-expanded="true">
        {{$group->name}}
        <span class="arrow">@svg('images/svg/arrow-select-red.svg')</span>
    </label>
    <div id="filters-group-content_{{$group->alias}}" class="filters__bar__content collapse show">
        @foreach($group->filters as $filter)
            @include("pages.catalog._partials.filters.instance")
        @endforeach
    </div>
</div>
