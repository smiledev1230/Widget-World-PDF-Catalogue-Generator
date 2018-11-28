import 'es6-promise/auto'
import Vue from 'vue'
import Vuex from 'vuex'
import mutations from './mutations'

Vue.use(Vuex)
function init() {

}
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
            id: null,
            name: null,
            file_name: null,
            file_upload_path: null,
            selectedImage: 0,
            page_columns: 3,
            display_type: true,
            logos_options: false,
            display_options: ['title', 'rrp', 'units'],
            barcode_options: false,
        },
        suppliers: [],
        supplierIds: [],
        suppliers_ids: [],
        sel_supplier_ids: [],
        categories: [],
        categoryIds: [],
        categories_ids: [],
        sel_category_ids: [],
        productData: [],
        blocks: [],
        product_new: [],
        user: {
            name: "Addision",
            email: "add@gmail.com",
            password: "123456",
            token: null
        }
    },
    mutations,
    actions: {
        initCatalogue() {
            this.state.catalogue = {
                id: null,
                name: null,
                file_name: null,
                file_upload_path: null,
                selectedImage: 0,
                page_columns: 3,
                display_type: true,
                logos_options: false,
                display_options: ['title', 'rrp', 'units'],
                barcode_options: false,
            }
            this.state.suppliers = this.state.suppliers_ids = this.state.sel_supplier_ids = this.state.categories = this.state.categories_ids = this.state.sel_category_ids = this.state.productData = [];
        }
    }
})
//=======vuex store end===========
export default store
