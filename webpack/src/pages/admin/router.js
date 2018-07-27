import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
class KeRouter {
  data = []
  curr = 0
  constructor () {
  }

  reg (rule, path) {
    let name
    if (Array.isArray(rule)) {
      name = rule[0]
      rule = rule[1]
    } else {
      name = rule
    }
    const s = this.data.push({
      name: name,
      path: rule,
      component: () => import(`./views/${path}.vue`)
    })
    this.curr = s - 1
    return this
  }

  meta (obj) {
    this.data[this.curr].meta = obj
    return this
  }

  children (call) {
    const route = new KeRouter()
    call(route)
    this.data[this.curr].children = route.data
    return this
  }
}

// 用户

// 顶级路由
const route = new KeRouter()

route.reg(['index', '/'], 'index').meta({ title: 'title' })

route.reg('/users', 'user/index').meta({ title: '用户' })


const r = new VueRouter({
  routes: route.data
})


export default r
