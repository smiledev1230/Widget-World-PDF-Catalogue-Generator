<template>
    <div>
        <vueadmin_header></vueadmin_header>
        <div class="wrapper row-offcanvas" v-bind:class="{ greyBackground: this.$route.meta.bgColor}">
            <main_content>
                <transition name="router-anim">
                    <router-view/>
                </transition>
            </main_content>
        </div>
        <vueadmin_footer></vueadmin_footer>
    </div>
</template>
<script>
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
            vueadmin_header,
            main_content,
            vueadmin_footer,
            anime
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
        methods: {
            isShow() {
                if (this.$route.meta.isShowTitle === false) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "./assets/sass/animate.3.5.1";
    @import "./components/layouts/css/customvariables";
    .wrapper.greyBackground {
        background: $content_bgColor;
        margin-top: 125px;
    }
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

    .router-anim-enter-active {
        animation: coming .6s;
        animation-delay: .5s;
        opacity: 0;
    }
    .router-anim-leave-active {
        animation: going .6s;
    }
    @keyframes going {
        from {
            transform: translateX(0);
        }
        to {
            transform: translateX(-50px);
            opacity: 0;
        }
    }
    @keyframes coming {
        from {
            transform: translateX(-50px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>
