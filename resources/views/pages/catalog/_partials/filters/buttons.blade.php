<div class="form-group filters__buttons">
    <button class="btn btn-sm w-100 mb-3 filter-apply d-lg-none">
        Применить
    </button>
    <div class="filter-drop__wrapper {{!filters()->tree()->filters_active ? "d-none" : "active"}}">
        <button type="button" class="btn btn-sm btn-light w-100 filter-drop js-clear-btn">
            <span class="icon">@svg('images/svg/filter-drop.svg')</span>
            Сбросить
        </button>
    </div>
</div>
