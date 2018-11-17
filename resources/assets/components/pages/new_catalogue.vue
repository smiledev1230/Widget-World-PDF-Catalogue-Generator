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
                                    <input type="text" v-model="catalogue_name" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>Catalogue Logo/Image:</td>
                                <td>
                                    <div class="select-label">{{uploadFileName}}</div>
                                    <img src="~img/upload-icon.png" alt="upload icon" class="upload-icon" />
                                    <label for="file-upload" class="btn greyBgColor text-white">UPLOAD</label>
                                    <input id="file-upload" type="file" @change="onFileChange" />
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
                                               @slideClick="handleSlideClick(index)">
                                            <img
                                                    :src="getImgUrl(index)"
                                                    v-bind:alt="coverImage"
                                                    :class="{'select-image': selectedImage == index}"
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
                    <img :src="getImgUrl(selectedImage)" class="preview-background"/>
                    <div class="preview-content">
                        <img :src="uploadFileUrl" v-if="uploadFileUrl" class="upload-image"/>
                        <div v-if="catalogue_name" class="preview-title text-white">{{catalogue_name}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-bottom">
            <hr/>
            <div class="row d-block">
                <router-link tag="a" to="/" exact class="btn btn-secondary text-white">CANCEL</router-link>
                <router-link tag="a" to="/select_products" class="btn greenBgColor pull-right text-white" @click.native="saveCatalogue">NEXT</router-link>
            </div>
        </div>
    </div>
</template>
<script>
    import { Carousel, Slide } from 'vue-carousel';
    import { coverImages } from '../../assets/js/global_variable';
    export default {
        name: "new_catalogue",
        components: {
            Carousel,
            Slide,
        },
        data() {
            return {
                imageList : coverImages,
                selectedImage: 0,
                catalogue_name: this.$store.state.catalogue.name,
                instance: "",
                options: {
                    url: 'https://httpbin.org/post',
                    paramName: 'file',
                    autoProcessQueue: false,
                    maxFiles: {
                        limit: 5,
                        message: 'You can only upload a max of 5 files'
                    }
                },
                uploadFileName: 'Select File',
                uploadFileUrl: ''
            }
        },
        mounted: function () {
            this.$store.state.page_text = "Create a new catalogue to send electronically to your clients/customers or get it professionally printed and take it with you\n" + "to your next meeting to wow your clients and increase conversions.";
        },
        methods: {
            handleSlideClick(index) {
                this.selectedImage = index;
            },
            getImgUrl(index) {
                return require('../../assets/img/covers/' + this.imageList[index]);
            },
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                this.uploadFileName = file.name;
                var uploadFileUrl = new Image();
                var reader = new FileReader();
                var vm = this;
                reader.onload = (e) => {
                    vm.uploadFileUrl = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            saveCatalogue(event) {
                this.$store.state.catalogue.name = this.catalogue_name;
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
                        max-width: 100%;
                        max-height: 70%;
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
                        }
                        .upload-image {
                            height: 65px;
                            margin-top: -80px;
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
        }
        .upload-icon {
            width: 20px;
            margin:0 5px;
        }
        .VueCarousel {
            max-width: 350px;
            margin-left: 25px;
            .VueCarousel-slide {
                max-width: 70px;
                padding: 0 2px;
                img {
                    max-width: 64px;
                    border: 1px solid rgba(0, 0, 0, 0.1);
                    cursor: pointer;
                }
                .select-image {
                    border: 2px solid rgba(0, 0, 0, 0.5);
                }
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
