<template>
    <div class="catalogue-content">
        <div class="row">
            <div class="col-md-8 pl-0 catalogue-left">
                <section class="content-header">
                    <h1 class="green-text-color">{{this.$store.state.page_title?this.$store.state.page_title:this.$route.meta.title}}</h1>
                    <p>{{this.$store.state.page_text}}</p>
                </section>
                <section class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Catalogue Name:</td>
                                <td>
                                    <input type="text" v-model="$store.state.catalogue.name" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>Catalogue Logo/Image:</td>
                                <td>
                                    <label for="fileUpload" class="select-label">
                                        {{$store.state.catalogue.file_name ? $store.state.catalogue.file_name : 'Select File'}}
                                    </label>
                                    <img src="~img/upload-icon.png" alt="upload icon" class="upload-icon" />
                                    <label for="fileUpload" class="btn greyBgColor text-white">UPLOAD</label>
                                    <input id="fileUpload" type="file" @change="onFileChange" />
                                </td>
                            </tr>
                            <tr>
                                <td>Front Cover Template:</td>
                                <td>
                                    <carousel
                                            :per-page="5"
                                            :navigationEnabled="true"
                                            :paginationEnabled="false" >
                                        <slide v-for="(coverImage, index) in imageList"
                                               :key="index"
                                               :class="{'select-image': $store.state.catalogue.selectedImage == coverImage.id}"
                                               @slideClick="handleSlideClick(index)">
                                            <img
                                                :src="coverImage.cover_url"
                                                v-bind:alt="coverImage"
                                                class="cover-image" />
                                        </slide>
                                    </carousel>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>
            </div>
            <div class="col-md-4 catalogue-right">
                <p class="text-center grey-text-color">PREVIEW</p>
                <div class="preview">
                    <img :src="getImgUrl()" class="preview-background"/>
                    <div class="preview-content">
                        <img :src="$store.state.catalogue.file_upload_path" v-if="$store.state.catalogue.file_upload_path" class="upload-image"/>
                        <div v-if="$store.state.catalogue.name" class="preview-title text-white">{{$store.state.catalogue.name}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-bottom">
            <hr/>
            <div class="row d-block">
                <router-link tag="a" to="/" exact class="btn btn-secondary text-white" @click.native="$store.dispatch('initCatalogue')">CANCEL</router-link>
                <router-link tag="a" to="/select_products" v-if="$store.state.catalogue.name" class="btn greenBgColor pull-right text-white">NEXT</router-link>
                <router-link tag="a" to="/select_products" v-else class="btn greenBgColor pull-right text-white" event="">NEXT</router-link>
            </div>
        </div>
    </div>
</template>
<script>
    import { Carousel, Slide } from 'vue-carousel';
    export default {
        name: "new_catalogue",
        components: {
            Carousel,
            Slide,
        },
        data() {
            return {
                imageList : [],
            }
        },
        mounted: function () {
            if (this.$store.state.suppliers.length == 0 && this.$store.state.categories.length == 0) this.$router.push("/");
            this.$store.state.page_text = "Create a new catalogue to send electronically to your clients/customers or get it professionally printed and take it with you\n" + "to your next meeting to wow your clients and increase conversions.";
            if (this.$store.new_state) {
                this.$store.dispatch('initCatalogue');
            }
            this.$store.new_state = true;
            this.getCovers();
        },
        methods: {
            getCovers() {
                this.imageList = [];
                let firstImage = {
                    id: 0,
                    cover_url: require('../../assets/img/covers/blank.jpg'),
                }
                this.imageList.push(firstImage);
                let app = this;
                axios.get('/api/getCovers').then(response => {
                    if (response && response.data) {
                        app.imageList = app.imageList.concat(response.data);
                    }
                });
            },
            handleSlideClick(index) {
                this.$store.state.catalogue.selectedImage = this.imageList[index]['id'];
            },
            getImgUrl() {
                for (let i=0; i<this.imageList.length;i++) {
                    if (this.imageList[i]['id'] == this.$store.state.catalogue.selectedImage) {
                        return this.imageList[i]['cover_url'];
                    }
                }
                return '';
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
                axios.post( '/api/uploadToS3',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(response => {
                    if (response.data) {
                        app.$store.state.catalogue.file_upload_path = response.data;
                        app.$store.state.catalogue.file_name = file.name;
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
    .catalogue-content {
        .row {
            .catalogue-left {
                display: table-cell;
                .dz-message {
                    position: relative;
                    span {
                        position: absolute;
                        top: -26px;
                        left: 260px;
                    }
                }
                input[type="file"] {
                    display: none;
                }
                .custom-file-upload {
                    border: 1px solid #ccc;
                    display: inline-block;
                    padding: 6px 12px;
                    cursor: pointer;
                }
            }
            .catalogue-right {
                display: table-cell;
                margin-bottom: 25px;
                text-align: center;
                .preview {
                    border-top: 1px solid $grey_color;
                    border-bottom: 1px solid $grey_color;
                    margin: 10px;
                    display: inline-grid;
                    .preview-background {
                        width: 100%;
                        min-width: 200px;
                    }
                    .preview-content {
                        max-width: 88%;
                        min-width: 200px;
                        margin-left: 6%;
                        margin-top: -100px;
                        .preview-title {
                            background: $red_color;
                            padding: 8px 5px;
                            min-height: 35px;
                            font-size: 16px;
                        }
                        .upload-image {
                            height: 85px;
                            margin-top: -80px;
                            max-height: 6vw;
                        }
                    }
                }

            }
            .btn {
                padding: 4px 18px;
                min-width: 85px;
            }
            .content-header {
                padding: 30px 0px;
            }
        }
        .table th, .table td {
            border-top: 0;
        }
        .table td:first-child {
            width: 210px;
            text-align: right;
            font-size: 16px;
        }
        .select-label {
            background: #ececec;
            color: $grey_color;
            padding: 5px 20px;
            line-height: 1.5;
            border-radius: 0.25rem;
            max-width: 250px;
            display: inline;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            cursor: pointer;
        }
        .upload-icon {
            width: 20px;
            margin:0 5px;
        }
        .VueCarousel {
            max-width: 350px;
            margin-left: 25px;
            .VueCarousel-slide {
                width: 80px;
                max-height: 95px;
                padding: 0 2px;
                border: 1px solid rgba(0, 0, 0, 0.1);
                img {
                    max-width: 100%;
                    max-height: 100%;
                    display: block;
                    cursor: pointer;
                }
            }
            .select-image {
                border: 2px solid rgba(0, 0, 0, 0.5);
            }
            .VueCarousel-navigation {
                .VueCarousel-navigation-prev, .VueCarousel-navigation-next {
                    height: 100%;
                    width: 25px;
                    background: rgba(0, 0, 0, 0.1);
                }
            }
        }

        hr {
            border-width: 2px;
            margin: 15px 0px;
        }
    }
</style>
