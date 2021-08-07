<template>
    <form class="d-flex align-items-center">
        <input type="hidden" name="order" v-model="$root.order">
        <div class="filters__select position-relative">
            <div class="btn btn-sm filters__select__option js-filters-select">
                    <span class="icon mr-3">
                        <span v-if="current.icon === 'decrease'" class="js-filters__select__icon desc">
                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2 14.5938H5H2Z" fill="#131313"/>
                                <path d="M2 14.5938H5" stroke="#FD6311" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2 8.5H10H2Z" fill="#131313"/>
                                <path d="M2 8.5H10" stroke="#FD6311" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2 2.40625H15H2Z" fill="#131313"/>
                                <path d="M2 2.40625H15" stroke="#FD6311" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span v-if="current.icon === 'increase'" class="js-filters__select__icon asc">
                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 2.40625H5" stroke="#FD6311" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2 8.5H10" stroke="#FD6311" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2 14.5938H15" stroke="#FD6311" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </span>
                <span class="text">{{current.label}}</span>
                <span class="arrow ml-auto">
                    <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.95969 0H1.04031C0.621059 0 0.387973 0.484966 0.649878 0.812348L3.60957 4.51196C3.80973 4.76216 4.19027 4.76216 4.39043 4.51196L7.35012 0.812348C7.61203 0.484966 7.37894 0 6.95969 0Z" fill="#FD6311"/>
                    </svg>
                </span>
            </div>
            <div class="filters__select__list position-absolute d-none js-filters-select-list">
                <div v-for="mode in modes"
                     :data-value="mode.key"
                     :data-direction="mode.icon"
                     :data-label="mode.label"
                     :key="mode.key"
                     class="btn btn-sm filters__select__option js-filters-select-option"
                     :class="mode.key === $root.order ? 'd-none' : ''">
                    <span class="icon mr-3">
                        <svg v-if="mode.icon === 'decrease'" width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2 14.5938H5H2Z" fill="#131313"/>
                            <path d="M2 14.5938H5" stroke="#FD6311" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2 8.5H10H2Z" fill="#131313"/>
                            <path d="M2 8.5H10" stroke="#FD6311" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2 2.40625H15H2Z" fill="#131313"/>
                            <path d="M2 2.40625H15" stroke="#FD6311" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <svg v-if="mode.icon === 'increase'" width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 2.40625H5" stroke="#FD6311" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 8.5H10" stroke="#FD6311" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 14.5938H15" stroke="#FD6311" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="text">{{mode.label}}</span>
                </div>
            </div>
        </div>
        <div class="d-lg-flex d-none align-items-center">
            <label class="filters__view  mb-0">
                <input class="filters__view__input" type="radio" name="view" value="grid" v-model="$root.view">
                <div class="filters__view__icon icon-center">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="2" y="2" width="7.5" height="7.5" stroke="#B9B9B9" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <rect x="14.5" y="2" width="7.5" height="7.5" stroke="#B9B9B9" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <rect x="14.5" y="14.5" width="7.5" height="7.5" stroke="#B9B9B9" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <rect x="2" y="14.5" width="7.5" height="7.5" stroke="#B9B9B9" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </label>
            <label class="filters__view mb-0">
                <input class="filters__view__input" type="radio" name="view" value="list" v-model="$root.view">
                <div class="filters__view__icon icon-center">
                    <svg width="24" height="18" viewBox="0 0 24 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 1.5H22" stroke="#B9B9B9" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 9H22" stroke="#B9B9B9" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 16.5H22" stroke="#B9B9B9" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 1.5H3" stroke="#B9B9B9" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 9H3" stroke="#B9B9B9" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 16.5H3" stroke="#B9B9B9" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </label>
        </div>
    </form>
</template>

<script>
    export default {
        props: {
            ordering_modes: null,
            label: null,
            icon: null,
        },
        computed: {
            current: function () {
                let res = this.ordering_modes[this.$root.order];
                if (typeof (res) != "undefined" && res !== null) {
                    return {
                        "key": this.$root.order,
                        "icon": res.icon,
                        "label": res.label
                    };
                }
                return {
                    "icon": "decrease",
                    "key": "popular",
                    "label": "По популярности"
                };
            },
            modes: function () {
                let res = [];
                $.each(this.ordering_modes, function (i, v) {
                    res.push({
                        key: i,
                        icon: v.icon,
                        label: v.label
                    })
                });
                return res;
            }
        },
    }

</script>
