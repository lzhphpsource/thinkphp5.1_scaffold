'use strict'
const utils = require('./utils')
const config = require('./config')
const isProduction = process.env.NODE_ENV === 'prop'
const sourceMapEnabled = isProduction
    ? config.build.productionSourceMap
    : config.dev.cssSourceMap

module.exports = {
    loaders: utils.cssLoaders({
        sourceMap: sourceMapEnabled,
        extract: isProduction
    }),
    cssSourceMap: sourceMapEnabled,

    cacheBusting: config.dev.cacheBusting,
    // 以前在写 Vue 的时候经常会写到这样的代码：把图片提前 require 传给一个变量再传给组件
    // vue-cli 的 webpack 模板下，默认配置
    // https://vue-loader-v14.vuejs.org/zh-cn/options.html#transformtorequire
    transformToRequire: {
        video: ['src', 'poster'],
        source: 'src',
        img: 'src',
        image: 'xlink:href'
    }
}
