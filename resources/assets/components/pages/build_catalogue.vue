<template>
    <div class="catalogue-content mt-2">
        <div class="visual-options">
            <div class="row d-block" @click="showCollapse = !showCollapse">
                <label class="mb-0">Visual Options</label>
                <i aria-controls="vOptions"
                   :aria-expanded="showCollapse ? 'true' : 'false'"
                   class="collapse-btn pull-right fa" :class="showCollapse ? 'fa-angle-down' : 'fa-angle-up'">
                </i>
            </div>
            <b-collapse id="vOptions" v-model="showCollapse" class="mt-2">
                <div class="row">
                    <div class="col-md-6 nopadding">
                        <div class="row">
                            <div class="col-md-5 text-right pr-2 options-label">
                                <div class="pb-2">Display Products by:</div>
                                <div class="pb-2">Page Columns:</div>
                                <div class="pb-2">Display Brand Logos:</div>
                            </div>
                            <div class="col-md-7 pr-0">
                                <b-form-group>
                                    <b-form-radio-group v-model="$store.state.catalogue.display_type" :options="display_type" @change="setProduct" />
                                    <b-form-radio-group v-model="$store.state.catalogue.page_columns" :options="page_columns" @change="updatePage" />
                                    <b-form-radio-group v-model="$store.state.catalogue.logos_options" :options="logos_options" @change="updateProduct"/>
                                </b-form-group>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 nopadding">
                        <b-form-group label="Product Display Options:" class="mb-0 pl-3">
                            <b-form-checkbox-group plain v-model="$store.state.catalogue.display_options" :options="display_options" class="pl-3" />
                            <b-form-radio-group v-model="$store.state.catalogue.barcode_options" :options="barcode_options" class="pl-3" />
                        </b-form-group>
                    </div>
                </div>
            </b-collapse>
        </div>
        <div class="content-main row mt-4">
            <div class="col-3 nopadding">
                <div class="tree-view">
                    <ejs-treeview
                            v-if='$store.state.catalogue.display_type'
                            id='supplierTree'
                            :fields='supplierFields'
                            allowDragAndDrop='true'
                            :nodeDragStop='supplierDragStop'>
                    </ejs-treeview>
                    <ejs-treeview
                            v-else
                            id='categoryTree'
                            :fields="categoryFields"
                            allowDragAndDrop='true'
                            :nodeDragStop='catalogueDragStop'>
                    </ejs-treeview>
                </div>
                <a class="btn greenBgColor pull-right text-white mt-3" @click="saveProducts">UPDATE</a>
            </div>
            <div class="col-9 pr-0">
                <div class="content-right">
                    <productList :totalPages="totalPages"/>
                </div>
            </div>
        </div>
        <div class="content-bottom">
            <hr/>
            <div class="row d-block">
                <router-link tag="a" to="/" exact class="btn btn-secondary text-white">CANCEL</router-link>
                <router-link tag="a" to="/select_products" exact class="btn btn-secondary back-btn text-white">BACK</router-link>
                <router-link tag="a" to="/catalogue_preview" exact class="btn greenBgColor pull-right text-white">NEXT</router-link>
                <a class="btn blueBgColor pull-right text-white mr-3" @click="saveProducts">SAVE FOR LATER</a>
            </div>
        </div>
        <save-modal :showStatus.sync="showStatus" />
    </div>
</template>
<script>
    import Vue from 'vue';
    import { TreeViewPlugin } from "@syncfusion/ej2-vue-navigations";
    Vue.use(TreeViewPlugin);
    import productList from "./product_list";
    import saveModal from "./save_modal";

    export default {
        name: "build_catalogue",
        components: {
            'productList': productList,
            'save-modal': saveModal
        },
        data() {
            let supplierList = this.getSupplierList();
            let categoryList = this.getCategoryList();
            this.$store.state.productData = this.$store.state.catalogue.display_type ? this.getProductData(supplierList): this.getProductData(categoryList);
            let total_pages = Math.round(this.$store.state.productData.length/3/this.$store.state.catalogue.page_columns + 0.5);
            return {
                showCollapse: false,
                showCheck: false,
                totalPages: total_pages,
                categories: [],
                showStatus: false,
                supplierList: [],
                categoryList: [],
                supplierFields: {
                    dataSource: supplierList,
                    id: 'id',
                    parentID: 'pid',
                    text: 'name',
                    hasChildren: 'hasChild'
                },
                categoryFields: {
                    dataSource: categoryList,
                    id: 'id',
                    parentID: 'pid',
                    text: 'name',
                    hasChildren: 'hasChild'
                },
                display_type: [
                    { text: 'Suppliers', value: 1 },
                    { text: 'Categories', value: 0 },
                ],
                page_columns: [
                    { text: '2', value: '2' },
                    { text: '3', value: '3' },
                ],
                logos_options: [
                    { text: 'Yes', value: 1 },
                    { text: 'No', value: 0, disabled: false },
                ],
                display_options: [
                    {text: 'Title', value: 'title'},
                    {text: 'RRP', value: 'rrp'},
                    {text: 'Units Per Outer', value: 'units'},
                ],
                barcode_options: [
                    {text: 'Barcode #', value: 0},
                    {text: 'Barcode Image', value: 1, disabled: true},
                ]
            }
        },
        mounted: function () {
            if (!this.$store.state.user.id) this.$router.push("/login");
            this.$store.state.page_text = "Add your selected products and product ranges into your Catalogue.";
            this.$store.state.page_subText = "You can display them grouped in Suppliers or Categories and customise the order if required or display alphabetically as default.";
            if (this.$store.state.catalogue.page_columns == 2 && this.$store.state.catalogue.barcode_options) {
                this.barcode_options[1]['disabled'] = false;
            }
            if (!this.$store.state.supplierBrand) this.$store.state.supplierBrand = require('../../assets/img/products/empty.jpg');
        },
        methods: {
            getSupplierList() {
                let stateData = this.$store.state;
                let supplierList = [];
                let supplier;
                for (let i=0;i<stateData.suppliers.length;i++) {
                    supplier = stateData.suppliers[i];
                    if (stateData.suppliers_ids.indexOf(supplier['id']) >= 0) {
                        if (supplier['brandLogo']) stateData.supplierBrand = supplier['brandLogo'];
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
                        dragRow = productData[dragId];
                        productData.splice(dragId, 1);
                        productIds.splice(dragId, 1);
                        dropId = productIds.indexOf(drag_ids[k+1]);
                        productData.splice(dropId, 0, dragRow);
                        productIds.splice(dropId, 0, drag_ids[k]);
                    }
                }
                return productData;
            },
            saveProducts() {
                console.log("saveProducts");
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
                formData.append('saved_page', 'build_catalogue');
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
            updateOptions() {
                console.log("updateOptions", this.$store.state.catalogue);
            },
            updateCatalogue() {
                console.log("updateOptions");
            },
            updateProduct(e) {
                this.$store.state.catalogue.logos_options = e;
                let supplierList = this.getSupplierList();
                let categoryList = this.getCategoryList();
                this.$store.state.productData = this.$store.state.catalogue.display_type ? this.getProductData(supplierList): this.getProductData(categoryList);
            },
            updatePage(e) {
                this.totalPages = Math.round(this.$store.state.productData.length/3/e + 0.5);
                if (e == 2) {
                    this.barcode_options[1]['disabled'] = false;
                } else {
                    this.barcode_options[1]['disabled'] = true;
                    this.$store.state.catalogue.barcode_options = 0;
                }
            },
            setProduct(e) {
                let productList = '';
                if (e) {
                    productList = this.getSupplierList();
                    this.logos_options[1]['disabled'] = false;
                } else {
                    productList = this.getCategoryList();
                    this.logos_options[1]['disabled'] = true;
                    this.$store.state.catalogue.logos_options = 0;
                }
                this.$store.state.productData = this.getProductData(productList);
                this.totalPages = Math.round(this.$store.state.productData.length/3/this.$store.state.catalogue.page_columns + 0.5);
            },
            catalogueDragStop: function(args) {
                let dragNode = args.draggedNodeData;
                let dropNode = args.droppedNodeData;
                let categoryIndex = this.$store.state.categoryIds.indexOf(dragNode.id);
                if ((categoryIndex>= 0 && this.$store.state.categories[categoryIndex]['hasChild'])
                    || (dragNode.parentID != dropNode.parentID)) {
                    args.cancel = true;
                    return;
                } else {
                    let old_new = this.$store.state.category_new;
                    this.$store.state.drag_category_ids.push(dragNode.id);
                    this.$store.state.drag_category_ids.push(dropNode.id);
                    this.$store.state.category_new = old_new;
                    this.$store.state.productData = this.getProductData(this.getCategoryList());
                }
            },
            supplierDragStop: function(args) {
                let dragNode = args.draggedNodeData;
                let dropNode = args.droppedNodeData;
                let categoryIndex = this.$store.state.supplierIds.indexOf(dragNode.id);
                if ((categoryIndex>= 0 && this.$store.state.suppliers[categoryIndex]['hasChild'])
                    || (dragNode.parentID != dropNode.parentID)) {
                    args.cancel = true;
                    return;
                } else {
                    let old_new = this.$store.state.supplier_new;
                    this.$store.state.drag_supplier_ids.push(dragNode.id);
                    this.$store.state.drag_supplier_ids.push(dropNode.id);
                    this.$store.state.supplier_new = old_new;
                    this.$store.state.productData = this.getProductData(this.getSupplierList());
                }
            },
        }
    }
</script>
<style lang="scss" scoped>
    @import "../layouts/css/customvariables";
    @import "../../assets/css/ej2-base-material.css";
    @import "../../assets/css/ej2-vue-navigations-material.css";
    @import "../../assets/css/ej2-buttons-material.css";
    .tree-view {
        .e-treeview {
            height: 408px;
            max-height: 420px;
            border: 1px solid $border_color;
            overflow-y: scroll;
        }
        .e-treeview > .e-list-parent.e-ul {
            padding-left: 0;
        }
    }
    .catalogue-content {
        .visual-options {
            background: $grey_bgColor;
            padding: 10px 15px;
            .row.d-block {
                cursor: pointer;
            }
            .collapse-btn {
                padding: 0 10px;
                background: no-repeat;
                border: 0;
                color: $angle_color;
                font-size: 22px;
                cursor: pointer;
            }
            .options-btn {
                position: absolute;
                right: 18px;
                bottom: 8px;
            }
            .options-label {
                font-size: 13.5px;
            }
        }
        .content-main {
            .content-right {
                width: 100%;
                height: 100%;
                padding: 15px;
                background: $row_even_color;
                border: 1px solid $border_color;
            }
        }
    }
</style>
