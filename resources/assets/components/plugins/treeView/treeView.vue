<template>
    <div class="tree-view">
        <zk-table
                ref="table"
                sum-text="sum"
                index-text="#"
                :data="data"
                :columns="columns"
                :stripe="props.stripe"
                :border="props.border"
                :show-header="props.showHeader"
                :show-summary="props.showSummary"
                :show-row-hover="props.showRowHover"
                :show-index="props.showIndex"
                :tree-type="props.treeType"
                :is-fold="props.isFold"
                :expand-type="props.expandType"
                :selection-type="props.selectionType">
        </zk-table>
    </div>
</template>
<script>
    import ZkTable from 'vue-table-with-tree-grid';

    export default {
        name: 'treeView',
        components: {
            'zk-table': ZkTable,
        },
        data() {
            return {
                props: {
                    stripe: false,
                    border: false,
                    showHeader: true,
                    showSummary: false,
                    showRowHover: true,
                    showIndex: false,
                    treeType: true,
                    isFold: true,
                    expandType: false,
                    selectionType: true,
                },
                data: [
                    {
                        name: 'Jack',
                        stateLabel: 'Add All',
                    },
                    {
                        name: 'Accredited',
                        stateLabel: 'Add All',
                    },
                    {
                        name: 'Allseps',
                        stateLabel: 'Add All',
                    },
                    {
                        name: 'Arnotts',
                        stateLabel: 'Add All',
                    },
                    {
                        name: 'Bayer',
                        stateLabel: 'Add All',
                    },
                    {
                        name: 'Bounce',
                        stateLabel: 'Add All',
                    },
                    {
                        name: 'Bundaberg',
                        stateLabel: 'Add All',
                    },
                    {
                        name: 'CTC',
                        stateLabel: 'Add All',
                    },
                    {
                        name: 'Cadbury',
                        stateLabel: 'Add All',
                        children: [
                            {
                                name: 'Bars',
                                stateLabel: 'Add All',
                            },
                            {
                                name: 'Biscuits',
                                stateLabel: 'Add All',
                                children: [
                                    {
                                        name: 'Biscuits - All',
                                        stateLabel: 'Add All',
                                    },
                                    {
                                        name: 'Biscuits - Chocolate',
                                        stateLabel: 'Add All',
                                        children: [
                                            {
                                                name: 'Belvita Choc Breakfast Biscuits 300g',
                                                stateLabel: 'Add All',
                                            },
                                            {
                                                name: 'Cadbury Cookies Choc Centre 300g',
                                                stateLabel: 'Add All',
                                            },
                                            {
                                                name: 'Oreo Cadbury Coated 6pk 204g',
                                                stateLabel: 'Add All',
                                            },
                                            {
                                                name: 'Oreo Cookie Chocolate 137g',
                                                stateLabel: 'Add All',
                                            },
                                            {
                                                name: 'Oreo Cookie Grab \'n\' Go 264.6g',
                                                stateLabel: 'Add All',
                                            },
                                            {
                                                name: 'Oreo Cookie Original 137g',
                                                stateLabel: 'Add All',
                                            },
                                        ]
                                    },
                                    {
                                        name: 'Biscuits - Other',
                                        stateLabel: 'Add All',
                                    },
                                ]
                            },
                            {
                                name: 'Bulk',
                                stateLabel: 'Add All',
                            },
                        ]
                    },
                ],
                columns: [
                    {
                        label: '',
                        prop: 'name',
                        minWidth: '200px',
                    },
                    {
                        label: 'Select All',
                        prop: 'stateLabel',
                        width: '120px'
                    },
                ],
            }
        },
        computed: {
            propList() {
                return Object.keys(this.props).map(item => ({
                    name: item,
                }));
            },
        },
        methods: {
        },
    };
</script>
<style lang="scss">
    @import "../../layouts/css/customvariables";
    .tree-view .zk-table {
        border: none;
        .zk-table__header-row {
            background: none;
            .zk-checkbox-wrapper {
                position: absolute;
                right: 25px;
                margin-top: -13px;
            }
            .zk-table__header-cell {
                text-align: right;
                padding-right: 50px;
                .zk-table__cell-inner {
                    padding: 0;
                }
            }
        }
        .zk-table__body-wrapper {
            height: 408px !important;
            max-height: 420px;
            overflow-y: scroll;
            border: solid $border_color;
            border-width: 2px 1px 1px 1px;
            .zk-table__body-row {
                height: 32px;
                background-color: #fafafa;
                .zk-table__cell-inner {
                    padding: 0;
                    .zk-checkbox-wrapper {
                    /*    position: absolute;
                        right: 25px;
                        margin-top: -13px;  */
                        margin-left: 20px;
                    }
                }
                .zk-table__body-cell:last-child {
                    text-align: right;
                    padding-right: 32px;
                }
            }
            .zk-table__body-row:nth-child(odd) {
                background-color: #f1f1f1;
            }
        }
    }
</style>
