<template>
    <div>
        <preloader v-show="this.$store.state.preloader"></preloader>
        <vueadmin_header></vueadmin_header>
        <div class="wrapper row-offcanvas">
            <main_content>
                <router-view></router-view>
            </main_content>
        </div>
        <vueadmin_footer></vueadmin_footer>
    </div>
</template>
<script>
    /**
     * These are the files that enable you to change layouts and other options
     */

    /**
     * import preloader
     * choose from preloader and bounce
     */
    import preloader from 'components/layouts/preloader/preloader'

    /**
     * import from header or fixed-header or no-header
     */
    import vueadmin_header from 'components/layouts/fixed-header'

    /**
     * The main content
     */
    import main_content from 'components/layouts/main-content'

    /**
     * import from header or fixed-header or no-header
     */
    import vueadmin_footer from 'components/layouts/fixed-footer'

    /**
     * Main stylesheet for the layout
     */
    import 'assets/sass/custom.scss'
    import 'components/layouts/css/main.scss'

    /**
     * import animejs for the menu transition effects
     */
    import anime from 'animejs'

    export default {
        name: 'layout',
        components: {
            preloader,
            vueadmin_header,
            main_content,
            vueadmin_footer
        },
        data() {
            return {
                showtopbtn: false
            }
        },
        mounted() {
            if (window.innerWidth <= 992) {
                this.$store.commit('left_menu', 'close')
            }
        },

    }
</script>
<style lang="scss" scoped>
    .wrapper:before,
    .wrapper:after {
        display: table;
        content: " ";
    }

    .wrapper:after {
        clear: both;
    }

    .wrapper {
        display: table;
        overflow-x: hidden;
        width: 100%;
        max-width: 100%;
        table-layout: fixed
    }

    .right-aside,
    .left-aside {
        padding: 0;
        display: table-cell;
        vertical-align: top;
    }

    .right-aside {
        background-color: #ebf2f6 !important;
    }

    @media (max-width: 992px) {
        .wrapper>.right-aside {
            width: 100vw;
            min-width: 100vw;
        }
    }
</style>
