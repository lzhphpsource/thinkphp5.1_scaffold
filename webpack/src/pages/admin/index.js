import 'babel-polyfill'
import router from './router.js'
import App from './index.vue'

Vue.config.productionTip = false

new Vue({
  el: '#app',
  router,
  render: h => h(App)
})
