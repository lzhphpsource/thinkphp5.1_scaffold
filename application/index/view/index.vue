<style scoped lang="scss">
    .bg {
        width: 100px;
        height: 100px;
        // resources/static下的文件可以直接使用绝对路径/static来访问
        background: url('/static/images/2.png') no-repeat;
        -webkit-background-size: cover;
        background-size: cover;
    }
    .bg2 {
        width: 100px;
        height: 100px;
        // 直接引入相对资源也是可以的,这样的资源会经过webpack的打包处理
        background: url('./assets/images/1.png') no-repeat;
        -webkit-background-size: cover;
        background-size: cover;
    }
</style>

<template>
    <section>
        <!-- resources/static下的文件可以直接使用绝对路径/static来访问 -->
        <div class="bg"></div>
        <div class="bg2"></div>
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
