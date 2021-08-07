<template>
    <div class="form-group filters__group">
        <label class="filters__bar__label d-flex align-items-center justify-content-between cursor-pointer"
               :class="isExpanded ? '' : 'collapsed'"
               data-toggle="collapse" :data-target="'#filters-group-content_'+alias" :aria-expanded="isExpanded">
            {{title}}
            <span class="arrow">
                <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.95969 0H1.04031C0.621059 0 0.387973 0.484966 0.649878 0.812348L3.60957 4.51196C3.80973 4.76216 4.19027 4.76216 4.39043 4.51196L7.35012 0.812348C7.61203 0.484966 7.37894 0 6.95969 0Z" fill="#FD6311"/>
                </svg>
            </span>
        </label>
        <div :id="'filters-group-content_'+alias" class="filters__bar__content collapse" :class="isExpanded ? 'show' : ''">
            <filter-instance v-for="filter in filters"
                            :key="filter.alias"
                             :label="filter.name"
                             :name="filter.alias"
                             :count="filter.count"
                             :checked="filter.checked"></filter-instance>
        </div>
    </div>

</template>
<script>
    export default {
        props: {
            alias: {
                default: "group"
            },
            title: {
                default: "Filter Group"
            },
            active: {
                default: false,
            },
            filters: {
                default: ()=>[],
            },
        },
        data: () => {
            return {
                isExpanded: false,
            }
        },
        computed: {},
        methods: {
            filterChanged: function(key, value)
            {
                this.$parent.filterGroupChanged(this.alias, key, value)
            }
        },
        created() {
            this.isExpanded = this.active;
        }
    }
</script>
