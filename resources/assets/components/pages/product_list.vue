<template>
    <div class="product-list">
        <div class="row product-body">
            <div class="col-6 nopadding">
                <div class="page-body">
                    <div v-for="rowInd in 3" class="row">
                        <div class="nopadding"
                             v-for="colInd in $store.state.catalogue.pageColumns"
                             :class="$store.state.catalogue.pageColumns == 2 ? 'col-6' : 'col-4'">
                            <div class="product-image" v-if="getImgUrl(rowInd, colInd, 0)" >
                                <div class="ribbon" @click="updateNewState(rowInd, colInd, 0)" :class="{active: checkNewState(rowInd, colInd, 0)}">NEW</div>
                                <div class="plus-btn" @click="addNewBlock(rowInd, colInd, 0)"><i class="fa fa-plus" aria-hidden="true"></i></div>
                                <img :src="getImgUrl(rowInd, colInd, 0)"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-footer">
                    <span class="page-label">Page 1</span>
                    <span class="pull-right pr-3">{{$store.state.catalogue.name}}</span>
                </div>
            </div>
            <div class="col-6 nopadding">
                <div class="page-body">
                    <div v-for="rightRow in 3" class="row">
                        <div class="nopadding"
                             v-for="rightCol in $store.state.catalogue.pageColumns"
                             :class="$store.state.catalogue.pageColumns == 2 ? 'col-6' : 'col-4'">
                            <div class="product-image" v-if="getImgUrl(rightRow, rightCol, 1)" >
                                <div class="ribbon" @click="updateNewState(rightRow, rightCol, 1)" :class="{active: checkNewState(rightRow, rightCol, 1)}">NEW</div>
                                <img :src="getImgUrl(rightRow, rightCol, 1)"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-footer">
                    <span class="pl-3 right-label">{{$store.state.catalogue.name}}</span>
                    <span class="page-label pull-right">Page 2</span>
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
        <b-modal id="blockModal" title="Add Block" ref="blockModal" v-model="showModal">
            <b-card class="bg-primary-card">
                <quill-editor :content="content" :options="quilleditorOption" ref="myTextEditor" @change="onEditorChange($event)" class="edi"></quill-editor>
            </b-card>
            <div slot="modal-footer" class="w-100">
                <b-btn size="sm" class="btn-secondary pl-3 pr-3" variant="primary" @click="showModal=false">CANCEL</b-btn>
                <b-btn size="sm" class="float-right greenBgColor pl-3 pr-3" variant="primary" @click="showModal=false">ADD</b-btn>
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
        components: {
        },
        props: ['productData'],
        data() {
            console.log("productData.length", this.productData.length);
            var total_pages = Math.round(this.productData.length/3/this.$store.state.catalogue.pageColumns + 0.5);
            return {
                selectedPage: 1,
                totalPages: total_pages,
                showModal: false,
                content: '<h2>Vue quill Editor</h2>',
                code: 'const a = 10',
                quilleditorOption: {
                    // some quill options
                },
                editorOptions: {
                    // codemirror options
                    tabSize: 4,
                    mode: 'text/javascript',
                    theme: 'monokai',
                    lineNumbers: true,
                    line: true,
                    keyMap: "sublime",
                    extraKeys: {
                        "Ctrl": "autocomplete"
                    },
                    foldGutter: true,
                    gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
                    styleSelectedText: true,
                    highlightSelectionMatches: {
                        showToken: /\w/,
                        annotateScrollbar: true
                    }
                }
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
                if (!this.productData[index]) return;
                return require('../../assets/img/products/' + this.productData[index]['images']);
            },
            updateNewState(rowInd, colInd, backPage) {
                let index = this.getIndex(rowInd, colInd, backPage);
                this.productData[index]['product_is_new'] = !this.productData[index]['product_is_new'];
            },
            checkNewState(rowInd, colInd, backPage) {
                let index = this.getIndex(rowInd, colInd, backPage);
                return this.productData[index]['product_is_new'];
            },
            addNewBlock(rowInd, colInd, backPage) {
                this.showModal = true;
                this.$refs.blockModal.show();
            },
            getIndex(rowInd, colInd, backPage) {
                let index = (this.selectedPage - 1 + backPage) * 3 * this.$store.state.catalogue.pageColumns;
                index += (rowInd - 1) * this.$store.state.catalogue.pageColumns + colInd - 1;
                return index;
            },
        }
    }
</script>
<style lang="scss" scoped>
    @import "../layouts/css/customvariables";
    .product-list {
        min-height: 590px;
        position: relative;
        .product-body {
            min-height: 540px;
            background: $white_color;
            border: 2px solid $border_color;
            .col-6:first-child {
                border-right: 2px solid $border_color;
            }
            .page-body {
                height: 100%;
                padding: 15px 15px 40px;
                .product-image {
                    position: relative;
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
                        -webkit-transform: rotate(45deg);
                        -moz-transform: rotate(45deg);
                        -ms-transform: rotate(45deg);
                        -o-transform: rotate(45deg);
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
                        background-color: #a30c11;
                    }
                    .plus-btn {
                        position: absolute;
                        padding-left: 5px;
                        font-size: 18px;
                        color: #e6e6e6;
                        cursor: pointer;
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
    }
</style>
