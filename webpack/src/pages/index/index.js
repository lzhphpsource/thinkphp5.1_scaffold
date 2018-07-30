import 'babel-polyfill'
import Vue from 'vue'
import router from './router.js'
import App from './index.vue'
import './http.js'

Vue.config.productionTip = false

console.log('hello')
new Vue({
    el: '#app',
    router,
    render: h => h(App)
})
