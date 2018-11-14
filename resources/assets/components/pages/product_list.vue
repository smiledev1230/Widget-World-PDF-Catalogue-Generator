<template>
    <div class="product-list">
        {{$store.state.catalogue.name}}
    </div>
</template>
<script>
    export default {
        name: "product_list",
        components: {
        },
        data() {
            return {}
        },
        mounted: function () {
        },
        methods: {

        }
    }
</script>
<style lang="scss" scoped>
    @import "../layouts/css/customvariables";
    .product-list {

    }
</style>
