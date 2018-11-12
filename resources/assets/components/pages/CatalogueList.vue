<template>
    <div class="catalogue-list">
        <ul class="task_block1">
            <li v-for="(catalogue,index) in catalogues" :key="index" class="task_block">
                <div>
                    <span class="catalogue-title">{{catalogue.title}} - </span>
                    <span class="catalogue-label" :class="labelColor[catalogue.state]">{{catalogueLabel[catalogue.state]}}</span>
                    <div v-if="catalogue.state == 0" class="pull-right">
                        <button class="btn text-white yellowColor">CONTINUE</button>
                    </div>
                    <div v-else class="pull-right btn-group">
                        <i class="fa fa-file-pdf-o mr-2"></i>
                        <i class="fa fa-edit mr-2"></i>
                        <i class="fa fa-envelope-o mr-2"></i>
                        <i class="fa fa-trash"></i>
                    </div>
                </div>
                <hr />
                <div class="catalogue-history">
                    <div v-if="catalogue.state == 0">{{catalogue.date}}</div>
                    <div v-else-if="catalogue.state == 1">{{catalogue.date}} - PDF Saved</div>
                    <div v-else>
                        <p v-for="history in catalogue.history">{{history.date}} - PDF sent to {{history.emails}}</p>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "CatalgoueList",
        components: {},
        data() {
            return {
                catalogues : [
                    {
                        id: 1,
                        title: 'Catalogue Name One',
                        state: 0,
                        date: '13/07/2018'
                    },
                    {
                        id: 2,
                        title: 'Catalogue Name Two',
                        state: 2,
                        history: [
                            {
                                date: '02/07/2018',
                                emails: 'karen@brandzonline.com.au; james@ketcocreative.com.au'
                            }
                        ]
                    },
                    {
                        id: 3,
                        title: 'Catalogue Name Three',
                        state: 1,
                        date: '20/06/2018'
                    },
                    {
                        id: 4,
                        title: 'Catalogue Name Four',
                        state: 2,
                        history: [
                            {
                                date: '08/07/2018',
                                emails: 'admin@brandzonline.com.au'
                            },
                            {
                                date: '20/06/2018',
                                emails: 'karen@brandzonline.com.au; james@ketcocreative.com.au'
                            }
                        ]
                    }
                ],
                catalogueLabel: ['Draft', 'PDF', 'PDF SENT'],
                labelColor: ['yellowColor', 'blueColor', 'greenColor']
            }
        },
        mounted: function () {

        },
        methods: {

        }
    }
</script>
<style lang="scss" scoped>
@import "../layouts/css/customvariables";
.catalogue-list {
    margin: 0 20px 0 0;
    .task_block {
        border: 1px solid $border_color;
        padding: 10px 15px;
        margin: 10px 0;
        box-shadow: 0 0 2px $border_color;
    }
    .task_block:hover {
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }
    .task_block1 {
        padding: 0;
    }
    .task_input {
        border-radius: 5px;
        padding: 5px;
        border-width: 1px;
        width: 90%;
    }
    .task_block {
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .task_block i,
    .marker,
    .send-btn {
        cursor: pointer;
    }

    .catalogue-title {
        font-size: 16px;
    }
    .catalogue-label {
        color: $white_color;
        padding: 2px 10px;
        border-radius: 0;
        text-transform: uppercase;
        background: $yellow_color;
    }
    .yellowColor {
        background: $yellow_color;
    }
    .blueColor {
        background: $blue_color;
    }
    .greenColor {
        background: $green_color;
    }
    .btn.yellowColor {
        padding: 2px 20px;
        margin: 0;
    }
    .pull-right.btn-group {
        padding-top: 5px;
        i {
            font-size: 20px;
            color: $grey_color;
        }
    }
    .pull-right.btn-group .fa.fa-file-pdf-o {
        font-size: 19px;
    }
    .pull-right.btn-group .fa.fa-edit {
        font-size: 21px;
    }
    hr {
        border-width: 2px;
        margin: 10px 0px;
    }
    .catalogue-history {
        color: $grey_color;
        p {
            margin-bottom: 0px;
        }
    }

    @media screen and (max-width: 575px) {
        .task_block1 input {
            margin-left: -10px;
        }
    }
}
</style>
