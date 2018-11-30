<template>
    <div>
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
                        <textarea v-model="sendForm.message" name="message" rows="6"
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
    </div>
</template>
<script>
    import Vue from 'vue';
    import VueForm from "vue-form";
    import options from "src/validations/validations.js";

    Vue.use(VueForm, options);

    export default {
        name: "catalogue_preview",
        components: {},
        props: ['catalogue', 'catalogueSend'],
        data() {
            return {
                sendModal: false,
                formState: {},
                sendForm: {
                    subject: '',
                    emails: '',
                    message: ''
                }
            }
        },
        mounted: function () {

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
                console.log("sendPDF");
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
