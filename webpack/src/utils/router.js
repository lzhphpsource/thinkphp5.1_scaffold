export default class KeRouter {
    data = []
    curr = 0
    $module = ''
    constructor (m) {
        this.$module = m
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
            component: () => import(`../pages/${this.$module}/views/${path}.vue`)
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