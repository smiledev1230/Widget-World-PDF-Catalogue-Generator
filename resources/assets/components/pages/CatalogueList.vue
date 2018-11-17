<template>
    <div class="catalogue-list">
        <ul class="task_block1">
            <li v-for="(catalogue,index) in catalogues" class="task_block">
                <div>
                    <span class="catalogue-title">{{catalogue.title}} - </span>
                    <span class="catalogue-label" :class="labelColor[catalogue.state]">{{catalogueLabel[catalogue.state]}}</span>
                    <div v-if="catalogue.state == 0" class="pull-right">
                        <router-link tag="a" to="/new_catalogue" class="btn text-white yellowColor"
                                     @click.native="continueCatalogue(index)">CONTINUE
                        </router-link>
                    </div>
                    <div v-else class="pull-right btn-group">
                        <i class="fa fa-file-pdf-o mr-2" @click="openPDFModal(catalogue)"></i>
                        <i class="fa fa-edit mr-2" @click="openEditModal(catalogue)"></i>
                        <i class="fa fa-envelope-o mr-2" @click="openSendModal(catalogue)"></i>
                        <i class="fa fa-trash" @click="openDeleteModal(index)"></i>
                    </div>
                </div>
                <hr/>
                <div class="catalogue-history">
                    <div v-if="catalogue.state == 0">{{catalogue.date}}</div>
                    <div v-else-if="catalogue.state == 1">{{catalogue.date}} - PDF Saved</div>
                    <div v-else>
                        <p v-for="history in catalogue.history">{{history.date}} - PDF sent to {{history.emails}}</p>
                    </div>
                </div>
            </li>
        </ul>
        <b-modal id="editModal" title="Add Block" ref="editModal" v-model="editModal" class="catalogue-modal">
            <p>Duplicate catalogue <b>{{old_catalogue.title}}</b> and edit to create a new catalogue.</p>
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
        <catalogue-send :catalogue="old_catalogue" :catalogueSend.sync="catalogueSend"/>
        <b-modal id="deleteModal" title="Delete Catalogue" ref="deleteModal" v-model="deleteModal"
                 class="catalogue-modal">
            <p>Delete catalogue <b>{{old_catalogue.title}}</b></p>
            <div slot="modal-footer" class="w-100">
                <b-btn class="pl-3 pr-3" @click="deleteModal=false">CANCEL</b-btn>
                <b-btn class="float-right greenBgColor pl-3 pr-3" @click="deleteCatalogue">DELETE</b-btn>
            </div>
        </b-modal>
        <b-modal id="pdfModal" title="old_catalogue.title" ref="pdfModal" v-model="pdfModal" class="catalogue-modal">
            <div slot="modal-title">{{old_catalogue.title}}</div>
            <div class="merchantModalContent">
                <product-preview :productData="$store.state.productData"/>
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
    import productPreview from "./product_preview";
    import {productData} from '../../assets/js/global_variable';

    export default {
        name: "catalogue_send",
        components: {
            'catalogue-send': catalogueSend,
            'product-preview': productPreview,
        },
        data() {
            this.$store.state.productData = productData;
            this.$store.state.catalogue.pageColumns = 3;
            return {
                catalogues: [
                    {
                        id: 1,
                        title: 'Catalogue Name One',
                        state: 0,
                        date: '13/07/2018'
                    },
                    {
                        id: 2,
                        title: 'Catalogue Name Two',
                        state: 2,
                        history: [
                            {
                                date: '02/07/2018',
                                emails: 'karen@brandzonline.com.au; james@ketcocreative.com.au'
                            }
                        ]
                    },
                    {
                        id: 3,
                        title: 'Catalogue Name Three',
                        state: 1,
                        date: '20/06/2018'
                    },
                    {
                        id: 4,
                        title: 'Catalogue Name Four',
                        state: 2,
                        history: [
                            {
                                date: '08/07/2018',
                                emails: 'admin@brandzonline.com.au'
                            },
                            {
                                date: '20/06/2018',
                                emails: 'karen@brandzonline.com.au; james@ketcocreative.com.au'
                            }
                        ]
                    }
                ],
                catalogueLabel: ['Draft', 'PDF', 'PDF SENT'],
                labelColor: ['yellowColor', 'blueColor', 'greenColor'],
                editModal: false,
                deleteModal: false,
                pdfModal: false,
                catalogueSend: false,
                editState: {},
                old_catalogue: {},
                selectedIndex: -1,
                new_catalogue_title: '',
            }
        },
        mounted: function () {

        },
        methods: {
            openPDFModal(cat) {
                this.pdfModal = false;
                this.old_catalogue = cat;
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
                this.editModal = false;
                console.log("duplicate");
            },
            openDeleteModal(index) {
                this.selectedIndex = index;
                this.old_catalogue = this.catalogues[index];
                this.deleteModal = true;
                this.$refs.deleteModal.show();
            },
            deleteCatalogue() {
                this.deleteModal = false;
                if (this.selectedIndex >= 0) {
                    this.catalogues.splice(this.selectedIndex, 1);
                    this.selectedIndex = -1;
                }
            },
            continueCatalogue(index) {
                let selectedCatalogue = this.catalogues[index];
                this.$store.state.catalogue.name = selectedCatalogue.title;
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "../layouts/css/customvariables";

    .catalogue-list {
        margin: 0 20px 0 0;
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
        .pull-right.btn-group .fa.fa-file-pdf-o {
            font-size: 19px;
        }
        .pull-right.btn-group .fa.fa-edit {
            font-size: 21px;
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
        .modal-footer {
            display: none;
        }
        .merchantModalContent {
            margin: 10px 20px;
        }
        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 85%;
            }
        }
    }
</style>
