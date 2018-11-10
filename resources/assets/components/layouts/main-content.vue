<template>
    <aside class="main-content">
        <!-- Content Header (Page header) -->
        <template v-if="isShow()">
            <section class="content-header">
                <h1>{{this.$store.state.page_title?this.$store.state.page_title:this.$route.meta.title}}</h1>
                <p>{{this.$store.state.page_text}}</p>
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
            };
        },
        methods: {
            isShow() {
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
</style>
