<template>
    <div class="tree-view">
        <ejs-treeview id='treeview' :fields="setFields" v-if="showCheck && treeData" showCheckBox="true"></ejs-treeview>
        <ejs-treeview id='treeview' :fields="setFields" v-else></ejs-treeview>
    </div>
</template>
<script>
    import Vue from 'vue';
    import { TreeViewPlugin } from "@syncfusion/ej2-vue-navigations";
    Vue.use(TreeViewPlugin);

    export default {
        name: 'treeView',
        components: {

        },
        props: {
            showCheck: Boolean,
            treeData: {
                default() {
                    return []
                }
            },
        },
        data() {
            return {
                checkedNodes: [
                    '2',
                    '6'],
            }
        },
        mounted() {

        },
        computed: {
            setFields() {
                return {
                    dataSource: this.treeData,
                    id: 'id',
                    parentID: 'pid',
                    text: 'name',
                    hasChildren: 'hasChild'
                }
            }
        },
        methods: {
            nodeChecked: function(args) {
                var treeObj = document.getElementById('treeview').ej2_instances[0];
                alert("The checked node's id: " + treeObj.checkedNodes); // To alert the checked node's id.
            }
        },
    };
</script>
<style lang="scss">
    @import "../../layouts/css/customvariables";
    @import "../../../assets/css/ej2-base-material.css";
    @import "../../../assets/css/ej2-vue-navigations-material.css";
    @import "../../../assets/css/ej2-buttons-material.css";
    .tree-view {
        .e-treeview {
            height: 408px;
            max-height: 420px;
            border: 1px solid $border_color;
            overflow-y: scroll;
        }
        .e-treeview > .e-list-parent.e-ul {
            padding-left: 0;
        }
    }
</style>
