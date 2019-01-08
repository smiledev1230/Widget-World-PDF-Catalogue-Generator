<template>
    <div>
        <spinner v-show="$store.state.preloader"></spinner>
        <b-modal id="sendModal" title="Send Catalogue as PDF" ref="sendModal" v-model="sendModal"
                 class="catalogue-modal">
            <p>Send your finished catalogue to any number of email addresses as a PDF.</p>
            <vue-form class="form-horizontal form-validation" :state="formState" @submit.prevent="onSubmit">
                <div class="col-lg-12">
                    <div class="form-group">
                        <validate tag="div">
                            <input v-model="sendForm.subject" name="subject" type="text" required autofocus
                                   placeholder="Email Subject" class="form-control"/>
                            <field-messages name="subject" show="$invalid && $submitted" class="text-danger">
                                <div slot="required">Email Subject is a required field</div>
                            </field-messages>
                        </validate>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <validate tag="div">
                            <input v-model="sendForm.emails" name="emails" type="email" required
                                   placeholder="Email Address(es): Separate with semi colon;" class="form-control"/>
                            <field-messages name="email" show="$invalid && $submitted" class="text-danger">
                                <div slot="required">Email is a required field</div>
                                <div slot="email">Email is not valid</div>
                            </field-messages>
                        </validate>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <textarea v-model="sendForm.notes" name="notes" rows="6"
                                  class="form-control resize_vertical" placeholder="Message"></textarea>
                    </div>
                </div>
            </vue-form>
            <p class="pl-4">File: {{catalogue.name}}.pdf</p>
            <div slot="modal-footer" class="w-100">
                <b-btn class="pl-3 pr-3" @click="sendModal=false">CANCEL</b-btn>
                <b-btn class="float-right greenBgColor pl-3 pr-3" @click="sendPDF()">SEND</b-btn>
            </div>
        </b-modal>
        <sent-modal :showStatus.sync="showStatus" />
    </div>
</template>
<script>
    import Vue from 'vue';
    import VueForm from "vue-form";
    import options from "src/validations/validations.js";
    Vue.use(VueForm, options);

    import Spinner from "../layouts/spinner";
    import sentModal from "./sent_modal";
    import { coverImages } from '../../assets/js/global_variable';

    export default {
        name: "catalogue_preview",
        components: {
            'spinner':Spinner,
            'sent-modal': sentModal
        },
        props: ['catalogue', 'catalogueSend', 'limited', 'catalogues'],
        data() {
            return {
                sendModal: false,
                showStatus: false,
                imageList : coverImages,
                formState: {},
                sendForm: {
                    subject: '',
                    emails: '',
                    notes: ''
                }
            }
        },
        mounted: function () {
            this.$store.state.preloader = false;
        },
        watch: {
            catalogueSend: function(){
                if (this.catalogueSend) {
                    this.$refs.sendModal.show();
                    this.$emit('update:catalogueSend', false);
                }
            }
        },
        methods: {
            sendPDF() {
                this.sendModal=false;

                if (this.sendForm.subject && this.sendForm.emails) {
                    let sendFormData = new FormData();
                    sendFormData.append('name', this.catalogue.name);
                    sendFormData.append('subject', this.sendForm.subject);
                    sendFormData.append('emails', this.sendForm.emails);
                    sendFormData.append('notes', this.sendForm.notes);
                    if (this.limited) sendFormData.append('limited', this.limited);

                    if (this.catalogue.pdf_path) {
                        sendFormData.append('id', this.catalogue.id);
                        sendFormData.append('user_id', this.$store.state.user.id);
                        sendFormData.append('pdf_path', this.catalogue.pdf_path);
                        this.sendData(sendFormData);
                    } else {
                        let app = this;
                        let formData = new FormData();
                        let storeData = this.$store.state;
                        if (storeData.catalogue.id) formData.append('id', storeData.catalogue.id);
                        formData.append('user_id', storeData.user.id);
                        formData.append('name', storeData.catalogue.name);
                        if (storeData.catalogue.selectedImage) formData.append('brand_path', storeData.catalogue.coverPath);
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
                        formData.append('state', '1');
                        if (storeData.supplier_block.length>0) formData.append('supplier_block', JSON.stringify(storeData.supplier_block));
                        if (storeData.category_block.length>0) formData.append('category_block', JSON.stringify(storeData.category_block));
                        if (storeData.supplier_new.length>0) formData.append('supplier_new', storeData.supplier_new);
                        if (storeData.category_new.length>0) formData.append('category_new', storeData.category_new);

                        formData.append('productData', JSON.stringify(storeData.productData));
                        let totalPages = Math.round(storeData.productData.length/3/storeData.catalogue.page_columns + 0.5);
                        if (storeData.catalogue.page_columns == 4) {
                            totalPages = Math.round(storeData.productData.length/16 + 0.5);
                        }
                        formData.append('pages', totalPages);
                        app.$store.state.preloader = true;

                        axios.post( '/api/savePDF',
                            formData,
                            {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            }
                        ).then(response => {
                            console.log("response", response);
                            app.$store.state.preloader = false;
                            if (response.data && response.data.id) {
                                app.$store.state.catalogue.id = response.data.id;
                                sendFormData.append('id',  response.data.id);
                                sendFormData.append('pdf_path',  response.data.pdf_path);
                                app.sendData(sendFormData);
                            }
                        }).catch(function(){
                            console.log('FAILURE!!');
                            app.$store.state.preloader = false;
                        });
                    }
                    console.log("savePDF");

                } else {
                    return false;
                }
                this.sendForm ={
                    subject: '',
                    emails: '',
                    notes: ''
                }
            },
            sendData(formData) {
                let app = this;
                this.$store.state.preloader = true;
                axios.post( '/api/sendPDF',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(response => {
                    console.log('success!!', response.data);
                    app.$store.state.preloader = false;
                    app.showStatus = true;
                    if (response.data != 'error' && app.limited != -1) {
                        app.$emit('update:catalogues', response.data);
                    }
                }).catch(function(){
                    console.log('FAILURE!!');
                    app.$store.state.preloader = false;
                });
            }
        }
    }
</script>
<style lang="scss">
    @import "../layouts/css/customvariables";

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
