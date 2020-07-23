import Vue from 'vue'
import axios from 'axios'

import store from './store'
import routes from './routes'
import App from './App'

// Vue.use(VueRouter);
Vue.http = {
    client: axios
};

new Vue({
    el: '#app',
    components: { App },
    store: store,
    router: routes,
})
