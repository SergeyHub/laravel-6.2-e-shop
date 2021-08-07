<template>
    <div v-if="enabled">
        <div class="row">
            <div class="col text-center">
                <div class="pagination catalog__pagination justify-content-center align-items-center">
                    <!--  PREV BUTTON -->
                    <button type="button" class="icon-center nav-arrow  js-catalog-pagination-page"
                            v-on:click="page(current-1)">
                       <svg width="8" height="11" viewBox="0 0 8 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.62025 0.629004C6.10206 0.110821 5.26192 0.11082 4.74374 0.629003L0.990724 4.38202C0.580778 4.79196 0.495149 5.40341 0.733836 5.89754C0.796875 6.02815 0.882568 6.15057 0.990914 6.25892L4.74393 10.0119C5.26211 10.5301 6.10225 10.5301 6.62044 10.0119C7.13862 9.49375 7.13862 8.65361 6.62044 8.13543L3.80538 5.32037L6.62025 2.50551C7.13843 1.98733 7.13843 1.14719 6.62025 0.629004Z" fill="white"/>
                        </svg>

                    </button>

                    <!-- PAGE BUTTON -->
                    <a v-for="p in pages" :key="p" class="nav-number js-catalog-pagination-page" :class="current == p ? 'active' : ''" v-on:click="page(p)"
                       :href="href(p)">
                        {{p}}
                    </a>

                    <!-- NEXT PAGE BUTTON -->
                    <button type="button" class="icon-center nav-arrow js-catalog-pagination-page"
                            v-on:click="page(current+1)">
                        <svg width="8" height="11" viewBox="0 0 8 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M1.37975 10.3712C1.89793 10.8894 2.73808 10.8894 3.25626 10.3712L7.00928 6.61823C7.41922 6.20828 7.50485 5.59683 7.26616 5.1027C7.20313 4.97209 7.11743 4.84967 7.00909 4.74132L3.25607 0.988308C2.73789 0.470124 1.89775 0.470124 1.37956 0.988307C0.86138 1.50649 0.861379 2.34663 1.37956 2.86481L4.19462 5.67987L1.37975 8.49473C0.861569 9.01291 0.861568 9.85306 1.37975 10.3712Z" fill="white"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <!-- SHOW BUTTON  -->
                <a class="btn btn-sm btn-light catalog__pagination__btn  js-catalog-pagination-page d-inline-flex"
                   v-on:click="page('all')" :href="href('all')">Просмотреть всё</a>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ["current", "count"],
        computed: {
            enabled: function () {
                return this.count > 1 && this.current !== "all";
            },
            pages: function () {
                let res = [];
                for (let i = 0; i < this.count; i++) {
                    res.push(i + 1);
                }
                return res;
            },
        },
        methods: {
            href: function (page) {
                let builder = new URLSearchParams(window.location.search.substr(1));
                builder.delete("page");
                if (page !== 1) {
                    builder.append("page", page);
                }
                let query =  builder.toString();
                return query.length ? window.location.pathname+"?" + builder.toString() : window.location.pathname;
            },
            page: function (page) {
                if (page === "all" || (page > 0 && page <= this.count)) {
                    this.$root.load(this.href(page));
                }
            }
        }
    }
</script>
