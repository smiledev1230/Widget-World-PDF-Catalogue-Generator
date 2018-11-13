<template>
    <div class="catalogue-content">
        <hr/>
        <div class="row d-block">
            <router-link tag="a" to="/build_catalogue" exact class="btn btn-secondary text-white">BACK</router-link>
            <a class="btn greenBgColor pull-right text-white" @click="sendPDF">SEND AS PDF</a>
            <a class="btn btn-secondary pull-right text-white mr-3" @click="savePreview">SAVE FOR LATER</a>
        </div>
    </div>
</template>
<script>
    export default {
        name: "catalogue_preview",
        components: {
        },
        data() {
            return {}
        },
        mounted: function () {
            this.$store.state.page_text = "Preview how your catalogue is going to look and send it as a PDF.";
            this.$store.state.page_subText = "You can always save it for later and come back to it when you are ready to send.";
        },
        methods: {
            savePreview() {
                console.log("savePreview");
            },
            sendPDF() {
                console.log("sendPDF");
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "../layouts/css/customvariables";
    .catalogue-content {

    }
</style>
