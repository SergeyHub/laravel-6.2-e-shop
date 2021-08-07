<div class="form-group filters__availability">
    <label class="filters__bar__label d-flex align-items-center justify-content-between cursor-pointer"
        data-toggle="collapse" data-target="#filters-availab-content" aria-expanded="true">
        Наличие
        <span class="arrow">@svg('images/svg/arrow-select-red.svg')</span>
    </label>
    <div id="filters-availab-content" class="filters__bar__content collapse show">
        <label class="filter-instance checkbox d-flex align-items-center justify-content-between">
            <input type="checkbox" name="availability" value="1" {{filters()->tree()->availability ? "checked=\"checked\"" : ""}}>
            <span class="checkbox__text filter-instance__name">В наличии</span>
            <span class="filter-instance__count">{{filters()->tree()->availability_count}}</span>
        </label>
    </div>
</div>
<div class="form-group filters__availability">
    <label class="filters__bar__label d-flex align-items-center justify-content-between cursor-pointer"
           data-toggle="collapse" data-target="#filters-offers-content" aria-expanded="true">
        Наши предложения
        <span class="arrow">@svg('images/svg/arrow-select-red.svg')</span>
    </label>
    <div id="filters-offers-content" class="filters__bar__content collapse show">
        <label class="filter-instance checkbox d-flex align-items-center justify-content-between {{filters()->tree()->discount_count ? "" : "disabled"}}">
            <input type="checkbox" name="discount" value="1" {{filters()->tree()->discount ? "checked=\"checked\"" : ""}} {{filters()->tree()->discount_count ? "" : "disabled"}}>
            <span class="checkbox__text filter-instance__name">Со скидкой</span>
            <span class="filter-instance__count">{{filters()->tree()->discount_count}}</span>
        </label>
        <label class="filter-instance checkbox d-flex align-items-center justify-content-between {{filters()->tree()->promote_count ? "" : "disabled"}}">
            <input type="checkbox" name="promote" value="1" {{filters()->tree()->promote ? "checked=\"checked\"" : ""}} {{filters()->tree()->promote_count ? "" : "disabled"}}>
            <span class="checkbox__text filter-instance__name">Хит</span>
            <span class="filter-instance__count">{{filters()->tree()->promote_count}}</span>
        </label>
        <label class="filter-instance checkbox d-flex align-items-center justify-content-between {{filters()->tree()->new_count ? "" : "disabled"}}">
            <input type="checkbox" name="new" value="1" {{filters()->tree()->new ? "checked=\"checked\"" : ""}} {{filters()->tree()->new_count ? "" : "disabled"}}>
            <span class="checkbox__text filter-instance__name">Новинка</span>
            <span class="filter-instance__count">{{filters()->tree()->new_count}}</span>
        </label>
    </div>
</div>
