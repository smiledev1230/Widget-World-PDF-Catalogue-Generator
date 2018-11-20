<template>
    <div class="row home-content border-top">
        <h1>Recent Catalogues</h1>
        <div class="w-100 pt-3">
            <CatalgoueList></CatalgoueList>
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
