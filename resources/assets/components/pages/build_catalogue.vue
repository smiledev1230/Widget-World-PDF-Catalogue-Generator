<template>
    <div class="catalogue-content">
        <div class="visual-options">
            <div class="row d-block">
                <label class="mb-0">Visual Options</label>
                <i @click="showCollapse = !showCollapse"
                   aria-controls="vOptions"
                   :aria-expanded="showCollapse ? 'true' : 'false'"
                   class="collapse-btn pull-right fa" :class="showCollapse ? 'fa-angle-down' : 'fa-angle-up'">
                </i>
            </div>
            <b-collapse id="vOptions" v-model="showCollapse" class="mt-2">
                <div class="row">
                    <div class="col-md-9">

                    </div>
                    <div class="col-md-3">
                        <a class="btn greenBgColor pull-right text-white mr-3" @click="updateOptions">UPDATE</a>
                    </div>
                </div>
            </b-collapse>
        </div>
        <hr/>
        <div class="row d-block">
            <router-link tag="a" to="/" exact class="btn btn-secondary text-white">CANCEL</router-link>
            <router-link tag="a" to="/select_products" exact class="btn btn-secondary back-btn text-white">BACK</router-link>
            <router-link tag="a" to="/catalogue_preview" exact class="btn greenBgColor pull-right text-white">NEXT</router-link>
            <a class="btn btn-secondary pull-right text-white mr-3" @click="saveProducts">SAVE FOR LATER</a>
        </div>
    </div>
</template>
<script>
    export default {
        name: "build_catalogue",
        components: {
        },
        data() {
            return {
                showCollapse: false
            }
        },
        mounted: function () {
            this.$store.state.page_text = "Add your selected products and product ranges into your Catalogue.";
            this.$store.state.page_subText = "You can display them grouped in Suppliers or Categories and customise the order if required or display alphabetically as default.";
        },
        methods: {
            saveProducts() {
                console.log("saveProducts");
            },
            updateOptions() {
                console.log("updateOptions");
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "../layouts/css/customvariables";
    .catalogue-content {
        .visual-options {
            background: $grey_bgColor;
            padding: 10px 15px;
            .collapse-btn {
                padding: 0 10px;
                background: no-repeat;
                border: 0;
                color: $angle_color;
                font-size: 22px;
                cursor: pointer;
            }
        }
    }
</style>
