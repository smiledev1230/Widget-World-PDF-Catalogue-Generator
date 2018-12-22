<template>
    <div>
        <b-modal id="sentModal" title="Success" ref="sentModal" v-model="sentModal" class="catalogue-modal">
            <p>Your catalogue has been sent.</p>
            <div slot="modal-footer" class="w-100">
                <b-btn class="pl-3 pr-3 greenBgColor" @click="sentModal=false">OK</b-btn>
            </div>
        </b-modal>
    </div>
</template>
<script>
    export default {
        name: "sent_modal",
        components: {},
        props: ['showStatus'],
        data() {
            return {
                sentModal: false,
            }
        },
        mounted: function () {

        },
        watch: {
            showStatus: function(){
                if (this.showStatus) {
                    this.$refs.sentModal.show();
                    this.$emit('update:showStatus', false);
                }
            }
        }
    }
</script>
<style lang="scss">
    #sentModal {
        .modal-body {
            text-align: center;
            font-size: 16px;
        }
        .modal-footer {
            text-align: center;
        }
    }
</style>
