<template>
    <div class="tree-view">
        <ejs-treeview id='treeview' :fields="fields" showCheckBox='true'></ejs-treeview>
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
        data() {
            var dataSource =  [
                { id: 1, name: 'AIT'},
                { id: 2, name: 'Accredited'},
                { id: 3, name: 'Allseps'},
                { id: 4, name: 'Arnotts'},
                { id: 5, name: 'Bayer'},
                { id: 6, name: 'Bounce'},
                { id: 7, name: 'Bundaberg'},
                { id: 8, name: 'CTC'},
                { id: 9, name: 'Cadbury', hasChild: true },
                { id: 10, pid: 9, name: 'Bars'},
                { id: 11, pid: 9, name: 'Biscuits', hasChild: true },
                { id: 12, pid: 11, name: 'Biscuits - Chocolate', hasChild: true },
                { id: 13, pid: 12, name: 'Belvita Choc Breakfast Biscuits 300g'},
                { id: 14, pid: 12, name: 'Cadbury Cookies Choc Centre 300g'},
                { id: 15, pid: 12, name: 'Oreo Cadbury Coated 6pk 204g'},
                { id: 16, pid: 12, name: 'Oreo Cookie Chocolate 137g'},
                { id: 17, pid: 12, name: 'Oreo Cookie Grab \\\'n\\\' Go 264.6g'},
                { id: 18, pid: 12, name: 'Oreo Cookie Original 137g'},
                { id: 19, pid: 9, name: 'Biscuits - Other'},
            ];
            return {
                fields: { dataSource: dataSource, id: 'id', parentID: 'pid', text: 'name', hasChildren: 'hasChild' },
                checkedNodes: ['2','6']
            }
        },
        computed: {

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
