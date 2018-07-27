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
      ***  模块,这个模块名会成为打包后的 ***/index.html

```


使用教程
```
1.首先clone项目
2.控制台执行composer install 与 yarn初始化
3.等待yarn依赖安装完成
4.执行yarn dev 启动调试项目
```

默认的配置已经可以用了,如需定义请到:webpack/config/index.js修改


_TP5交流群 by 316497602_
