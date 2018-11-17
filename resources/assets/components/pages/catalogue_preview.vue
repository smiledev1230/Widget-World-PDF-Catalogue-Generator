<template>
    <div class="catalogue-content">
        <div class="content-body">
            <product-preview :productData="$store.state.productData"/>
        </div>
        <div class="content-bottom">
            <hr/>
            <div class="row d-block">
                <router-link tag="a" to="/build_catalogue" exact class="btn btn-secondary text-white">BACK</router-link>
                <a class="btn greenBgColor pull-right text-white" @click="sendPDF">SEND AS PDF</a>
                <a class="btn btn-secondary pull-right text-white mr-3" @click="savePreview">SAVE FOR LATER</a>
            </div>
        </div>
    </div>
</template>
<script>
    import productPreview from "./product_preview";

    export default {
        name: "catalogue_preview",
        components: {
            'product-preview': productPreview
        },
        data() {
            return {}
        },
        mounted: function () {
            this.$store.state.page_text = "Preview how your catalogue is going to look and send it as a PDF.";
            this.$store.state.page_subText = "You can always save it for later and come back to it when you are ready to send.";
        },
        methods: {
            savePreview() {
                console.log("savePreview");
            },
            sendPDF() {
                console.log("sendPDF");
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "../layouts/css/customvariables";
    .catalogue-content {
        .content-body {
            background: $row_even_color;
            border: 2px solid $border_color;
            min-height: 56vh;
            padding: 15px 40px;
            .product-list {
                min-height: 45vw;
                .product-body {
                    min-height: calc(45vw - 50px);
                }
            }
        }
    }
</style>
