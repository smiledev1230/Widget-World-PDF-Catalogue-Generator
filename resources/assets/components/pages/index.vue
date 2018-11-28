<template>
    <div class="row home-content border-top">
        <h1>Recent Catalogues</h1>
        <div class="w-100 pt-3">
            <CatalgoueList :limited="4"></CatalgoueList>
            <router-link tag="a" to="/recent" class="btn btn-secondary pull-right text-white mt-2">VIEW ALL</router-link>
        </div>
    </div>
</template>
<script>
    import CatalgoueList from "./CatalogueList";

    export default {
        name: "index",
        components: {
            CatalgoueList
        },
        data() {
            return {}
        },
        mounted: function () {
            this.$store.state.page_text = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.";
            if (!this.$store.state.login_status) this.$router.push("/login");
            this.$store.dispatch('initCatalogue');
            let app = this;
            if (app.$store.state.suppliers.length <= 0) {
                axios
                    .get("/api/getSupplier")
                    .then(response => {
                        if (response && response.data) {
                            app.$store.state.suppliers = response.data;
                            for (let i=0;i<app.$store.state.suppliers.length;i++) {
                                app.$store.state.supplierIds.push(app.$store.state.suppliers[i]['id']);
                            }
                        }
                    });
            }
            if (app.$store.state.categories.length <= 0) {
                axios
                    .get("/api/getCategory")
                    .then(response => {
                        if (response && response.data) {
                            app.$store.state.categories = response.data;
                            for (let i=0;i<app.$store.state.categories.length;i++) {
                                app.$store.state.categoryIds.push(app.$store.state.categories[i]['id']);
                            }
                        }
                    });
            }
        },
    }
</script>
<style lang="scss" scoped>
    @import "../layouts/css/customvariables";
    .home-content {
        padding: 25px 55px 60px 60px;
        border-top: 2px solid $border_color;
        h1 {
            color: $title_color;
        }
    }
</style>
