import Vue from 'vue'
import VueRouter from 'vue-router'
import KeRouter from '../../utils/vue-ke-router'
import Index from './routes/index'

Vue.use(VueRouter)


// 用户

// 顶级路由
const route = new KeRouter('index')

Index(route)


const r = new VueRouter({
    // 如需要使用history模式请去掉下面前面的//
    mode: 'history',

    // history模式开启下必须设置 /模块名/
    base: '/index/',
    routes: route.data
})


export default r
