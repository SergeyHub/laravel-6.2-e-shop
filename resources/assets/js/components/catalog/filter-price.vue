<template>
    <div class="form-group filters__price">
        <label class="filters__bar__label mb-3">Цена</label>
        <div v-if="enabled" class="d-flex justify-content-between align-items-center mb-3">
            <input v-on:change="applyRange()" class="form-control px-3 text-center filters__price__input"
                   type="text"
                   name="price_from"
                   v-model="from"
            >
            <span class="mx-2">-</span>
            <input v-on:change="applyRange()" class="form-control px-3 text-center filters__price__input"
                   type="text" name="price_to"
                   v-model="to"
            >

        </div>
        <vue-slider v-if="enabled" :min="$root.price_min" :max="$root.price_max" v-model="price_range"/>
        <input v-if="!enabled" class="form-control px-3 text-center"
               readonly
               v-model="from">
    </div>
</template>

<script>
    import VueSlider from 'vue-slider-component'

    export default {
        props: {},
        computed: {
            enabled: function () {
                return this.$root.price_min < this.$root.price_max
            },
            to: {
                get() {
                    return this.$root.price_to + this.$root.currency;
                },
                set(v) {
                    let int = parseInt(v);
                    if (!isNaN(int)) {
                        this.$root.price_to = int;
                    }
                    this.$root.price_to = int;
                },
            },
            from: {
                get() {
                    return this.$root.price_from + this.$root.currency;
                },
                set(v) {
                    let int = parseInt(v);
                    if (!isNaN(int)) {
                        this.$root.price_from = int;
                    }
                }

            },
            price_range: {
                get() {
                    return [this.$root.price_from, this.$root.price_to];
                },
                set(value) {
                    this.$root.price_from = value[0];
                    this.$root.price_to = value[1];
                    //
                    this.$root.apply();
                }
            },
        },
        methods: {
            applyRange:function () {
                //fix errors
                if(isNaN(this.$root.price_from)) this.$root.price_from = this.$root.price_min;
                if(isNaN(this.$root.price_to)) this.$root.price_from = this.$root.price_max;
                //
                if(this.$root.price_from > this.$root.price_to) [this.$root.price_from, this.$root.price_to] = [this.$root.price_to, this.$root.price_from];
                //
                if(this.$root.price_from < this.$root.price_min) this.$root.price_from = this.$root.price_min;
                if(this.$root.price_to > this.$root.price_max) this.$root.price_to = this.$root.price_max;

                //
                this.$root.apply();
            }
        },
        components: {
            VueSlider
        }

    }
</script>

