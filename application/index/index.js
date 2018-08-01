import 'babel-polyfill'
import Vue from 'vue'
import router from './utils/router.js'
import App from './index.vue'
import './utils/http.js'

Vue.config.productionTip = false

new Vue({
    el: '#app',
    router,
    render: h => h(App)
})
