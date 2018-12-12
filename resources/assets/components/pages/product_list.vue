<template>
    <div class="product-list" :class="{twoPages : $store.state.catalogue.page_columns == 2}">
        <div class="row product-body">
            <div class="col-6 nopadding page-separator">
                <div class="page-body">
                    <div v-for="rowInd in 3" class="row" v-bind:key="rowInd">
                        <div class="nopadding"
                             v-for="colInd in getCols($store.state.catalogue.page_columns)"
                             v-bind:key="colInd"
                             :class="$store.state.catalogue.page_columns == 2 ? 'col-6' : 'col-4'">
                            <div class="product-image" v-if="checkNewBlock(rowInd, colInd, 0) == 'block'">
                                <div class="plus-btn" @click="removeNewBlock(rowInd, colInd, 0)"><i class="fa fa-minus"
                                                                                                    aria-hidden="true"></i>
                                </div>
                                <div v-html="getProductTitle(rowInd, colInd, 0)" class="new-block"/>
                            </div>
                            <div class="product-image product-logo"
                                 v-else-if="checkNewBlock(rowInd, colInd, 0) == 'logo'">
                                <img :src="getImgUrl(rowInd, colInd, 0)"/>
                            </div>
                            <div class="product-image" v-else-if="getImgUrl(rowInd, colInd, 0)">
                                <div class="ribbon" @click="updateNewState(rowInd, colInd, 0)"
                                     :class="{active: checkNewState(rowInd, colInd, 0)}">NEW
                                </div>
                                <div class="plus-btn" @click="addNewBlock(rowInd, colInd, 0)"><i class="fa fa-plus"
                                                                                                 aria-hidden="true"></i>
                                </div>
                                <img :src="getImgUrl(rowInd, colInd, 0)"/>
                                <div class="product-box">
                                    <div class="product-title"
                                         v-if="$store.state.catalogue.display_options.indexOf('title')>= 0">
                                        {{getProductTitle(rowInd, colInd, 0)}}
                                    </div>
                                    <div>
                                        <div class="product-detail"
                                             v-if="$store.state.catalogue.display_options.indexOf('units')>= 0">
                                            {{getUnits(rowInd, colInd, 0)}} units per outer
                                        </div>
                                        <div class="product-detail pb-1">
                                            <div v-if="!$store.state.catalogue.barcode_options">
                                                {{getBarcodeNumber(rowInd, colInd, 0)}}
                                            </div>
                                            <div v-else-if="$store.state.catalogue.display_options.indexOf('rrp')>= 0"
                                                 class="redLabelColor">
                                                RRP ${{getRRP(rowInd, colInd, 0)}}
                                            </div>
                                        </div>
                                        <div class="barcode-image">
                                            <img v-if="$store.state.catalogue.barcode_options"
                                                 :src="getBarcodeImage(rowInd, colInd, 0)"/>
                                            <div v-else-if="$store.state.catalogue.display_options.indexOf('rrp')>= 0"
                                                 class="product-rrp">
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
                             v-for="rightCol in getCols($store.state.catalogue.page_columns)"
                             v-bind:key="rightCol"
                             :class="$store.state.catalogue.page_columns == 2 ? 'col-6' : 'col-4'">
                            <div class="product-image" v-if="checkNewBlock(rightRow, rightCol, 1) == 'block'">
                                <div class="plus-btn" @click="removeNewBlock(rightRow, rightCol, 1)"><i
                                        class="fa fa-minus" aria-hidden="true"></i></div>
                                <div v-html="getProductTitle(rightRow, rightCol, 1)" class="new-block"/>
                            </div>
                            <div class="product-image product-logo"
                                 v-else-if="checkNewBlock(rightRow, rightCol, 1) == 'logo'">
                                <img :src="getImgUrl(rightRow, rightCol, 1)"/>
                            </div>
                            <div class="product-image" v-else-if="getImgUrl(rightRow, rightCol, 1)">
                                <div class="ribbon" @click="updateNewState(rightRow, rightCol, 1)"
                                     :class="{active: checkNewState(rightRow, rightCol, 1)}">NEW
                                </div>
                                <div class="plus-btn" @click="addNewBlock(rightRow, rightCol, 1)"><i class="fa fa-plus"
                                                                                                     aria-hidden="true"></i>
                                </div>
                                <img :src="getImgUrl(rightRow, rightCol, 1)"/>
                                <div class="product-box">
                                    <div class="product-title"
                                         v-if="$store.state.catalogue.display_options.indexOf('title')>= 0">
                                        {{getProductTitle(rightRow, rightCol, 1)}}
                                    </div>
                                    <div>
                                        <div class="product-detail"
                                             v-if="$store.state.catalogue.display_options.indexOf('units')>= 0">
                                            {{getUnits(rightRow, rightCol, 1)}} units per outer
                                        </div>
                                        <div class="product-detail pb-1">
                                            <div v-if="!$store.state.catalogue.barcode_options">
                                                {{getBarcodeNumber(rightRow, rightCol, 1)}}
                                            </div>
                                            <div v-else-if="$store.state.catalogue.display_options.indexOf('rrp')>= 0"
                                                 class="redLabelColor">
                                                RRP ${{getRRP(rightRow, rightCol, 1)}}
                                            </div>
                                        </div>
                                        <div class="barcode-image">
                                            <img v-if="$store.state.catalogue.barcode_options"
                                                 :src="getBarcodeImage(rightRow, rightCol, 1)"/>
                                            <div v-else-if="$store.state.catalogue.display_options.indexOf('rrp')>= 0"
                                                 class="product-rrp">
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
        <b-modal id="blockModal" title="Add Block" ref="blockModal" v-model="showModal" class="catalogue-modal">
            <quill-editor :options="quilleditorOption" v-model="blockEditor" class="edi"></quill-editor>
            <div slot="modal-footer" class="w-100">
                <b-btn size="sm" class="btn-secondary pl-3 pr-3" variant="primary" @click="showModal=false">CANCEL
                </b-btn>
                <b-btn size="sm" class="float-right greenBgColor pl-3 pr-3" variant="primary" @click="addBlock()">ADD
                </b-btn>
            </div>
        </b-modal>
    </div>
</template>
<script>
    import Vue from 'vue';
    import VueQuillEditor from 'vue-quill-editor';

    Vue.use(VueQuillEditor);
    import 'codemirror/keymap/sublime';
    import 'codemirror/mode/javascript/javascript.js'

    // require styles
    import 'quill/dist/quill.core.css'
    import 'quill/dist/quill.snow.css'
    import 'quill/dist/quill.bubble.css'

    export default {
        name: "product_list",
        components: {},
        props: ['totalPages'],
        data() {
            return {
                selectedPage: 1,
                showModal: false,
                blockEditor: null,
                editorIndex: 1,
                quilleditorOption: {},
            }
        },
        mounted: function () {

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
                let index = this.getIndex(rowInd, colInd, backPage);
                if (this.$store.state.productData[index] && this.$store.state.productData[index]['name']) {
                    let imageUrl = this.$store.state.productData[index]['images'];
                    if (!imageUrl) imageUrl = require('../../assets/img/products/empty.jpg');
                    return imageUrl;
                } else {
                    return false;
                }
            },
            updateNewState(rowInd, colInd, backPage) {
                let index = this.getIndex(rowInd, colInd, backPage);
                let stateData = this.$store.state;
                let product = stateData.productData[index];
                this.$store.state.productData[index]['product_is_new'] = !product['product_is_new'];
                if (stateData.catalogue.display_type) {
                    if (product['product_is_new']) {
                        this.$store.state.supplier_new.push(product['id'])
                    } else if (stateData.supplier_new.indexOf(product['id'])>=0){
                        this.$store.state.supplier_new.splice(stateData.supplier_new.indexOf(product['id']),1);
                    }
                } else {
                    if (product['product_is_new']) {
                        this.$store.state.category_new.push(product['id'])
                    } else if (stateData.category_new.indexOf(product['id'])>=0){
                        this.$store.state.category_new.splice(stateData.category_new.indexOf(product['id']),1);
                    }
                }
            },
            checkNewState(rowInd, colInd, backPage) {
                return this.getProductInfo(rowInd, colInd, backPage, 'product_is_new')
            },
            addNewBlock(rowInd, colInd, backPage) {
                this.showModal = true;
                this.blockEditor = null;
                this.editorIndex = this.getIndex(rowInd, colInd, backPage);
                this.$refs.blockModal.show();
            },
            getIndex(rowInd, colInd, backPage) {
                let index = (this.selectedPage - 1 + backPage) * 3 * this.$store.state.catalogue.page_columns;
                index += (rowInd - 1) * this.$store.state.catalogue.page_columns + colInd - 1;
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
                this.showModal = false;
                let newBlock = {
                    id: new Date().getTime(),
                    name: this.blockEditor,
                    type: 'block'
                }
                this.$store.state.productData.splice(this.editorIndex, 0, newBlock);
                let product = this.$store.state.productData[this.editorIndex];
                if (this.$store.state.catalogue.display_type) {
                    this.$store.state.supplier_block.push({
                        id: product['id'],
                        name: this.blockEditor
                    });
                } else {
                    this.$store.state.category_block.push({
                        id: product['id'],
                        name: this.blockEditor
                    });
                }
            },
            checkNewBlock(rowInd, colInd, backPage) {
                return this.getProductInfo(rowInd, colInd, backPage, 'type');
            },
            removeNewBlock(rowInd, colInd, backPage) {
                let stateData = this.$store.state;
                let index = this.getIndex(rowInd, colInd, backPage);
                let product = stateData.productData[index+1];
                let searchIndex = null;
                let product_block = stateData.catalogue.display_type ? stateData.supplier_block : stateData.category_block;
                for (let i=0;i<product_block.length;i++) {
                    if (product['id'] == product_block[i]['id']) {
                        searchIndex = i;break;
                    }
                }
                if (searchIndex >= 0) {
                    if (stateData.catalogue.display_type) {
                        this.$store.state.supplier_block.splice(searchIndex, 1);
                    } else {
                        this.$store.state.category_block.splice(searchIndex, 1);
                    }
                }
                this.$store.state.productData.splice(index, 1);
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
            getCols(n) {
                let cols = [];
                for (let i = 1; i <= n; i++) {
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
        min-height: 735px;
        position: relative;
        .product-body {
            min-height: 690px;
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
                    min-height: 200px;
                    margin: 5px;
                    border: 1px solid $border_color;
                    overflow: hidden;
                    z-index: 999;
                    img {
                        width: 100%;
                        max-height: 58%;
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
                    .plus-btn {
                        position: absolute;
                        padding-left: 5px;
                        font-size: 18px;
                        color: #e6e6e6;
                        cursor: pointer;
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
                            font-size: 12px;
                            font-weight: bold;
                            position: absolute;
                            bottom: 35px;
                            width: 100%;
                        }
                        .product-detail {
                            max-width: 60%;
                            min-height: 14px;
                            padding-left: 5px;
                            font-size: 10px;
                            line-height: 14px;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            white-space: nowrap;
                        }
                        .barcode-image {
                            position: absolute;
                            bottom: 5px;
                            right: 2px;
                            max-width: 40%;
                        }
                        .product-rrp {
                            font-size: 11px;
                            line-height: 12px;
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
        min-height: 825px;
        .product-body {
            min-height: 780px;
        }
    }
</style>
