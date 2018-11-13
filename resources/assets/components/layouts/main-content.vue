<template>
    <aside class="main-content">
        <!-- Content Header (Page header) -->
        <template v-if="isShow()">
            <section class="content-header" :class="{catalogueHeader: catalogue}">
                <h1>{{this.$store.state.page_title?this.$store.state.page_title:this.$route.meta.title}}</h1>
                <p v-if="this.$store.state.page_text" class="mb-1">{{this.$store.state.page_text}}</p>
                <p v-if="this.$store.state.page_subText" class="mb-1">{{this.$store.state.page_subText}}</p>
            </section>
            <!-- Main content -->
        </template>
        <section class="content">
            <slot></slot>
        </section>
        <!-- /.content -->
    </aside>
</template>
<script>
    export default {
        name: "main-content",
        data() {
            return {
                isShowTitle: true,
                catalogue: false,
            };
        },
        methods: {
            isShow() {
                this.catalogue = this.$route.meta.catalogue;
                if (this.$route.meta.isShowTitle === false) {
                    return false;
                } else {
                    return true;
                }
            }
        },
        mounted() {},
    }
</script>
<style lang="scss" scoped>
    @import "./css/customvariables";
    .content-header {
        padding: 25px 40px 10px 55px;
        background: $header_color;
        h1 {
            color: $green_color;
        }
    }
    .catalogueHeader {
        padding: 2vw 7vw 10px 7vw;
    }
</style>
