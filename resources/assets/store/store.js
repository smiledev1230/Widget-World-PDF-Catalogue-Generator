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
            display_type: 1,
            logos_options: 0,
            display_options: ['title', 'rrp', 'units'],
            barcode_options: 0,
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
                display_type: 1,
                logos_options: 0,
                display_options: ['title', 'rrp', 'units'],
                barcode_options: 0,
            }
            this.state.sel_supplier_ids = this.state.sel_category_ids = this.state.productData = [];
            for (let i=0;i<this.state.suppliers.length;i++) {
                this.state.suppliers[i]['isChecked'] = false;
            }
            for (let j=0;j<this.state.categories.length;j++) {
                this.state.categories[j]['isChecked'] = false;
            }
        }
    }
})
//=======vuex store end===========
export default store
