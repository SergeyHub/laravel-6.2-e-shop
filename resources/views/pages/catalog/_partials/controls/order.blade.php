{{-- <select name="order">
    <option value="popular">По популярности </option>
    <option value="price_asc" {{request()->get("order") == "price_asc" ? "selected" : ""}}>По цене возр. </option>
    <option value="price_desc" {{request()->get("order") == "price_desc" ? "selected" : ""}}>По цене убв. </option>
    <option value="name_asc" {{request()->get("order") == "name_asc" ? "selected" : ""}}>По названию возр. </option>
    <option value="name_desc" {{request()->get("order") == "name_desc" ? "selected" : ""}}>По названию убв. </option>
    <option value="discount_desc" {{request()->get("order") == "discount_desc" ? "selected" : ""}}>По размеру скидки </option>
</select> --}}
<input type="hidden" name="order" value="{{request()->get("order") ? request()->get("order") : "popular"}}">
<div class="filters__select position-relative">
    <div class="btn btn-sm filters__select__option js-filters-select">
        <span class="icon mr-3">
        <span class="js-filters__select__icon desc {{ ((Main::catalogOrders()[request()->order]['icon'] ?? 'decrease') == 'decrease' ? '' : 'd-none' ) }}">@svg('images/svg/decrease.svg')</span>
            <span class="js-filters__select__icon asc {{ ((Main::catalogOrders()[request()->order]['icon'] ?? 'decrease') == 'increase' ? '' : 'd-none' ) }}">@svg('images/svg/increase.svg')</span>
        </span>
        <span class="text">{{ Main::catalogOrders()[request()->order]['label'] ?? 'По популярности' }}</span>
        <span class="arrow ml-auto">@svg('images/svg/arrow-select-red.svg')</span>
    </div>
    <div class="filters__select__list position-absolute d-none js-filters-select-list">
        @foreach (Main::catalogOrders() as $key => $item)
        <div data-value="{{ $key }}" data-direction="{{ $item['icon'] == 'decrease' ? 'desc' : 'asc' }}" class="btn btn-sm filters__select__option js-filters-select-option {{ request()->order == $key ? 'd-none' : '' }}">
            <span class="icon mr-3">@if($item['icon'] == 'decrease') @svg('images/svg/decrease.svg') @else @svg('images/svg/increase.svg') @endif</span>
            <span class="text">{{ $item['label'] }}</span>
        </div>
        @endforeach
    </div>
</div>
