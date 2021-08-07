<div class="form-group filters__price">
    <label class="filters__bar__label mb-3">Цена</label>
    @if(filters()->tree()->price_min != filters()->tree()->price_max)
        <div class="d-flex justify-content-between align-items-center mb-3">
            <input class="form-control px-3 text-center filters__price__input"
                   type="text"
                   name="price_from"
                   value="{{filters()->tree()->price_from}}"
                   min="{{filters()->tree()->price_min}}"
                   max="{{ filters()->tree()->price_max }}"
            >
            <span class="mx-2">-</span>
            <input class="form-control px-3 text-center filters__price__input"
                   type="text" name="price_to"
                   value="{{filters()->tree()->price_to}}"
                   min="{{filters()->tree()->price_min}}"
                   max="{{ filters()->tree()->price_max }}"
            >
        </div>
        <div class="price-slider"
             data-max="{{ filters()->tree()->price_max }}"
             data-min="{{ filters()->tree()->price_min }}"
             data-from="{{filters()->tree()->price_from}}"
             data-to="{{filters()->tree()->price_to}}"
        ></div>
    @else
        <input class="form-control px-3 text-center"
               readonly
               value="{{filters()->tree()->price_from}}{{country()->currency}}">
    @endif
</div>
