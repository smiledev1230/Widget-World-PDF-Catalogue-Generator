<template>
    <div class="catalogue-content">
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
                                    <div class="col-md-5 text-right pr-2">
                                        <div class="pb-2">Display Products by:</div>
                                        <div class="pb-2">Page Columns:</div>
                                        <div class="pb-2">Display Brand Logos:</div>
                                    </div>
                                    <div class="col-md-7 nopadding">
                                        <div class="pb-1 pt-1">
                                            <input type="checkbox" class="checkbox-inout ml-3"> Suppliers
                                            <input type="checkbox" class="checkbox-inout ml-3"> Categories
                                        </div>
                                        <div class="pb-1 pt-1">
                                            <input type="checkbox" class="checkbox-inout ml-3"> 2
                                            <input type="checkbox" class="checkbox-inout ml-3"> 3
                                        </div>
                                        <div class="pb-1 pt-1">
                                            <input type="checkbox" class="checkbox-inout ml-3"> Yes
                                            <input type="checkbox" class="checkbox-inout ml-3"> No
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 nopadding">
                                <div class="pb-2">Product Display Options:</div>
                                <div class="pb-1 pt-1">
                                    <div class="row ml-3">
                                        <div class="col-4 nopadding">
                                            <input type="checkbox" class="checkbox-inout"> Title
                                        </div>
                                        <div class="col-4 nopadding">
                                            <input type="checkbox" class="checkbox-inout"> RRP
                                        </div>
                                        <div class="col-4 nopadding">
                                            <input type="checkbox" class="checkbox-inout"> Units Per Outer
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-1 pt-1">
                                    <div class="row ml-3">
                                        <div class="col-4 nopadding">
                                            <input type="checkbox" class="checkbox-inout"> Barcode #
                                        </div>
                                        <div class="col-4 nopadding">
                                            <input type="checkbox" class="checkbox-inout"> Barcode Image
                                        </div>
                                    </div>
                                </div>
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
                <treeView :showCheck="showCheck"/>
                <a class="btn greenBgColor pull-right text-white mt-3" @click="updateCatalogue">UPDATE</a>
            </div>
            <div class="col-9 pr-0">
                <div class="content-right">
                    <productList />
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
    import treeView from "../plugins/treeView/treeView";
    import productList from "./product_list";

    export default {
        name: "build_catalogue",
        components: {
            'treeView': treeView,
            'productList': productList
        },
        data() {
            return {
                showCollapse: false,
                showCheck: false,
            }
        },
        mounted: function () {
            this.$store.state.page_text = "Add your selected products and product ranges into your Catalogue.";
            this.$store.state.page_subText = "You can display them grouped in Suppliers or Categories and customise the order if required or display alphabetically as default.";
        },
        methods: {
            saveProducts() {
                console.log("saveProducts");
            },
            updateOptions() {
                console.log("updateOptions");
            },
            updateCatalogue() {
                console.log("updateOptions");
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "../layouts/css/customvariables";
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
