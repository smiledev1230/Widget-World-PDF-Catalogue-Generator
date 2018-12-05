<template>
    <div>
        <b-modal id="saveModal" title="SAVED" ref="saveModal" v-model="saveModal" class="catalogue-modal">
            <p>Catalogue successfully saved.</p>
            <div slot="modal-footer" class="w-100">
                <b-btn class="pl-3 pr-3 greenBgColor" @click="saveModal=false">OK</b-btn>
            </div>
        </b-modal>
    </div>
</template>
<script>
    export default {
        name: "catalogue_preview",
        components: {},
        props: ['showStatus'],
        data() {
            return {
                saveModal: false,
            }
        },
        mounted: function () {

        },
        watch: {
            showStatus: function(){
                if (this.showStatus) {
                    this.$refs.saveModal.show();
                    this.$emit('update:showStatus', false);
                }
            }
        }
    }
</script>
<style lang="scss">
    #saveModal {
        .modal-body {
            text-align: center;
            font-size: 16px;
        }
        .modal-footer {
            text-align: center;
        }
    }
</style>
