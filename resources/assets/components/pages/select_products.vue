<template>
    <div class="catalogue-content">
        <div class="select-products">
            <b-tabs v-model="tabIndex" vertical>
                <b-tab title="Suppliers">
                    <tree-view :showCheck="showCheck" :treeData="suppliers" />
                </b-tab>
                <b-tab title="Categories">
                    <tree-view :showCheck="showCheck" :treeData="categories" />
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
    import treeView from "../plugins/treeView/treeView";
    export default {
        name: "select_products",
        components: {
            'tree-view': treeView,
        },
        data() {
            return {
                tabIndex: 0,
                showCheck: true,
                suppliers: [],
                categories: []
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
                    }
                });
        },
        methods: {
            saveProducts() {
                console.log("saveProducts");
            },
        }
    }
</script>
<style lang="scss">
    @import "../layouts/css/customvariables";
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
