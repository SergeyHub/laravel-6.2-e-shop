<template>
    <label class="filter-instance checkbox d-flex align-items-center justify-content-between"
           :class="disabled ? 'disabled' : ''">
        <input type="checkbox" :name="name" :value="value" v-model="checked" :disabled="disabled">
        <span class="checkbox__text filter-instance__name">{{label}}</span>
        <span v-if="count > 0" class="filter-instance__count">{{count}}</span>
    </label>
</template>
<script>
    export default {
        props: {
            name: {
                //type: String,
                default: "filters[]"
            },
            value: {
                //type: String,
                default: "1",

            },
            label: {
                //type: String,
                default: "Filter Instance"
            },
            checked: {
                //type: Number,
                default: null,
                likes: Number
            },
            count: {
                //type: Number,
                default: 0,
                likes: Number
            },
        },
        computed:
            {
                disabled: function () {
                    return this.count < 1 && !this.checked;
                }
            },
        watch:
            {
                checked: function (value, old) {
                    if(old !== null && value !== old)
                    {
                        this.$parent.filterChanged(this.name, value)
                    }
                },
            },
        methods: {},
        /**----------**/
    }
</script>
