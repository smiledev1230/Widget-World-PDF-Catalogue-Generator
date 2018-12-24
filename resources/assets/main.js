import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store/store.js'

window.axios = require('axios')
axios.defaults.headers.common = {
    // 'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

Vue.component(
    'passport-clients',
    require('../js/components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('../js/components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('../js/components/passport/PersonalAccessTokens.vue')
);

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
})
