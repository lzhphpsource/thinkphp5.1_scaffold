import Vue from 'vue'
import VueRouter from 'vue-router'
import KeRouter from '../../utils/router'

Vue.use(VueRouter)


// 用户

// 顶级路由
const route = new KeRouter('index')

route.reg(['index', '/'], 'index').meta({ title: 'title' })

route.reg('/users', 'user/index').meta({ title: '用户' })


const r = new VueRouter({
  routes: route.data
})


export default r
