<template>
    <div class="catalogue-content">
        <div class="select-products">
            <b-tabs v-model="tabIndex" vertical>
                <b-tab title="Suppliers">
                    <div class="tree-view">
                        <ejs-treeview id='supplierTree' :fields="setSupplierFields" showCheckBox="true" :nodeChecked='supplierChecked'></ejs-treeview>
                    </div>
                </b-tab>
                <b-tab title="Categories" @click="selectCategory">
                    <div class="tree-view">
                        <ejs-treeview id='categoryTree' :fields="setCatFields" showCheckBox="true" :nodeChecked='categoryChecked'></ejs-treeview>
                    </div>
                </b-tab>
            </b-tabs>
        </div>
        <div class="content-bottom">
            <hr/>
            <div class="row d-block">
                <router-link tag="a" to="/new_catalogue" exact class="btn btn-secondary text-white">CANCEL</router-link>
                <router-link tag="a" to="/new_catalogue" exact class="btn btn-secondary back-btn text-white">BACK</router-link>
                <router-link tag="a" to="/build_catalogue" exact class="btn greenBgColor pull-right text-white">NEXT</router-link>
                <a class="btn btn-secondary pull-right text-white mr-3" @click="saveProducts">SAVE FOR LATER</a>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';
    import { TreeViewPlugin } from "@syncfusion/ej2-vue-navigations";
    Vue.use(TreeViewPlugin);
    export default {
        name: "select_products",
        components: {
        },
        data() {
            return {
                tabIndex: 0,
                showCheck: true,
                suppliers: [],
                categories: [],
                categoryIds: [],
                checkedCategories: [],
            }
        },
        mounted: function () {
            this.$store.state.page_text = "Select the products to be displayed in your catalogue. You can choose a complete range from single or multiple Suppliers, single or multiple categories or indivudal products. On the next screen you can insert these products into your pages.";
            let app = this;
            axios
                .get("/api/getSupplier")
                .then(response => {
                    app.suppliers = [];
                    if (response && response.data) {
                        app.suppliers = response.data;
                    }
                });
            axios
                .get("/api/getCategory")
                .then(response => {
                    app.categories = [];
                    if (response && response.data) {
                        app.categories = response.data;
                        app.$store.state.categories = app.categories;
                        for (let i=0;i<app.categories.length;i++) {
                            app.categoryIds.push(app.categories[i]['id']);
                        }
                    }
                });
        },
        computed: {
            setSupplierFields() {
                return {
                    dataSource: this.suppliers,
                    id: 'id',
                    parentID: 'pid',
                    text: 'name',
                    hasChildren: 'hasChild'
                }
            },
            setCatFields() {
                return {
                    dataSource: this.categories,
                    id: 'id',
                    parentID: 'pid',
                    text: 'name',
                    hasChildren: 'hasChild'
                }
            },
        },
        methods: {
            saveProducts() {
                console.log("saveProducts");
            },
            selectCategory() {
                console.log("selectCategory");
            },
            supplierChecked: function() {
                let supplierObj = document.getElementById('supplierTree').ej2_instances[0];
                this.$store.state.suppliers = supplierObj.checkedNodes;
            },
            categoryChecked: function() {
                let categoryObj = document.getElementById('categoryTree').ej2_instances[0];
                let checkedNode = categoryObj.getAllCheckedNodes();
                console.log("dddd ", checkedNode);
            }
        }
    }
</script>
<style lang="scss">
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
        .select-products{
            .tabs.row {
                margin: 0 32px;
                border-top: 2px solid $border_color;
                .col-auto {
                    padding: 0;
                    .nav-tabs  {
                        .nav-link {
                            padding: 20px;
                            border: 0;
                            border-radius: unset;
                        }
                        .nav-link.active {
                            background: #ececec;
                        }
                    }
                }
                .tab-content.col {
                    height: 450px;
                    max-height: 450px;
                    padding: 0;
                    width: calc(100% - 110px);
                }
            }
        }
    }
</style>
