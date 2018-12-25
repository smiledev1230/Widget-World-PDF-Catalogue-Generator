<template>
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
                        <div class="minus-btn" @click="deleteCover(i)">
                            <i class="fa fa-minus" aria-hidden="true"></i>
                        </div>
                        <div class="cover-backdrop"></div>
                    </div>
                </li>
            </ul>
        </div>
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
            deleteCover(i) {
                let selectedItem = this.covers[i];
                axios.post('/api/deleteCover', {id: selectedItem['id']}).then(response => {
                    if (response.data && response.data.message == 'success') {
                        this.covers.splice(i,1);
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
</style>



