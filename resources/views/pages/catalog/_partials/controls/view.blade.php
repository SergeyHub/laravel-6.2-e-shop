<div class="d-lg-flex d-none align-items-center">
    <label class="filters__view  mb-0">
        <input class="filters__view__input" type="radio" name="view" value="grid" {{request()->get("view") != "list" ? "checked" : ""}}>
        <div class="filters__view__icon icon-center">
            @svg('images/svg/grid.svg')
        </div>
    </label>
    <label class="filters__view mb-0">
        <input class="filters__view__input" type="radio" name="view" value="list" {{request()->get("view") == "list" ? "checked" : ""}}>
        <div class="filters__view__icon icon-center">
            @svg('images/svg/list.svg')
        </div>
    </label>
</div>
