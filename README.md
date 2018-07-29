ThinkPHP 5.1 + Vue 自动化构建解决方案
===============

### 依赖nodejs yarn,请先安装好Nodejs与yarn

nodejs: http://nodejs.cn/
yarn:   https://yarn.bootcss.com/

调试项目,启动调试服务器,自动代理到设置的服务器
```
yarn dev
```

编译项目,自动化把模板文件处理好.注意不要直接修改打包目录的文件,每次打包都会清空
```
yarn build
```


新的文件夹结构 - TP有的就不多说了
```
/webpack 构建目录
  config  构建配置
  src   源码仓库,即你编写模板代码的地方
    pages  页面
      ***  模块,这个模块名会成为打包后的 public/***/index.html
  static 静态文件目录,此目录下的文件都会原样复制到资源打包目录,使用绝对路径引入资源/static

```


使用教程
```
1.首先clone项目
2.控制台执行composer install 与 yarn初始化
3.等待yarn依赖安装完成
4.执行yarn dev 启动调试项目
```

默认的配置已经可以用了,如需定义请到:webpack/config/index.js修改

关于如何访问TP接口问题
```
由于webpack/config/index.js 23行默认配置了后端接口,所以可以直接使用调试服务器IP:  localhost:8080/api 来访问到后端
```

关于KeRouter路由,本人小写的一个方便注册vue-router的class
```
// 顶级路由
const route = new KeRouter('index')

route.reg(['index', '/'], 'index').meta({ title: 'title' })

// route.reg('/users', 'user/index').meta({ title: '用户' })

route.reg('/login', 'login').meta({ title: '登录' })

// 调用route.data即可获得格式化好的路由表

// 嵌套怎么写?
route.reg('/iframe', 'iframe').children(route => {
    route.reg('/iframe/main', 'iframe/main')
    // 支持无限.children嵌套哦
})

// 关于命名路由
route.reg(['name', '/'], 'index')
// 此处的name则是命名名

```

_TP5交流群 by 316497602_
