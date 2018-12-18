<template>
    <div class="catalogue-list">
        <ul class="task_block1">
            <li v-for="(catalogue,index) in catalogues" class="task_block" :key="index">
                <div>
                    <span class="catalogue-title">{{catalogue.name}} - </span>
                    <span class="catalogue-label" :class="labelColor[catalogue.state]">{{catalogueLabel[catalogue.state]}}</span>
                    <div v-if="catalogue.state == 0" class="pull-right">
                        <router-link tag="a" :to="catalogue.saved_page ? catalogue.saved_page : '/new_catalogue'" class="btn text-white yellowColor continue-btn"
                                     @click.native="continueCatalogue(index)">CONTINUE
                        </router-link>
                    </div>
                    <div v-else class="pull-right btn-group">
                        <i class="fa fa-file-pdf-o mr-2" @click="openPDFModal(catalogue)"></i>
                        <i class="fa fa-edit mr-2" @click="openEditModal(catalogue)"></i>
                        <i class="fa fa-envelope-o mr-2" @click="openSendModal(catalogue)"></i>
                        <i class="fa fa-trash" @click="openDeleteModal(catalogue)"></i>
                    </div>
                </div>
                <hr/>
                <div class="catalogue-history">
                    <div v-if="catalogue.state == 0">
                        {{catalogue.pdf_date}}
                        <div class="pull-right btn-group">
                            <i class="fa fa-edit mr-2" @click="openEditModal(catalogue)"></i>
                            <i class="fa fa-trash" @click="openDeleteModal(catalogue)"></i>
                        </div>
                    </div>
                    <div v-else>
                        <p v-for="(date, i) in catalogue.sent_date" :key="i">{{date}} - PDF sent to {{catalogue.emails[i]}}</p>
                    </div>
                </div>
            </li>
        </ul>
        <b-modal id="editModal" title="Duplicate and Edit" ref="editModal" v-model="editModal" class="catalogue-modal">
            <p>Duplicate catalogue <b>{{old_catalogue.name}}</b> and edit to create a new catalogue.</p>
            <vue-form class="form-horizontal form-validation" :state="editState" @submit.prevent="onSubmit">
                <div class="col-lg-12">
                    <div class="form-group">
                        <validate tag="div">
                            <input v-model="new_catalogue_title" name="subject" type="text" required autofocus
                                   placeholder="New Catalogue Name:" class="form-control"/>
                            <field-messages name="new_catalogue" show="$invalid && $submitted" class="text-danger">
                                <div slot="required">New Catalogue Name is a required field</div>
                            </field-messages>
                        </validate>
                    </div>
                </div>
            </vue-form>
            <div slot="modal-footer" class="w-100">
                <b-btn class="pl-3 pr-3" @click="editModal=false">CANCEL</b-btn>
                <b-btn class="float-right greenBgColor pl-3 pr-3" @click="duplicate()">DUPLICATE</b-btn>
            </div>
        </b-modal>
        <catalogue-send :catalogue="old_catalogue" :catalogueSend.sync="catalogueSend" :limited="limited" :catalogues.sync="catalogues" />
        <b-modal id="deleteModal" title="Delete Catalogue" ref="deleteModal" v-model="deleteModal"
                 class="catalogue-modal">
            <p>Delete catalogue <b>{{old_catalogue.name}}</b></p>
            <div slot="modal-footer" class="w-100">
                <b-btn class="pl-3 pr-3" @click="deleteModal=false">CANCEL</b-btn>
                <b-btn class="float-right greenBgColor pl-3 pr-3" @click="deleteCatalogue">DELETE</b-btn>
            </div>
        </b-modal>
        <b-modal id="pdfModal" title="old_catalogue.name" ref="pdfModal" v-model="pdfModal" class="catalogue-modal" :class="{page2:old_catalogue.page_columns == 2}">
            <div slot="modal-title">{{old_catalogue.name}}</div>
            <div class="merchantModalContent">
                <button type="button" aria-label="Download" class="pdf-download" @click="downloadPDF"><i class="fa fa-download" aria-hidden="true"></i></button>
                <product-preview :catalogue="old_catalogue" :productData="productData" :totalPages="totalPages"/>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import Vue from 'vue';
    import VueForm from "vue-form";
    import options from "src/validations/validations.js";

    Vue.use(VueForm, options);
    import catalogueSend from "./catalogue_send";
    import productPreview from "./product_preview";;

    export default {
        name: "catalogue_send",
        components: {
            'catalogue-send': catalogueSend,
            'product-preview': productPreview,
        },
        props: ['limited'],
        data() {
            this.$store.state.catalogue.page_columns = 3;
            return {
                catalogues: [],
                catalogueLabel: ['Draft', 'PDF SENT'],
                labelColor: ['yellowColor', 'greenColor'],
                editModal: false,
                deleteModal: false,
                pdfModal: false,
                catalogueSend: false,
                editState: {},
                old_catalogue: {},
                new_catalogue_title: '',
                productData: [],
                totalPages: 2,
            }
        },
        created() {
            if (this.$store.state.user.id) {
                axios.get('/api/getRecentCatalogue', {params: {user_id: this.$store.state.user.id, limited: this.limited}}).then(response => {
                    this.catalogues = response.data
                });
            }
        },
        mounted: function () {

        },
        methods: {
            openPDFModal(cat) {
                this.pdfModal = false;
                this.old_catalogue = cat;
                if (cat.display_type) {
                    let suppliers_ids = this.getSupplierTreeIds(cat.suppliers);
                    this.getProductData(this.$store.state.suppliers, suppliers_ids);
                } else {
                    let categories_ids = this.getCategoryTreeIds(cat.categories);
                    this.getProductData(this.$store.state.categories, categories_ids);
                }
                this.totalPages = Math.round(this.productData.length/3/cat.page_columns + 0.5);
                this.$refs.pdfModal.show();
            },
            openEditModal(cat) {
                this.editModal = false;
                this.old_catalogue = cat;
                this.$refs.editModal.show();
            },
            openSendModal(cat) {
                this.old_catalogue = cat;
                this.catalogueSend = true;
            },
            duplicate() {
                if (this.new_catalogue_title) {
                    let preload = {
                        id: this.old_catalogue.id,
                        user_id: this.$store.state.user.id,
                        name: this.new_catalogue_title,
                        state: 0,
                        limited: this.limited
                    }
                    let app = this;
                    axios.post('/api/duplicateCatalogue', preload).then(response => {
                        if (response.data != 'error') {
                            app.catalogues = response.data;
                        }
                    });
                }
                this.editModal = false;
                this.new_catalogue_title = "";
            },
            openDeleteModal(cat) {
                this.old_catalogue = cat;
                this.deleteModal = true;
                this.$refs.deleteModal.show();
            },
            deleteCatalogue() {
                this.deleteModal = false;
                if (this.old_catalogue.id) {
                    let preload = {
                        id: this.old_catalogue.id,
                        user_id: this.$store.state.user.id,
                        limited: this.limited
                    }
                    let app = this;
                    axios.post('/api/deleteCatalogue', preload).then(response => {
                        app.catalogues = response.data;
                    });
                }
            },
            downloadPDF() {
                console.log("downloadPDF: ", this.old_catalogue);
                if (this.old_catalogue.pdf_path) {
                    let app = this;
                    axios({
                        url: '/api/getDownloadPDF?path='+app.old_catalogue.pdf_path,
                        method: 'GET',
                        responseType: 'blob', // important
                    }).then((response) => {
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', app.old_catalogue.name+'.pdf');
                        document.body.appendChild(link);
                        link.click();
                    });
                }
            },
            continueCatalogue(index) {
                let catalogue = this.catalogues[index];
                if (catalogue.id) this.$store.state.catalogue.id = catalogue.id;
                this.$store.state.catalogue.name = catalogue.name;
                this.$store.state.catalogue.file_name = catalogue.logo_name;
                this.$store.state.catalogue.file_upload_path = catalogue.logo_url;
                this.$store.state.catalogue.selectedImage = catalogue.cover_index;
                if (catalogue.page_columns !== null) this.$store.state.catalogue.page_columns = catalogue.page_columns;
                if (catalogue.display_type !== null) this.$store.state.catalogue.display_type = catalogue.display_type;
                if (catalogue.logos_options !== null) this.$store.state.catalogue.logos_options = catalogue.logos_options;
                if (catalogue.display_options) this.$store.state.catalogue.display_options = catalogue.display_options;
                if (catalogue.barcode_options) this.$store.state.catalogue.barcode_options = catalogue.barcode_options;
                if (catalogue.suppliers) this.$store.state.sel_supplier_ids = catalogue.suppliers;
                if (catalogue.categories) this.$store.state.sel_category_ids = catalogue.categories;
                if (catalogue.supplier_new) this.$store.state.supplier_new = catalogue.supplier_new;
                if (catalogue.category_new) this.$store.state.category_new = catalogue.category_new;
                if (catalogue.supplier_block) this.$store.state.supplier_block = catalogue.supplier_block;
                if (catalogue.category_block) this.$store.state.category_block = catalogue.category_block;
                if (catalogue.drag_supplier_ids) this.$store.state.drag_supplier_ids = catalogue.drag_supplier_ids;
                if (catalogue.drag_category_ids) this.$store.state.drag_category_ids = catalogue.drag_category_ids;
                this.$store.state.suppliers_ids = this.getSupplierTreeIds(this.$store.state.sel_supplier_ids);
                this.$store.state.categories_ids = this.getCategoryTreeIds(this.$store.state.sel_category_ids);
            },
            getSupplierTreeIds(checkedNode) {
                let supplierList = this.$store.state.suppliers;
                let supplierIds = this.$store.state.supplierIds;
                let selectedIds = [];
                let sid, idx, pid, ppid;
                for (let i=0; i<checkedNode.length;i++) {
                    selectedIds.push(checkedNode[i]);
                }
                let pchilds = [];
                let checkedAncestor = false;
                for (let j=0;j<supplierList.length;j++) {
                    if (supplierList[j]['pid'] && selectedIds.indexOf(supplierList[j]['pid']) >= 0) {
                        pchilds.push(supplierList[j]['id']);
                        if (supplierList[j]['hasChild']) checkedAncestor = true;
                    }
                }
                if (checkedAncestor) {
                    for (let p=0;p<supplierList.length;p++) {
                        let supplierRow = supplierList[p];
                        if (supplierRow['pid'] && pchilds.indexOf(supplierRow['pid']) >= 0) {
                            pchilds.push(supplierRow['id']);
                        }
                    }
                }
                for (let k=0; k<checkedNode.length;k++) {
                    idx = supplierIds.indexOf(checkedNode[k]);
                    if (supplierList[idx] && supplierList[idx]['pid']) {
                        for (let p=0; p<10; p++) {
                            pid = idx >0 ? supplierList[idx]['pid'] : '';
                            if (pid) {
                                selectedIds.push(pid);
                                idx = supplierIds.indexOf(pid);
                            } else {
                                break;
                            }
                        }
                    }
                }
                selectedIds = selectedIds.concat(pchilds);
                return selectedIds.filter((v, i, a) => a.indexOf(v) === i);
            },
            getCategoryTreeIds(checkedNode) {
                let selectedIds = [];
                let idx, pid, ppid;
                let categoryList = this.$store.state.categories;
                let categoryIds = this.$store.state.categoryIds;
                for (let i=0; i<checkedNode.length;i++) {
                    selectedIds.push(checkedNode[i]);
                }
                for (let j=0;j<categoryList.length;j++) {
                    if (categoryList[j]['pid'] && selectedIds.indexOf(categoryList[j]['pid']) >= 0) {
                        selectedIds.push(categoryList[j]['id']);
                    }
                }
                for (let k=0; k<checkedNode.length;k++) {
                    idx = categoryIds.indexOf(checkedNode[k]);
                    if (categoryList[idx] && categoryList[idx]['pid']) {
                        for (let p=0; p<10; p++) {
                            pid = idx >0 ? categoryList[idx]['pid'] : '';
                            if (pid) {
                                selectedIds.push(pid);
                                idx = categoryIds.indexOf(pid);
                            } else {
                                break;
                            }
                        }
                    }
                }
                return selectedIds.filter((v, i, a) => a.indexOf(v) === i);
            },
            getProductData(allProduct, checkedIds) {
                this.productData = [];
                let productIds = [];
                for (let i=0;i<allProduct.length;i++) {
                    if (checkedIds.indexOf(allProduct[i]['id']) >= 0 && !allProduct[i]['hasChild']) {
                        if (this.old_catalogue.product_new && this.old_catalogue.product_new.indexOf(allProduct[i]['id'].toString())>=0) {
                            allProduct[i]['product_is_new'] = true;
                        }
                        this.productData.push(allProduct[i]);
                        productIds.push(allProduct[i]['id']);
                    }
                }
                if (this.old_catalogue.blocks) {
                    let k=0;
                    for (let i=0;i<this.old_catalogue.blocks.length;i++) {
                        if (productIds.indexOf(this.old_catalogue.blocks[i]['id'])>=0) {
                            let newBlock = {
                                id: new Date().getTime(),
                                name: this.old_catalogue.blocks[i]['name'],
                                type: 'block'
                            }
                            this.productData.splice(productIds.indexOf(this.old_catalogue.blocks[i]['id'])+k, 0, newBlock);
                            k++;
                        }
                    }
                }
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "../layouts/css/customvariables";
    .catalogue-list {
        max-height: 600px;
        overflow-y: auto;
        .task_block {
            border: 1px solid $border_color;
            padding: 10px 15px;
            margin: 10px 0;
            box-shadow: 0 0 2px $border_color;
        }
        .task_block:hover {
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }
        .task_block1 {
            padding: 0;
        }
        .task_input {
            border-radius: 5px;
            padding: 5px;
            border-width: 1px;
            width: 90%;
        }
        .task_block {
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .task_block i,
        .marker,
        .send-btn {
            cursor: pointer;
        }

        .catalogue-title {
            font-size: 16px;
        }
        .catalogue-label {
            color: $white_color;
            padding: 2px 10px;
            border-radius: 0;
            text-transform: uppercase;
            background: $yellow_color;
        }
        .yellowColor {
            background: $yellow_color;
        }
        .blueColor {
            background: $blue_color;
        }
        .greenColor {
            background: $green_color;
        }
        .btn.yellowColor {
            padding: 2px 20px;
            margin: 0;
        }
        .pull-right.btn-group {
            padding-top: 5px;
            i {
                font-size: 20px;
                color: $grey_color;
            }
        }
        .pull-right.btn-group .fa:hover {
            color: $black_color;
        }
        .pull-right.btn-group .fa.fa-file-pdf-o {
            font-size: 19px;
        }
        .pull-right.btn-group .fa.fa-edit {
            font-size: 21px;
        }
        .pull-right .continue-btn:hover {
            background: $green_color;
        }
        hr {
            border-width: 2px;
            margin: 10px 0px;
        }
        .catalogue-history {
            color: $grey_color;
            p {
                margin-bottom: 0px;
            }
        }

        @media screen and (max-width: 575px) {
            .task_block1 input {
                margin-left: -10px;
            }
        }
    }
</style>
<style lang="scss">
    #pdfModal {
        .modal-dialog {
            margin: 20px auto;
            .modal-footer {
                display: none;
            }
            .merchantModalContent {
                margin: 0 20px;
            }
            .modal-title {
                padding-top: 0;
            }
            .modal-body {
                padding-bottom: 0;
                .pdf-download {
                    position: absolute;
                    right: 50px;
                    top: -26px;
                    font-size: 18px;
                    color: #7e7e7e;
                    background: transparent;
                    border: none;
                    cursor: pointer;
                }
                .pdf-download:hover {
                    color: #000;
                    text-decoration: none;
                    opacity: .75;
                }
            }
            .product-list {
                min-height: 85vh !important;
                .product-body {
                    min-height: 80vh !important;
                }
            }
        }
        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 80%;
            }
        }
    }
    .page2 {
        #pdfModal {
            .modal-dialog .product-list {
                min-height: 810px !important;
            }
            @media (min-width: 576px) {
                .modal-dialog {
                    max-width: 58%;
                }
            }
        }
    }
</style>
