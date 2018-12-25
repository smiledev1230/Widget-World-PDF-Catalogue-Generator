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
        preloader: false,
        site_name: "Widget World PDF Catalogue Generator",
        page_title: null,
        page_text: null,
        page_subText: null,
        new_state: true,
        catalogue: {
            id: null,
            name: null,
            file_name: null,
            file_upload_path: null,
            selectedImage: 0,
            coverPath: '',
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
        supplier_block: [],
        category_block: [],
        supplier_new: [],
        category_new: [],
        drag_supplier_ids: [],
        drag_category_ids: [],
        supplierBrand: '',
        user: {
            id: null,
            group_id: null,
            name: "Addision",
            email: "add@gmail.com",
            password: "123456",
            token: null,
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
                coverPath: '',
                page_columns: 3,
                display_type: 1,
                logos_options: 0,
                display_options: ['title', 'rrp', 'units'],
                barcode_options: 0,
            }
            this.state.sel_supplier_ids
                = this.state.sel_category_ids
                = this.state.productData
                = this.state.supplier_block
                = this.state.category_block
                = this.state.supplier_new
                = this.state.category_new
                = this.state.drag_supplier_ids
                = this.state.drag_category_ids
                = [];
            for (let i=0;i<this.state.suppliers.length;i++) {
                this.state.suppliers[i]['isChecked'] = false;
            }
            for (let j=0;j<this.state.categories.length;j++) {
                this.state.categories[j]['isChecked'] = false;
            }
        },
        initProductData() {
            this.state.productData
                = this.state.suppliers
                = this.state.categories
                = [];
        }
    }
})
//=======vuex store end===========
export default store
