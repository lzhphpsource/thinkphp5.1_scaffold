<style scoped lang="scss">
    .main {
        margin: 0 auto;
        max-width: 500px;
        background: #fff;
        border: solid 1px #ddd;
        padding: 15px;
    }
    input {
        outline: none;
        width: 100%;
        border: solid 1px #4288ce;
        padding: 10px;
        color: #888;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .login-btn {
        background: #000088;
        border: solid 1px #000088;
        padding: 6px 15px;
        width: 140px;
        color: #fff;
        text-align: center;
    }
</style>

<template>
    <section>
        <div class="bg"></div>
        <div class="main">
            <h1>登录demo</h1>
            <p>
                <input v-model="form.username" placeholder="请输入登录帐号">
            </p>
            <p>
                <input v-model="form.password" placeholder="请输入登录密码">
            </p>

            <p style="text-align: right">
                <button class="login-btn" @click="onLogin">登录</button>
            </p>
        </div>
    </section>
</template>

<script>
    import { Vue, Component } from 'vue-property-decorator'

    @Component
    export default class Index extends Vue {
        form = {}

        onLogin () {
            this.$http.post('login', this.form)
                .then(result => {
                    console.log('看看后端获取到了什么', result.data)
                    alert('post请求成功,请到控制台查看信息')
                })
        }
    }
</script>
