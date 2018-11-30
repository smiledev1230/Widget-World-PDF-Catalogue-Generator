<template>
    <div>
        <div v-if="$store.state.preloader" class="loader-section">
            <vue-simple-spinner size="medium" />
        </div>
        <div class="catalogue-content preview-content">
            <div class="content-body">
                <product-preview :catalogue="$store.state.catalogue" :productData.sync="$store.state.productData" :totalPages="totalPages"/>
            </div>
            <div class="content-bottom">
                <hr/>
                <div class="row d-block">
                    <router-link tag="a" to="/build_catalogue" exact class="btn btn-secondary text-white">BACK</router-link>
                    <a class="btn greenBgColor pull-right text-white"  @click="openSendModal()">SEND AS PDF</a>
                    <a class="btn btn-secondary pull-right text-white mr-3" @click="savePDF">SAVE FOR LATER</a>
                </div>
            </div>
            <catalogue-send :catalogue="old_catalogue" :catalogueSend.sync="catalogueSend"/>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';
    import VueForm from "vue-form";
    import options from "src/validations/validations.js";
    Vue.use(VueForm, options);

    import Spinner from 'vue-simple-spinner'
    import productPreview from "./product_preview";
    import catalogueSend from "./catalogue_send";

    export default {
        name: "catalogue_preview",
        components: {
            'product-preview': productPreview,
            'catalogue-send': catalogueSend,
            'vue-simple-spinner':Spinner,
        },
        data() {
            let total_pages = Math.round(this.$store.state.productData.length/3/this.$store.state.catalogue.page_columns + 0.5);
            return {
                sendModal: false,
                old_catalogue: {},
                catalogueSend: false,
                totalPages: total_pages
            }
        },
        mounted: function () {
            this.$store.state.page_text = "Preview how your catalogue is going to look and send it as a PDF.";
            this.$store.state.page_subText = "You can always save it for later and come back to it when you are ready to send.";
            this.$store.state.preloader = false;
        },
        methods: {
            savePDF() {
                console.log("savePDF");
                let totalPages = Math.round(this.$store.state.productData.length/3/this.$store.state.catalogue.page_columns + 0.5);
                let params = {
                    fileName: this.$store.state.catalogue.name,
                    productData: this.$store.state.productData,
                    page_columns: this.$store.state.catalogue.page_columns,
                    display_options: this.$store.state.catalogue.display_options,
                    barcode_options: this.$store.state.catalogue.barcode_options,
                    pages: totalPages,

                }
                let app = this;
                app.$store.state.preloader = true;
                axios.post("/api/savePDF", params).then(response => {
                    console.log("response", response);
                    app.$store.state.preloader = false;
                    app.saveCatalogue(response);
                }).catch(e=>{
                    app.$store.state.preloader = false;
                });
            },
            openSendModal() {
                this.old_catalogue = {
                    title: this.$store.state.catalogue.name,
                };
                this.catalogueSend = true;
            },
            saveCatalogue(pdf_path) {
                let formData = new FormData();
                let storeData = this.$store.state;
                if (storeData.catalogue.id) formData.append('id', storeData.catalogue.id);
                formData.append('name', storeData.catalogue.name);
                if (storeData.catalogue.file_name) formData.append('logo_name', storeData.catalogue.file_name);
                if (storeData.catalogue.file_upload_path) formData.append('logo_url', storeData.catalogue.file_upload_path);
                formData.append('cover_index', storeData.catalogue.selectedImage);
                formData.append('suppliers',storeData.sel_supplier_ids);
                formData.append('categories', storeData.sel_category_ids);
                formData.append('display_type', storeData.catalogue.display_type);
                formData.append('page_columns', storeData.catalogue.page_columns);
                formData.append('logos_options', storeData.catalogue.logos_options);
                formData.append('display_options', storeData.catalogue.display_options);
                formData.append('barcode_options', storeData.catalogue.barcode_options);
                formData.append('pdf_path', pdf_path);
                formData.append('state', '1');
                if (storeData.blocks.length>0) formData.append('blocks', JSON.stringify(storeData.blocks));
                if (storeData.product_new.length>0) formData.append('product_new', storeData.product_new);

                let app = this;
                axios.post( '/api/saveSelectProduct',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(response => {
                    console.log('success!!', response);
                    app.$router.push("/");
                }).catch(function(){
                    console.log('FAILURE!!');
                });
            }
        }
    }
</script>
<style lang="scss">
    @import "../layouts/css/customvariables";
    .loader-section {
        position: absolute;
        top: 65px;
        right: 75px;
        z-index: 9999;
    }
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
