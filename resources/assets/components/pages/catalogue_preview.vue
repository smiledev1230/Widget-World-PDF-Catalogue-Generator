<template>
    <div class="catalogue-content preview-content">
        <div class="content-body">
            <product-preview :productData="$store.state.productData"/>
        </div>
        <div class="content-bottom">
            <hr/>
            <div class="row d-block">
                <router-link tag="a" to="/build_catalogue" exact class="btn btn-secondary text-white">BACK</router-link>
                <a class="btn greenBgColor pull-right text-white"  @click="openSendModal()">SEND AS PDF</a>
                <a class="btn btn-secondary pull-right text-white mr-3" @click="savePreview">SAVE FOR LATER</a>
            </div>
        </div>
        <catalogue-send :catalogue="old_catalogue" :catalogueSend.sync="catalogueSend"/>
    </div>
</template>
<script>
    import Vue from 'vue';
    import VueForm from "vue-form";
    import options from "src/validations/validations.js";
    Vue.use(VueForm, options);
    import productPreview from "./product_preview";
    import catalogueSend from "./catalogue_send";

    export default {
        name: "catalogue_preview",
        components: {
            'product-preview': productPreview,
            'catalogue-send': catalogueSend,
        },
        data() {
            return {
                sendModal: false,
                old_catalogue: {},
                catalogueSend: false,
            }
        },
        mounted: function () {
            this.$store.state.page_text = "Preview how your catalogue is going to look and send it as a PDF.";
            this.$store.state.page_subText = "You can always save it for later and come back to it when you are ready to send.";
        },
        methods: {
            savePreview() {
                console.log("savePreview");
            },
            openSendModal() {
                this.old_catalogue = {
                    title: this.$store.state.catalogue.name,
                };
                this.catalogueSend = true;
            },
        }
    }
</script>
<style lang="scss">
    @import "../layouts/css/customvariables";
    .preview-content {
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
