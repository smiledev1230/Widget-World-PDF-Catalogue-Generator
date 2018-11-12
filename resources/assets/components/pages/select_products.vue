<template>
    <div class="page-content">
        <hr/>
        <div class="row d-block">
            <router-link tag="a" to="/" class="btn btn-secondary text-white">CANCEL</router-link>
            <router-link tag="a" to="/new_catalogue" class="btn btn-secondary text-white">BACK</router-link>
            <router-link tag="a" to="/select_products" class="btn greenBgColor pull-right text-white">NEXT</router-link>
            <router-link tag="a" to="/select_products" class="btn btn-secondary pull-right text-white">SAVE FOR LATER</router-link>
        </div>
    </div>
</template>
<script>
    export default {
        name: "selectProducts",
        components: {
        },
        data() {
            return {}
        },
        mounted: function () {
            this.$store.state.page_text = "Select the products to be displayed in your catalogue. You can choose a complete range from single or multiple Suppliers, single or multiple categories or indivudal products. On the next\n" +
                "screen you can insert these products into your pages.";
        },
        methods: {

        }
    }
</script>
<style lang="scss" scoped>
    @import "../layouts/css/customvariables";
    .page-content {
        .row {
            margin: 0;
        }
    }
</style>
