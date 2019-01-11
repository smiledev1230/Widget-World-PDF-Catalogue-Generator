<template>
    <div>
        <div class="front-cover">
            <div class="cover-content">
                <ul class="cover-list">
                    <li class="cover-item">
                        <div class="cover-body">
                            <label for="fileUpload" class="btn add-cover">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </label>
                            <input id="fileUpload" type="file" @change="onFileChange" />
                        </div>
                    </li>
                    <li v-for="(cover, i) in covers" class="cover-item" :key="i">
                        <div class="cover-body">
                            <img :src="cover.cover_url" class="cover-image" />
                            <div class="minus-btn" @click="openCoverModal(i)">
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </div>
                            <div class="cover-backdrop"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <b-modal id="deleteModal" title="Delete Cover" ref="deleteModal" v-model="deleteModal"
                 class="catalogue-modal">
            <div class="cover-modal-body">
                <p>Are you sure you would like to delete this cover?</p>
                <img :src="getSelectedImage()"/>
            </div>
            <div slot="modal-footer" class="w-100">
                <b-btn class="pl-3 pr-3" @click="deleteModal=false">NO</b-btn>
                <b-btn class="float-right greenBgColor pl-3 pr-3" @click="deleteCover">YES</b-btn>
            </div>
        </b-modal>
    </div>
</template>
<script>
    export default {
        name: "front_cover",
        components: {

        },
        data() {
            return {
                covers: [],
                deleteModal: false,
                selectedCover: 0,
            }
        },
        mounted: function () {
            if (this.$store.state.suppliers.length == 0 && this.$store.state.categories.length == 0) this.$router.push("/");
            this.$store.state.page_text = "";
            this.getCovers();
        },
        methods: {
            getCovers() {
                this.covers = [];
                axios.get('/api/getCovers').then(response => {
                    if (response && response.data) {
                        this.covers = response.data;
                    }
                });
            },
            getSelectedImage() {
                if (this.covers[this.selectedCover]) {
                    return this.covers[this.selectedCover]['cover_url'];
                } else {
                    return '';
                }
            },
            openCoverModal(i) {
                this.selectedCover = i;
                this.deleteModal = true;
                this.$refs.deleteModal.show();
            },
            deleteCover() {
                this.deleteModal = false;
                let selectedItem = this.covers[this.selectedCover];
                axios.post('/api/deleteCover', {id: selectedItem['id']}).then(response => {
                    if (response.data && response.data.message == 'success') {
                        this.covers.splice(this.selectedCover,1);
                    }
                });
            },
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                let file = files[0];
                let formData = new FormData();
                formData.append('file', file);
                formData.append('file_name', file.name);
                let app = this;
                axios.post( '/api/addCover',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(response => {
                    if (response.data) {
                        app.covers.push(response.data);
                    }
                }).catch(function(){
                    console.log('FAILURE!!');
                });
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "../layouts/css/customvariables";
    .front-cover {
        position: relative;
        min-height: 56vh;
        margin: 0 7vw 2vw;
        padding: 20px;
        background: $row_even_color;
        border: 2px solid $border_color;
        input[type="file"] {
            display: none;
        }
        .cover-content {
            width: 100%;
            height: 100%;
            min-height: 50vh;
            padding: 20px;
            background: $white_color;
            border: 2px solid $border_color;
        }
        .cover-list {
            overflow: hidden;
            display: flex;
            display: -webkit-flex;
            display: -ms-flexbox;
            flex-wrap: wrap;
            -webkit-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            list-style-image: none;
            list-style-position: outside;
            list-style-type: none;
            padding: 0;
            margin: 0 0 0 12px;
            .cover-item {
                float: left;
                width: 150px;
                height: 212px;
                margin: 0 12px 12px 0;
                cursor: pointer;
                display: flex;
                display: -webkit-flex;
                display: -ms-flexbox;
                .cover-body {
                    position: relative;
                    width: 100%;
                    text-align: center;
                    padding: 5px;
                    border: 2px solid $border_color;
                    .cover-image {
                        max-width: 100%;
                        max-height: 100%;
                    }
                    .minus-btn {
                        display: none;
                        position: absolute;
                        width: 100%;
                        height: 100%;
                        top: 0;
                        left: 0;
                        text-align: right;
                        z-index: 99;
                        .fa-minus {
                            font-size: 22px;
                            margin: 10px 15px 0 0;
                            color: #000;
                            cursor: pointer;
                        }
                    }
                    .cover-backdrop {
                        opacity: 0;
                        position: absolute;
                        width: 100%;
                        height: 100%;
                        top: 0;
                        left: 0;
                        background: #000;
                        z-index: 2;
                    }
                    .add-cover {
                        text-align: center;
                        width: 100%;
                        height: 100%;
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        .fa-plus {
                            font-size: 32px;
                            color: $grey_color;
                        }
                    }
                }
                .cover-body:hover {
                    .cover-backdrop {
                        opacity: 0.3;
                    }
                    .minus-btn {
                        display: block;
                    }
                }
            }
        }
    }
    .cover-modal-body {
        text-align: center !important;
        margin-right: 40px;
        img {
            width: 100px;
            height: auto;
            border: 1px solid $border_color;
        }
    }
</style>



