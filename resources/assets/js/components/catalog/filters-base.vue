<template>
    <form class="filters__bar js-filters__bar position-relative">
        <filter-price></filter-price>
        <div class="form-group filters__availability">
            <label class="filters__bar__label d-flex align-items-center justify-content-between cursor-pointer"
                   data-toggle="collapse" data-target="#filters-availab-content" aria-expanded="true">
                Наличие
                <span class="arrow">
                    <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.95969 0H1.04031C0.621059 0 0.387973 0.484966 0.649878 0.812348L3.60957 4.51196C3.80973 4.76216 4.19027 4.76216 4.39043 4.51196L7.35012 0.812348C7.61203 0.484966 7.37894 0 6.95969 0Z" fill="#FD6311"/>
                    </svg>
                </span>
            </label>
            <div id="filters-availab-content" class="filters__bar__content collapse show">
                <filter-instance label="В наличии"
                                 name="availability"
                                 :count=$root.availability_count
                                 :checked=$root.availability></filter-instance>
            </div>
        </div>
        <div class="form-group filters__availability">
            <label class="filters__bar__label d-flex align-items-center justify-content-between cursor-pointer"
                   data-toggle="collapse" data-target="#filters-offers-content" aria-expanded="true">
                Наши предложения
                <span class="arrow">
                    <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.95969 0H1.04031C0.621059 0 0.387973 0.484966 0.649878 0.812348L3.60957 4.51196C3.80973 4.76216 4.19027 4.76216 4.39043 4.51196L7.35012 0.812348C7.61203 0.484966 7.37894 0 6.95969 0Z" fill="#FD6311"/>
                    </svg>
                </span>
            </label>
            <div id="filters-offers-content" class="filters__bar__content collapse show">
                <filter-instance
                        label="Новинка"
                        name="latest"
                        :count=$root.latest_count
                        :checked=$root.latest></filter-instance>
                <filter-instance
                        label="Хит"
                        name="promote"
                        :count=$root.promote_count
                        :checked=$root.promote></filter-instance>
                <filter-instance
                        label="Со скидкой"
                        name="discount"
                        :count=$root.discount_count
                        :checked=$root.discount></filter-instance>
            </div>

        </div>
        <filter-group v-for="group in $root.groups"
                      :key="group.alias"
                      :alias="group.alias"
                      :active="group.active"
                      :title="group.name"
                      :filters="group.filters"
        ></filter-group>
        <filter-buttons></filter-buttons>
    </form>
</template>

<script>
    export default {
        //store: store,
        methods: {
            filterChanged: function (key, value) {
                this.$root[key] = value;
                this.$root.apply();
            },
            filterGroupChanged: function (groupKey, filterKey, value) {
                console.log(groupKey + " " + filterKey + " " + value)
                this.$root.groups[groupKey].filters[filterKey].checked = value;
                this.$root.apply();
            },
        }
    }
</script>

