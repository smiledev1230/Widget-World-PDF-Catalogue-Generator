<template>
    <div class="product-list">
        {{$store.state.catalogue.name}}
        <div class="row">

        </div>
        <div class="product-footer">
            <label class="pull-left ml-4" :class="{active: selectedPage > 1}" @click="prevPage">
                <i class="fa fa-chevron-left" aria-hidden="true"></i> Previous
            </label>
            <label class="page-nav">
                <span :class="{active: getNavIndex() == 0}" @click="updatePageNav(0)" v-if="getPageNav(0)">{{getPageNav(0)}}</span>
                <span :class="{active: getNavIndex() == 1}" @click="updatePageNav(1)" v-if="getPageNav(1)">{{getPageNav(1)}}</span>
                <span :class="{active: getNavIndex() == 2}" @click="updatePageNav(2)" v-if="getPageNav(2)">{{getPageNav(2)}}</span>
                <span :class="{active: getNavIndex() == 3}" @click="updatePageNav(3)" v-if="getPageNav(3)">{{getPageNav(3)}}</span>
            </label>
            <label class="pull-right mr-4" :class="{active: selectedPage < totalPages-1}" @click="nextPage">
                Next <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </label>
        </div>
    </div>
</template>
<script>
    export default {
        name: "product_list",
        components: {
        },
        data() {
            return {
                selectedPage: 1,
                totalPages: 10
            }
        },
        mounted: function () {
        },
        methods: {
            prevPage() {
                if (this.selectedPage < 1) return;
                this.selectedPage -= 2;
            },
            getNavIndex() {
                return (this.selectedPage - 1) / 2 % 4;
            },
            updatePageNav(index) {
                this.selectedPage += (index - this.getNavIndex()) * 2;
            },
            getPageNav(index) {
                let firstPageNumber = this.selectedPage + (index - this.getNavIndex()) * 2;
                if (firstPageNumber > (this.totalPages - 1)) return;
                return firstPageNumber + "-" + (firstPageNumber + 1);
            },
            nextPage() {
                if (this.selectedPage >= (this.totalPages - 1)) return;
                this.selectedPage += 2;
            },
        }
    }
</script>
<style lang="scss" scoped>
    @import "../layouts/css/customvariables";
    .product-list {
        min-height: 450px;
        background: $white_color;
        border: 2px solid $border_color;
        position: relative;
        .product-footer {
            position: absolute;
            width: 100%;
            text-align: center;
            bottom: 25px;
            color: $grey_btn_color;
            label.ml-4 {
                cursor: pointer;
            }
            .page-nav {
                span {
                    cursor: pointer;
                }
                span:not(:last-child) {
                    border-right: 1px solid $border_color;
                    padding-right: 3px;
                }
            }
            .active {
                color: $footer_color;
            }
        }
    }
</style>
