<template>
    <div class="catalogue-content">
        <hr/>
        <div class="row d-block">
            <router-link tag="a" to="/" exact class="btn btn-secondary text-white">CANCEL</router-link>
            <router-link tag="a" to="/select_products" exact class="btn btn-secondary back-btn text-white">BACK</router-link>
            <router-link tag="a" to="/catalogue_preview" exact class="btn greenBgColor pull-right text-white">NEXT</router-link>
            <a class="btn btn-secondary pull-right text-white mr-3" @click="saveProducts">SAVE FOR LATER</a>
        </div>
    </div>
</template>
<script>
    export default {
        name: "build_catalogue",
        components: {
        },
        data() {
            return {}
        },
        mounted: function () {
            this.$store.state.page_text = "Add your selected products and product ranges into your Catalogue.";
            this.$store.state.page_subText = "You can display them grouped in Suppliers or Categories and customise the order if required or display alphabetically as default.";
        },
        methods: {
            saveProducts() {
                console.log("saveProducts");
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "../layouts/css/customvariables";
    .catalogue-content {

    }
</style>
