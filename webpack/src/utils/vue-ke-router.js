export default class KeRouter {
    data = []
    curr = 0
    $module = ''
    $options = null
    constructor (m) {
        this.$module = m
    }

    group (options, func) {
        this.curr = this.data.length
        this.$options = options
        func()
        this.$options = null
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
            component: () => import(`../../../application/${this.$module}/view/${path}.vue`)
        })
        this.curr = s - 1
        if (this.$options) {
            // console.log('路由分组配置', this.$options)
            this.data[this.curr].meta = Object.assign({}, this.data[this.curr].meta, this.$options)
        }
        return this
    }

    meta (obj) {
        this.data[this.curr].meta = Object.assign({}, this.data[this.curr].meta, obj)
        return this
    }

    children (call) {
        const route = new KeRouter(this.$module)
        call(route)
        this.data[this.curr].children = route.data
        return this
    }
}