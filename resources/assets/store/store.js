import 'es6-promise/auto'
import Vue from 'vue'
import Vuex from 'vuex'
import mutations from './mutations'

Vue.use(Vuex)

//=======vuex store start===========
const store = new Vuex.Store({
    state: {
        left_open: true,
        preloader: true,
        site_name: "Widget World PDF Catalogue Generator",
        page_title: null,
        page_text: null,
        page_subText: null,
        login_status: false,
        catalogue: {
            name: null,
            page_columns: 3,
            display_type: true,
            logos_options: false,
            display_options: ['title', 'rrp', 'units'],
            barcode_options: false,
        },
        suppliers: [],
        categories: [],
        productData: [],
        user: {
            name: "Addision",
            email: "add@gmail.com",
            password: "123456",
            token: null
        }
    },
    mutations
})
//=======vuex store end===========
export default store
