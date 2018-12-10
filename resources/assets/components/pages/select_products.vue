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
                        <ejs-treeview id='categoryTree' :fields="setCatFields" showCheckBox="true" :nodeChecked="categoryChecked"></ejs-treeview>
                    </div>
                </b-tab>
            </b-tabs>
        </div>
        <div class="content-bottom">
            <hr/>
            <div class="row d-block">
                <router-link tag="a" to="/" exact class="btn btn-secondary text-white">CANCEL</router-link>
                <router-link tag="a" to="/new_catalogue" exact class="btn btn-secondary back-btn text-white" @click.native="backClick">BACK</router-link>
                <router-link tag="a" to="/build_catalogue" exact class="btn greenBgColor pull-right text-white" @click.native="next">NEXT</router-link>
                <a class="btn btn-secondary pull-right text-white mr-3" @click="saveProducts">SAVE FOR LATER</a>
            </div>
        </div>
        <save-modal :showStatus.sync="showStatus" />
    </div>
</template>
<script>
    import Vue from 'vue';
    import { TreeViewPlugin } from "@syncfusion/ej2-vue-navigations";
    Vue.use(TreeViewPlugin);
    import saveModal from "./save_modal";
    import { DataManager,Query,ODataAdaptor } from "@syncfusion/ej2-data";

    export default {
        name: "select_products",
        components: {
            'save-modal': saveModal
        },
        data() {
            return {
                tabIndex: 0,
                showCheck: true,
                supplierIds: this.$store.state.supplierIds,
                categoryIds: this.$store.state.categoryIds,
                showStatus: false,
            }
        },
        mounted: function () {
            this.$store.state.page_text = "Select the products to be displayed in your catalogue. You can choose a complete range from single or multiple Suppliers, single or multiple categories or indivudal products. On the next screen you can insert these products into your pages.";
        },
        computed: {
            setSupplierFields() {
                let dataSource = this.$store.state.suppliers;
                if (dataSource.length>0 && this.$store.state.sel_supplier_ids.length>0) {
                    for (let i=0;i<dataSource.length;i++) {
                        if (this.$store.state.sel_supplier_ids.indexOf(dataSource[i]['id']) >= 0) {
                            dataSource[i]['isChecked'] = true;
                        } else {
                            dataSource[i]['isChecked'] = false;
                        }
                    }
                }
                return {
                    dataSource: dataSource,
                    id: 'id',
                    parentID: 'pid',
                    text: 'name',
                    hasChildren: 'hasChild'
                }
            },
            setCatFields() {
                let dataSource = this.$store.state.categories;
                if (dataSource.length>0 && this.$store.state.sel_category_ids.length>0) {
                    for (let i=0;i<dataSource.length;i++) {
                        if (this.$store.state.sel_category_ids.indexOf(dataSource[i]['id'].toString()) >= 0) {
                            dataSource[i]['isChecked'] = true;
                        } else {
                            dataSource[i]['isChecked'] = false;
                        }
                    }
                }
                return {
                    dataSource: dataSource,
                    id: 'id',
                    parentID: 'pid',
                    text: 'name',
                    hasChildren: 'hasChild'
                }
            },
        },
        methods: {
            backClick() {
                this.$store.new_state = false;
            },
            saveProducts() {
                console.log("saveProducts");
                this.next();
                let formData = new FormData();
                let storeData = this.$store.state;
                if (storeData.catalogue.id) formData.append('id', storeData.catalogue.id);
                formData.append('name', storeData.catalogue.name);
                if (storeData.catalogue.file_name) formData.append('logo_name', storeData.catalogue.file_name);
                if (storeData.catalogue.file_upload_path) formData.append('logo_url', storeData.catalogue.file_upload_path);
                formData.append('cover_index', storeData.catalogue.selectedImage);
                formData.append('suppliers',storeData.sel_supplier_ids);
                formData.append('categories', storeData.sel_category_ids);
                formData.append('saved_page', 'select_products');
                formData.append('state', '0');
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
            selectCategory() {
                console.log("selectCategory");
            },
            supplierChecked: function() {
                console.log("supplierChecked");
            },
            categoryChecked: function() {
                console.log("categoryChecked");
            },
            next() {
                let categoryObj = document.getElementById('categoryTree').ej2_instances[0];
                let checkedNode = categoryObj.getAllCheckedNodes();
                console.log("categories checkedNode ", checkedNode);
                this.$store.state.sel_category_ids = this.$store.state.categories_ids = [];
                if (checkedNode.length > 0) {
                    let selectedIds = [];
                    let idx, pid, ppid;
                    let categoryList = this.$store.state.categories;
                    for (let i=0; i<checkedNode.length;i++) {
                        selectedIds.push(checkedNode[i]);
                        this.$store.state.sel_category_ids.push(checkedNode[i]);
                    }
                    for (let j=0;j<categoryList.length;j++) {
                        if (categoryList[j]['pid'] && selectedIds.indexOf(categoryList[j]['pid']) >= 0) {
                            selectedIds.push(categoryList[j]['id']);
                            this.$store.state.categories[j]['isChecked'] = true;
                            this.$store.state.sel_category_ids.push(categoryList[j]['id']);
                        }
                    }
                    for (let k=0; k<checkedNode.length;k++) {
                        idx = this.categoryIds.indexOf(checkedNode[k]);
                        if (categoryList[idx] && categoryList[idx]['pid']) {
                            pid = categoryList[idx]['pid'];
                            selectedIds.push(pid);
                            ppid = this.categoryIds.indexOf(pid);
                            if (categoryList[ppid]['pid']) selectedIds.push(categoryList[ppid]['pid']);
                            this.$store.state.categories[idx]['isChecked'] = true;
                        }
                    }
                    this.$store.state.categories_ids = selectedIds.filter((v, i, a) => a.indexOf(v) === i);
                    console.log("this.$store.state.categories_ids ", this.$store.state.categories_ids);
                }
                this.setSuppliers();
            },
            setSuppliers() {
                let supplierObj = document.getElementById('supplierTree').ej2_instances[0];
                let checkedNode = supplierObj.getAllCheckedNodes();
                console.log("suppliers checkedNode ", checkedNode);
                this.$store.state.sel_supplier_ids = this.$store.state.suppliers_ids = [];
                if (checkedNode.length > 0) {
                    let selectedIds = [];
                    let idx, pid, ppid;
                    let supplierList = this.$store.state.suppliers;
                    for (let i=0; i<checkedNode.length;i++) {
                        selectedIds.push(checkedNode[i]);
                        this.$store.state.sel_supplier_ids.push(checkedNode[i]);
                    }
                    let pchilds = [];
                    let checkedAncestor = false;
                    for (let j=0;j<supplierList.length;j++) {
                        if (supplierList[j]['pid'] && selectedIds.indexOf(supplierList[j]['pid']) >= 0) {
                            pchilds.push(supplierList[j]['id']);
                            this.$store.state.suppliers[j]['isChecked'] = true;
                            this.$store.state.sel_supplier_ids.push(supplierList[j]['id']);
                            if (supplierList[j]['hasChild']) checkedAncestor = true;
                        }
                    }
                    if (checkedAncestor) {
                        for (let p=0;p<supplierList.length;p++) {
                            let supplierRow = supplierList[p];
                            if (supplierRow['pid'] && pchilds.indexOf(supplierRow['pid']) >= 0) {
                                pchilds.push(supplierRow['id']);
                                this.$store.state.suppliers[p]['isChecked'] = true;
                                this.$store.state.sel_supplier_ids.push(supplierRow['id']);
                            }
                        }
                    }
                    for (let k=0; k<checkedNode.length;k++) {
                        idx = this.supplierIds.indexOf(checkedNode[k]);
                        if (supplierList[idx] && supplierList[idx]['pid']) {
                            pid = supplierList[idx]['pid'];
                            selectedIds.push(pid);
                            ppid = this.supplierIds.indexOf(pid);
                            if (supplierList[ppid]['pid']) selectedIds.push(supplierList[ppid]['pid']);
                            this.$store.state.suppliers[idx]['isChecked'] = true;
                        }
                    }
                    selectedIds = selectedIds.concat(pchilds);
                    this.$store.state.suppliers_ids = selectedIds.filter((v, i, a) => a.indexOf(v) === i);
                    // console.log("this.$store.state.suppliers_ids ", this.$store.state.suppliers_ids);
                }
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
