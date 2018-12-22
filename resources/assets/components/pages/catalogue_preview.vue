<template>
    <div>
        <spinner v-show="$store.state.preloader"></spinner>
        <div class="catalogue-content preview-content">
            <div class="download-pdf">
                <b-btn type="button" aria-label="Download" class="btn blueBgColor pull-right text-white" @click="downloadPDF"><i class="fa fa-download" aria-hidden="true"></i>DOWNLOAD PDF</b-btn>
            </div>
            <div class="content-body">
                <product-preview :catalogue="$store.state.catalogue" :productData.sync="$store.state.productData" :totalPages="totalPages"/>
            </div>
            <div class="content-bottom">
                <hr/>
                <div class="row d-block">
                    <router-link tag="a" to="/build_catalogue" exact class="btn btn-secondary text-white">BACK</router-link>
                    <a class="btn greenBgColor pull-right text-white"  @click="openSendModal()">SEND AS PDF</a>
                    <a class="btn blueBgColor pull-right text-white mr-3" @click="saveCatalogue">SAVE FOR LATER</a>
                </div>
            </div>
            <catalogue-send :catalogue="old_catalogue" :catalogueSend.sync="catalogueSend" :limited="-1"/>
        </div>
        <save-modal :showStatus.sync="showStatus" />
    </div>
</template>
<script>
    import Vue from 'vue';
    import VueForm from "vue-form";
    import options from "src/validations/validations.js";
    Vue.use(VueForm, options);

    import Spinner from "../layouts/spinner";
    import productPreview from "./product_preview";
    import catalogueSend from "./catalogue_send";
    import saveModal from "./save_modal";
    import { coverImages } from '../../assets/js/global_variable';

    export default {
        name: "catalogue_preview",
        components: {
            'product-preview': productPreview,
            'catalogue-send': catalogueSend,
            'save-modal': saveModal,
            'spinner':Spinner,
        },
        data() {
            if (this.$store.state.productData.length == 0) {
                let supplierList = this.getSupplierList();
                let categoryList = this.getCategoryList();
                this.$store.state.productData = this.$store.state.catalogue.display_type ? this.getProductData(supplierList): this.getProductData(categoryList);
            }
            let total_pages = Math.round(this.$store.state.productData.length/3/this.$store.state.catalogue.page_columns + 0.5);
            return {
                sendModal: false,
                old_catalogue: {},
                catalogueSend: false,
                showStatus: false,
                totalPages: total_pages,
                imageList : coverImages,
            }
        },
        mounted: function () {
            if (!this.$store.state.user.id) this.$router.push("/login");
            this.$store.state.page_text = "Preview how your catalogue is going to look and send it as a PDF.";
            this.$store.state.page_subText = "You can always save it for later and come back to it when you are ready to send.";
            this.$store.state.preloader = false;
        },
        methods: {
            getSupplierList() {
                let stateData = this.$store.state;
                let supplierList = [];
                let supplier;
                for (let i=0;i<stateData.suppliers.length;i++) {
                    supplier = stateData.suppliers[i];
                    if (stateData.suppliers_ids.indexOf(supplier['id']) >= 0) {
                        supplierList.push(supplier);
                    }
                }
                return supplierList;
            },
            getCategoryList() {
                let stateData = this.$store.state;
                let categoryList = [];
                let category;
                for (let i=0;i<stateData.categories.length;i++) {
                    category = stateData.categories[i];
                    if (stateData.categories_ids.indexOf(category['id']) >= 0) {
                        categoryList.push(category);
                    }
                }
                return categoryList;
            },
            getProductData(allProduct) {
                let type = this.$store.state.catalogue.display_type;
                let stateData = this.$store.state;
                let productData = [];
                let productIds = [];
                let product_new, product_block, drag_ids;
                if (type) {
                    product_new = stateData.supplier_new;
                    product_block = stateData.supplier_block;
                    drag_ids = stateData.drag_supplier_ids;
                } else {
                    product_new = stateData.category_new;
                    product_block = stateData.category_block;
                    drag_ids = stateData.drag_category_ids;
                }
                for (let i=0;i<allProduct.length;i++) {
                    if (stateData.catalogue.logos_options && allProduct[i]['hasChild'] && allProduct[i]['brandLogo']) {
                        let logo_id = new Date().getTime();
                        productIds.push(logo_id);
                        let newBlock = {
                            id: logo_id,
                            name: 'Supplier Brand',
                            images: allProduct[i]['brandLogo'],
                            type: 'logo'
                        }
                        productData.push(newBlock);
                    }
                    if (!allProduct[i]['hasChild']) {
                        productIds.push(allProduct[i]['id']);
                        if (product_new && product_new.indexOf(allProduct[i]['id'])>=0) {
                            allProduct[i]['product_is_new'] = true;
                        } else {
                            allProduct[i]['product_is_new'] = false;
                        }
                        allProduct[i]['rrp'] = Number.parseFloat(allProduct[i]['rrp']).toFixed(2);
                        productData.push(allProduct[i]);
                    }
                }
                if (product_block && product_block.length>0) {
                    let p=0;
                    for (let j=0;j<product_block.length;j++) {
                        if (productIds.indexOf(product_block[j]['id'])>=0) {
                            let newBlock = {
                                id: new Date().getTime(),
                                name: product_block[j]['name'],
                                type: 'block'
                            }
                            productData.splice(productIds.indexOf(product_block[j]['id'])+p, 0, newBlock);
                            p++;
                        }
                    }
                }
                if (drag_ids && drag_ids.length > 0) {
                    let dragId, dragRow, dropId;
                    for (let k=0; k<drag_ids.length;k+=2) {
                        dragId = productIds.indexOf(drag_ids[k]);
                        dropId = productIds.indexOf(drag_ids[k+1]);
                        if (dragId >= 0 && dropId >= 0) {
                            dragRow = productData[dragId];
                            productData.splice(dragId, 1);
                            productIds.splice(dragId, 1);
                            productData.splice(dropId, 0, dragRow);
                            productIds.splice(dropId, 0, drag_ids[k]);
                        }
                    }
                }
                return productData;
            },
            savePDF() {
                console.log("savePDF");
                let formData = new FormData();
                let storeData = this.$store.state;
                formData.append('name', storeData.catalogue.name);
                formData.append('brand_path', this.imageList[storeData.catalogue.selectedImage]);
                if (storeData.catalogue.file_upload_path) formData.append('logo_path', storeData.catalogue.file_upload_path);
                formData.append('productData', JSON.stringify(storeData.productData));
                formData.append('page_columns', storeData.catalogue.page_columns);
                formData.append('display_options', storeData.catalogue.display_options);
                formData.append('barcode_options', storeData.catalogue.barcode_options);
                let totalPages = Math.round(storeData.productData.length/3/storeData.catalogue.page_columns + 0.5);
                formData.append('pages', totalPages);

                axios.post( '/api/savePDF',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(response => {
                    console.log("response", response);
                }).catch(e=>{

                });
            },
            openSendModal() {
                this.old_catalogue = {
                    name: this.$store.state.catalogue.name,
                };
                this.catalogueSend = true;
            },
            saveCatalogue() {
                let formData = new FormData();
                let storeData = this.$store.state;
                if (storeData.catalogue.id) formData.append('id', storeData.catalogue.id);
                formData.append('user_id', storeData.user.id);
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
                formData.append('drag_supplier_ids', storeData.drag_supplier_ids);
                formData.append('drag_category_ids', storeData.drag_category_ids);
                formData.append('saved_page', 'catalogue_preview');
                formData.append('state', '0');
                if (storeData.supplier_block.length>0) formData.append('supplier_block', JSON.stringify(storeData.supplier_block));
                if (storeData.category_block.length>0) formData.append('category_block', JSON.stringify(storeData.category_block));
                if (storeData.supplier_new.length>0) formData.append('supplier_new', storeData.supplier_new);
                if (storeData.category_new.length>0) formData.append('category_new', storeData.category_new);

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
                    if (response.data && response.data.id)
                        app.$store.state.catalogue.id = response.data.id;
                    app.showStatus = true;
                }).catch(function(){
                    console.log('FAILURE!!');
                });
            },
            downloadPDF() {
                console.log("downloadPDF: ");
                this.$store.state.preloader = true;
                let formData = new FormData();
                let storeData = this.$store.state;
                formData.append('name', storeData.catalogue.name);
                formData.append('brand_path', this.imageList[storeData.catalogue.selectedImage]);
                if (storeData.catalogue.file_upload_path) formData.append('logo_path', storeData.catalogue.file_upload_path);
                formData.append('productData', JSON.stringify(storeData.productData));
                formData.append('page_columns', storeData.catalogue.page_columns);
                formData.append('display_options', storeData.catalogue.display_options);
                formData.append('barcode_options', storeData.catalogue.barcode_options);
                let totalPages = Math.round(storeData.productData.length/3/storeData.catalogue.page_columns + 0.5);
                formData.append('pages', totalPages);
                formData.append('download_pdf', '1');

                axios.post( '/api/savePDF',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        responseType: 'blob'
                    }
                ).then(response => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', storeData.catalogue.name+'.pdf');
                    document.body.appendChild(link);
                    link.click();
                    this.$store.state.preloader = false;
                }).catch(e=>{
                    this.$store.state.preloader = false;
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
        .download-pdf {
            position: absolute;
            top: -45px;
            right: 0px;
            .fa-download {
                margin-right: 5px;
            }
        }
    }
</style>
