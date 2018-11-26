<template>
    <div class="catalogue-content mt-2">
        <div class="visual-options">
            <div class="row d-block">
                <label class="mb-0">Visual Options</label>
                <i @click="showCollapse = !showCollapse"
                   aria-controls="vOptions"
                   :aria-expanded="showCollapse ? 'true' : 'false'"
                   class="collapse-btn pull-right fa" :class="showCollapse ? 'fa-angle-down' : 'fa-angle-up'">
                </i>
            </div>
            <b-collapse id="vOptions" v-model="showCollapse" class="mt-2">
                <div class="row">
                    <div class="col-md-10">
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
                                            <b-form-radio-group v-model="$store.state.catalogue.display_type" :options="display_type" />
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
                    </div>
                    <div class="col-md-2">
                        <a class="btn greenBgColor pull-right text-white options-btn" @click="updateOptions">UPDATE</a>
                    </div>
                </div>
            </b-collapse>
        </div>
        <div class="content-main row mt-4">
            <div class="col-3 nopadding">
                <div class="tree-view">
                    <ejs-treeview id='treeview' :fields="fields" allowDragAndDrop='true'></ejs-treeview>
                </div>
                <a class="btn greenBgColor pull-right text-white mt-3" @click="updateCatalogue">UPDATE</a>
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
                <a class="btn btn-secondary pull-right text-white mr-3" @click="saveProducts">SAVE FOR LATER</a>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';
    import { TreeViewPlugin } from "@syncfusion/ej2-vue-navigations";
    Vue.use(TreeViewPlugin);
    import productList from "./product_list";
    export default {
        name: "build_catalogue",
        components: {
            'productList': productList,
        },
        data() {
            this.$store.state.productData = this.getProductData();
            let total_pages = Math.round(this.$store.state.productData.length/3/this.$store.state.catalogue.page_columns + 0.5);
            return {
                showCollapse: false,
                showCheck: false,
                totalPages: total_pages,
                categories: [],
                fields: {
                    dataSource: this.$store.state.categories,
                    id: 'id',
                    parentID: 'pid',
                    text: 'name',
                    hasChildren: 'hasChild'
                },
                display_type: [
                    { text: 'Suppliers', value: true },
                    { text: 'Categories', value: false },
                ],
                page_columns: [
                    { text: '2', value: '2' },
                    { text: '3', value: '3' },
                ],
                logos_options: [
                    { text: 'Yes', value: true },
                    { text: 'No', value: false },
                ],
                display_options: [
                    {text: 'Title', value: 'title'},
                    {text: 'RRP', value: 'rrp'},
                    {text: 'Units Per Outer', value: 'units'},
                ],
                barcode_options: [
                    {text: 'Barcode #', value: false},
                    {text: 'Barcode Image', value: true},
                ]
            }
        },
        mounted: function () {
            this.$store.state.page_text = "Add your selected products and product ranges into your Catalogue.";
            this.$store.state.page_subText = "You can display them grouped in Suppliers or Categories and customise the order if required or display alphabetically as default.";
            // if (this.$store.state.catalogue.logosOptions && this.$store.state.productData[0]['type'] != 'logo') this.updateProduct(true);
            console.log("store.state", this.$store.state);
        },
        methods: {
            getProductData() {
                let productData = [];
                let categoryData = this.$store.state.categories;
                for (let i=0;i<categoryData.length;i++) {
                    if (categoryData[i]['product']) {
                        productData.push(categoryData[i]);
                    }
                }
                return productData;
            },
            saveProducts() {
                console.log("saveProducts");
            },
            updateOptions() {
                console.log("updateOptions", this.$store.state.catalogue);
            },
            updateCatalogue() {
                console.log("updateOptions");
            },
            updateProduct(e) {
                console.log("updateProduct", e);
                if (e) {
                    let newBlock = {
                        id: new Date().getTime(),
                        name: null,
                        image: 'Arnotts-Logo.jpg',
                        type: 'logo'
                    }
                    this.$store.state.productData.splice(0, 0, newBlock);
                } else {
                    this.$store.state.productData.splice(0,1);
                }
            },
            updatePage(e) {
                this.totalPages = Math.round(this.$store.state.productData.length/3/e + 0.5);
            }
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
