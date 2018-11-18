<template>
    <div class="product-list" :class="{twoPages : $store.state.catalogue.pageColumns == 2}">
        <div class="row product-body">
            <div class="col-6 nopadding page-separator">
                <div class="page-body">
                    <div v-for="rowInd in 3" class="row" v-bind:key="rowInd">
                        <div class="nopadding"
                             v-for="colInd in getCols($store.state.catalogue.pageColumns)"
                             v-bind:key="colInd"
                             :class="$store.state.catalogue.pageColumns == 2 ? 'col-6' : 'col-4'">
                            <div class="product-image" v-if="checkNewBlock(rowInd, colInd, 0) == 'block'">
                                <div v-html="getProductTitle(rowInd, colInd, 0)" class="new-block" />
                            </div>
                            <div class="product-image product-logo" v-else-if="checkNewBlock(rowInd, colInd, 0) == 'logo'">
                                <img :src="getLogoUrl()" />
                            </div>
                            <div class="product-image" v-else-if="getImgUrl(rowInd, colInd, 0)" >
                                <div class="ribbon" v-if="checkNewState(rowInd, colInd, 0)" :class="{active: checkNewState(rowInd, colInd, 0)}">NEW</div>
                                <img :src="getImgUrl(rowInd, colInd, 0)"/>
                                <div class="product-box">
                                    <div class="product-title"
                                        v-if="$store.state.catalogue.titleOptions.indexOf('title')>= 0" >
                                        {{getProductTitle(rowInd, colInd, 0)}}
                                    </div>
                                    <div>
                                        <div class="product-detail"
                                             v-if="$store.state.catalogue.titleOptions.indexOf('units')>= 0">
                                            {{getUnits(rowInd, colInd, 0)}} units per outer
                                        </div>
                                        <div class="product-detail pb-1">
                                            <div v-if="!$store.state.catalogue.barcodeOptions">
                                                {{getBarcodeNumber(rowInd, colInd, 0)}}
                                            </div>
                                            <div v-else-if="$store.state.catalogue.titleOptions.indexOf('rrp')>= 0" class="redLabelColor">
                                                RRP ${{getRRP(rowInd, colInd, 0)}}
                                            </div>
                                        </div>
                                        <div class="barcode-image">
                                            <img v-if="$store.state.catalogue.barcodeOptions"
                                                 :src="getBarcodeImage(rowInd, colInd, 0)" />
                                            <div v-else-if="$store.state.catalogue.titleOptions.indexOf('rrp')>= 0" class="product-rrp">
                                                RRP<br/>${{getRRP(rowInd, colInd, 0)}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-footer">
                    <span class="page-label">Page {{selectedPage}}</span>
                    <span class="pull-right pr-3">{{$store.state.catalogue.name}}</span>
                </div>
            </div>
            <div class="col-6 nopadding">
                <div class="page-body">
                    <div v-for="rightRow in 3" class="row" v-bind:key="rightRow">
                        <div class="nopadding"
                             v-for="rightCol in getCols($store.state.catalogue.pageColumns)"
                             v-bind:key="rightCol"
                             :class="$store.state.catalogue.pageColumns == 2 ? 'col-6' : 'col-4'">
                            <div class="product-image" v-if="checkNewBlock(rightRow, rightCol, 1)">
                                <div v-html="getProductTitle(rightRow, rightCol, 1)" class="new-block" />
                            </div>
                            <div class="product-image" v-else-if="getImgUrl(rightRow, rightCol, 1)" >
                                <div class="ribbon" v-if="checkNewState(rightRow, rightCol, 1)" :class="{active: checkNewState(rightRow, rightCol, 1)}">NEW</div>
                                <img :src="getImgUrl(rightRow, rightCol, 1)"/>
                                <div class="product-box">
                                    <div class="product-title"
                                         v-if="$store.state.catalogue.titleOptions.indexOf('title')>= 0" >
                                        {{getProductTitle(rightRow, rightCol, 1)}}
                                    </div>
                                    <div>
                                        <div class="product-detail"
                                             v-if="$store.state.catalogue.titleOptions.indexOf('units')>= 0">
                                            {{getUnits(rightRow, rightCol, 1)}} units per outer
                                        </div>
                                        <div class="product-detail pb-1">
                                            <div v-if="!$store.state.catalogue.barcodeOptions">
                                                {{getBarcodeNumber(rightRow, rightCol, 1)}}
                                            </div>
                                            <div v-else-if="$store.state.catalogue.titleOptions.indexOf('rrp')>= 0" class="redLabelColor">
                                                RRP ${{getRRP(rightRow, rightCol, 1)}}
                                            </div>
                                        </div>
                                        <div class="barcode-image">
                                            <img v-if="$store.state.catalogue.barcodeOptions"
                                                 :src="getBarcodeImage(rightRow, rightCol, 1)" />
                                            <div v-else-if="$store.state.catalogue.titleOptions.indexOf('rrp')>= 0" class="product-rrp">
                                                RRP<br/>${{getRRP(rightRow, rightCol, 1)}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-footer">
                    <span class="pl-3 right-label">{{$store.state.catalogue.name}}</span>
                    <span class="page-label pull-right">Page {{selectedPage + 1}}</span>
                </div>
            </div>
        </div>
        <div class="product-footer">
            <label class="pull-left ml-2" :class="{active: selectedPage > 1}" @click="prevPage">
                <i class="fa fa-chevron-left" aria-hidden="true"></i> Previous
            </label>
            <label class="page-nav">
                <span :class="{active: getNavIndex() == 0}" @click="updatePageNav(0)" v-if="getPageNav(0)">{{getPageNav(0)}}</span>
                <span :class="{active: getNavIndex() == 1}" @click="updatePageNav(1)" v-if="getPageNav(1)">{{getPageNav(1)}}</span>
                <span :class="{active: getNavIndex() == 2}" @click="updatePageNav(2)" v-if="getPageNav(2)">{{getPageNav(2)}}</span>
                <span :class="{active: getNavIndex() == 3}" @click="updatePageNav(3)" v-if="getPageNav(3)">{{getPageNav(3)}}</span>
            </label>
            <label class="pull-right mr-2" :class="{active: selectedPage < totalPages-1}" @click="nextPage">
                Next <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </label>
        </div>
    </div>
</template>
<script>
    export default {
        name: "product_preview",
        components: {
        },
        data() {
            return {
                selectedPage: 1,
                totalPages: 1,
            }
        },
        mounted: function () {
            this.totalPages = Math.round(this.$store.state.productData.length/3/this.$store.state.catalogue.pageColumns + 0.5);
        },
        methods: {
            prevPage() {
                this.selectedPage -= 2;
                if (this.selectedPage < 1) this.selectedPage = 1;
            },
            getNavIndex() {
                return (this.selectedPage - 1) / 2 % 4;
            },
            updatePageNav(index) {
                this.selectedPage += (index - this.getNavIndex()) * 2;
            },
            getPageNav(index) {
                let firstPageNumber = this.selectedPage + (index - this.getNavIndex()) * 2;
                if (firstPageNumber > this.totalPages) return;
                return firstPageNumber + "-" + (firstPageNumber + 1);
            },
            nextPage() {
                if (this.selectedPage >= (this.totalPages - 1)) return;
                this.selectedPage += 2;
            },
            getImgUrl(rowInd, colInd, backPage) {
                let imageUrl = this.getProductInfo(rowInd, colInd, backPage, 'images');
                if (imageUrl) {
                    return require('../../assets/img/products/' + imageUrl);
                } else {
                    return;
                }
            },
            checkNewState(rowInd, colInd, backPage) {
                return this.getProductInfo(rowInd, colInd, backPage, 'product_is_new')
            },
            getIndex(rowInd, colInd, backPage) {
                let index = (this.selectedPage - 1 + backPage) * 3 * this.$store.state.catalogue.pageColumns;
                index += (rowInd - 1) * this.$store.state.catalogue.pageColumns + colInd - 1;
                return index;
            },
            getProductInfo(rowInd, colInd, backPage, type, failure = '') {
                let index = this.getIndex(rowInd, colInd, backPage);
                if (this.$store.state.productData[index] && this.$store.state.productData[index][type]) {
                    return this.$store.state.productData[index][type];
                } else {
                    return failure;
                }
            },
            addBlock() {
                this.showModal=false;
                var newBlock = {
                    id: new Date().getTime(),
                    name: this.blockEditor,
                    type: 'block'
                }
                this.$store.state.productData.splice(this.editorIndex, 0, newBlock);
            },
            checkNewBlock(rowInd, colInd, backPage) {
                return this.getProductInfo(rowInd, colInd, backPage, 'type');
            },
            getProductTitle(rowInd, colInd, backPage) {
                return this.getProductInfo(rowInd, colInd, backPage, 'name');
            },
            getBarcodeImage(rowInd, colInd, backPage) {
                let failure = require("../../assets/img/products/barcode.png");
                return this.getProductInfo(rowInd, colInd, backPage, 'barcode_image', failure);
            },
            getUnits(rowInd, colInd, backPage) {
                return this.getProductInfo(rowInd, colInd, backPage, 'items_per_outer', 0);
            },
            getRRP(rowInd, colInd, backPage) {
                return this.getProductInfo(rowInd, colInd, backPage, 'rrp', '0.00');
            },
            getBarcodeNumber(rowInd, colInd, backPage) {
                return this.getProductInfo(rowInd, colInd, backPage, 'barcode_unit');
            },
            getLogoUrl() {
                if (this.$store.state.productData[0]['image']) {
                    return require("../../assets/img/products/" + this.$store.state.productData[0]['image']);
                } else {
                    return;
                }
            },
            getCols(n) {
                let cols = [];
                for (let i=1; i<=n;i++) {
                    cols.push(i);
                }
                return cols;
            },
        }
    }
</script>
<style lang="scss" scoped>
    @import "../layouts/css/customvariables";
    .product-list {
        min-height: 830px !important;
        position: relative;
        .product-body {
            min-height: 785px !important;
            background: $white_color;
            border: 2px solid $border_color;
            .page-separator {
                border-right: 2px solid $border_color;
            }
            .page-body {
                height: 100%;
                padding: 15px 15px 40px;
                .product-logo {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    border: none !important;
                }
                .product-image {
                    position: relative;
                    height: calc(100% - 10px);
                    min-height: 232px;
                    margin: 5px;
                    border: 1px solid $border_color;
                    overflow: hidden;
                    z-index: 999;
                    img {
                        width: 100%;
                        height: auto;
                    }
                    .ribbon {
                        text-align: center;
                        transform: rotate(45deg);
                        padding: 3px 0;
                        top: 5px;
                        right: -20px;
                        width: 75px;
                        background-color: $menu_active;
                        color: #fff;
                        position: absolute;
                        font-size: 12px;
                        font-weight: bold;
                        z-index: 1;
                        cursor: pointer;
                    }
                    .ribbon.active {
                        background-color: $red_label_color;
                    }
                    .new-block {
                        height: 100%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }
                    .product-box {
                        position: absolute;
                        width: 100%;
                        bottom: 0px;
                        .product-title {
                            min-height: 36px;
                            text-align: center;
                            padding: 0px 5px;
                            font-size: 13px;
                            font-weight: bold;
                            position: absolute;
                            bottom: 42px;
                            width: 100%;
                        }
                        .product-detail {
                            max-width: 60%;
                            min-height: 18px;
                            padding-left: 8px;
                            font-size: 12px;
                            line-height: 18px;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            white-space: nowrap;
                        }
                        .barcode-image {
                            position: absolute;
                            bottom: 5px;
                            right: 8px;
                            max-width: 40%;
                        }
                        .product-rrp {
                            font-size: 12px;
                            line-height: 16px;
                            color: $red_label_color;
                        }
                    }
                }
            }
            .page-footer {
                position: absolute;
                width: 100%;
                bottom: 10px;
                .page-label {
                    background: $green_color;
                    color: $white_color;
                    padding: 2px 10px;
                }
                .right-label {
                    padding-top: 4px;
                    display: inline-block;
                }
            }
        }
        .product-footer {
            position: absolute;
            width: 100%;
            text-align: center;
            bottom: 10px;
            color: $grey_btn_color;
            label.ml-4, label:first-child, label:last-child {
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
        .redLabelColor {
            color: $red_label_color;
        }
    }
    .twoPages {
        min-height: 1065px !important;
        .product-body {
            min-height: 1020px;
            .product-box {
                .product-detail {
                    line-height: 24px;
                }
                .product-rrp {
                    line-height: 20px;
                }
            }
        }
    }
</style>
