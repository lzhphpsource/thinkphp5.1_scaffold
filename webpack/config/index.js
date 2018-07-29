'use strict'
// Template version: 1.3.1
// see http://vuejs-templates.github.io/webpack for documentation.

const path = require('path')

module.exports = {
    // 静态文件根目录
    assetsPublicPath: '/',
    // 静态文件目录
    assetsSubDirectory: 'static',

    dev: {

        // 是否自动打开浏览器
        open: false,
        // 调试服务器主机名
        host: 'localhost', // can be overwritten by process.env.HOST
        // 调试服务器端口
        port: 8080, // can be overwritten by process.env.PORT, if port is in use, a free one will be determined

        // 代理到后端
        proxyTable: {
            '/api': {
                target: 'http://localhost/api',
                ws: true,
                changeOrigin: true
                /*
                pathRewrite: {
                  '^/api': ''
                }
                */
            }
        },
        // https://webpack.js.org/configuration/devtool/#development
        devtool: 'cheap-module-eval-source-map',

        // If you have problems debugging vue-files in devtools,
        // set this to false - it *may* help
        // https://vue-loader.vuejs.org/en/options.html#cachebusting
        cacheBusting: true,

        cssSourceMap: true
    },

    build: {
        // 模板编译保存目录
        templatePath: '../public',
        // 静态文件编译保存目录
        staticPath: '../public/static',

        assetsPublicPath: '/',
        assetsSubDirectory: 'static',

        /**
         * Source Maps
         */

        productionSourceMap: true,
        // https://webpack.js.org/configuration/devtool/#production
        devtool: '#source-map',

        // Gzip off by default as many popular static hosts such as
        // Surge or Netlify already gzip all static assets for you.
        // Before setting to `true`, make sure to:
        // npm install --save-dev compression-webpack-plugin
        productionGzip: false,
        productionGzipExtensions: ['js', 'css'],

        // Run the build command with an extra argument to
        // View the bundle analyzer report after build finishes:
        // `npm run build --report`
        // Set to `true` or `false` to always turn it on or off
        bundleAnalyzerReport: process.env.npm_config_report
    }
}
