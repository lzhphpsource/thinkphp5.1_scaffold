<style scoped lang="scss">
</style>

<template>
    <section>
        <a href="javascript:;" @click="onClearRows">清空</a>
        <a href="javascript:;" @click="onLoad">重新加载</a>
        <router-link tag="a" :to="{ name: 'login' }">查看表单栗子</router-link>
        <div v-if="rows.length === 0">
            正在加载中
        </div>
        <ul v-else>
            <li v-for="item in rows" :key="item.id">{{ item.title }}</li>
        </ul>
    </section>
</template>

<script>
    import { Vue, Component } from 'vue-property-decorator'

    @Component
    export default class Index extends Vue {
        rows = []

        mounted () {
            this.rows = []
            this.onLoad()
        }

        onLoad () {
            this.$http.get('news')
                .then(result => {
                    console.log(result)
                    this.rows = result.data.data
                })
        }

        onClearRows () {
            this.rows = []
            alert('数据清除完成')
        }
    }
</script>
