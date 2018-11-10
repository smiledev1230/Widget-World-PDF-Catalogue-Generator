<template>
    <div>
    </div>
</template>
<script>
    export default {
        name: "new_catalogue",
        components: {
        },
        data() {
            return {}
        },
        mounted: function () {
            this.$store.state.page_text = "Below is a list of your recent catalogues. Here you can continue and that have been saved for later, view PDFs generated, duplicate and edit previous catalogues or email the PDFs.";
        },
        methods: {

        }
    }
</script>
