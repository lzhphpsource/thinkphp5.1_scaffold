const path = require('path')
const glob = require('glob')
const fs = require('fs')
const utils = require('./utils.js')
const config = require('./config')
const webpack = require('webpack')
const HtmlWebpackPlugin = require('html-webpack-plugin')
const CopyWebpackPlugin = require('copy-webpack-plugin')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const FriendlyErrorsPlugin = require('friendly-errors-webpack-plugin')
const UglifyPlugin = require('uglifyjs-webpack-plugin')
const { VueLoaderPlugin } = require('vue-loader')
const VueConfig = require('./vue.config.js')
const browserSync = require('browser-sync')

const assetsSubDirectory = process.env.NODE_ENV === 'prop'
    ? config.build.assetsSubDirectory
    : config.dev.assetsSubDirectory

function getEntry(globPath) {
    let entries = {},
        basename, tmp, pathname;

    glob.sync(globPath).forEach(function (entry) {
        // console.log(path.parse(entry))
        let ext = path.extname(entry)
        let tmp = path.parse(entry)
        pathname = tmp.dir.split('/').splice(-1) + '/' + tmp.name; // 正确输出js和html的路径
        entries[pathname] = entry;
    });
    return entries;
}
let entrys = getEntry('./webpack/src/pages/*/index.js')
const ouputFile = process.env.NODE_ENV === 'dev' ? '[name].js' : '[name].[chunkhash:8].js'

console.log(process.env.NODE_ENV)
module.exports = {
    devtool: process.env.NODE_ENV === 'dev' ? 'cheap-module-eval-source-map' : '#source-map',
    entry: entrys,
    mode: process.env.NODE_ENV === 'dev' ? 'development' : 'production',
    output: {
        path: path.join(__dirname, config.build.staticPath),
        publicPath: (process.env.NODE_ENV === 'dev' ? config.dev.assetsPublicPath : config.build.assetsPublicPath) + assetsSubDirectory + '/',
        filename: ouputFile,
        chunkFilename: process.env.NODE_ENV === 'dev' ? 'lib/js/[name].js' : 'lib/js/[name].[chunkhash:8].js'
    },
    externals: {
        'vue': 'Vue',
        'element-ui': 'ELEMENT',
        'axios': 'axios'
    },
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            'vue$': 'vue/dist/vue.js',
            '~': path.join(__dirname, 'src')
        }
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                use: ['babel-loader'],
                include: path.join(__dirname, './src'),
                exclude: /node_modules/
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: VueConfig
            },
            {
                test: /\.(mp4|webm|ogg|mp3|wav|flac|aac)(\?.*)?$/,
                loader: 'url-loader',
                options: {
                    limit: 10000,
                    name: utils.assetsPath('media/[name].[hash:7].[ext]')
                }
            },
            {
                test: /\.(png|jpg|gif)$/,
                use: [{
                    loader: 'url-loader',
                    options: {
                        limit: 10000,  //8k一下的转义为base64
                        name: utils.assetsPath('images/[name].[hash:7].[ext]')
                    }
                }]
            },
            {
                test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
                loader: 'url-loader',
                options: {
                    limit: 10000,
                    name: utils.assetsPath('fonts/[name].[hash:7].[ext]')
                }
            }
        ].concat(utils.styleLoaders({
            sourceMap: config.build.productionSourceMap,
            extract: process.env.NODE_ENV === 'prop',
            usePostCSS: true
        }))
    },
    node: {
        // prevent webpack from injecting useless setImmediate polyfill because Vue
        // source contains it (although only uses it if it's native).
        setImmediate: false,
        // prevent webpack from injecting mocks to Node native modules
        // that does not make sense for the client
        dgram: 'empty',
        fs: 'empty',
        net: 'empty',
        tls: 'empty',
        child_process: 'empty'
    },
    plugins: [
        new VueLoaderPlugin()
    ],
    optimization: {
        minimize: process.env.NODE_ENV === 'prop',
        minimizer: process.env.NODE_ENV === 'prop' ? [
            new UglifyPlugin({
                uglifyOptions: {
                    compress: {
                        // turn off flags with small gains to speed up minification
                        arrows: false,
                        collapse_vars: false, // 0.3kb
                        comparisons: false,
                        computed_props: false,
                        hoist_funs: false,
                        hoist_props: false,
                        hoist_vars: false,
                        inline: false,
                        loops: false,
                        negate_iife: false,
                        properties: false,
                        reduce_funcs: false,
                        reduce_vars: false,
                        switches: false,
                        toplevel: false,
                        typeofs: false,

                        // a few flags with noticable gains/speed ratio
                        // numbers based on out of the box vendor bundle
                        booleans: true, // 0.7kb
                        if_return: true, // 0.4kb
                        sequences: true, // 0.7kb
                        unused: true, // 2.3kb

                        // required features to drop conditional branches
                        conditionals: true,
                        dead_code: true,
                        evaluate: true
                    },
                    mangle: {
                        safari10: true
                    }
                },
                sourceMap: config.build.productionSourceMap,
                cache: true,
                parallel: true
            })
        ] : [],
        splitChunks: {
            cacheGroups: {
                vendor: {
                    test: /[\\/]node_modules[\\/]/,
                    name: 'common',
                    chunks: 'all'
                }
            }
        }
    }
}



let pages = getEntry('./webpack/src/pages/**/index.html');

for (let pathname in pages) {
    // 配置生成的html文件，定义路径等
    let conf = {
        filename: path.join(__dirname, config.build.templatePath, pathname + '.html'),
        template: pages[pathname], // 模板路径
        chunks: ['common', pathname], // 每个html引用的js模块
        inject: true              // js插入位置
    };
    // 需要生成几个html文件，就配置几个HtmlWebpackPlugin对象
    module.exports.plugins.push(new HtmlWebpackPlugin(conf));
}


if (process.env.NODE_ENV === 'prop') {
    // 清理打包目录
    function deleteFolderRecursive(path) {
        if( fs.existsSync(path) ) {
            fs.readdirSync(path).forEach(function(file) {
                var curPath = path + "/" + file;
                if(fs.statSync(curPath).isDirectory()) { // recurse
                    deleteFolderRecursive(curPath);
                } else { // delete file
                    fs.unlinkSync(curPath);
                }
            });
            fs.rmdirSync(path);
        }
    }
    deleteFolderRecursive(path.join(__dirname, config.build.staticPath))
    /*
    console.log(config.build.assetsRoot)
    module.exports.plugins.push(new CleanWebpackPlugin(['**.*'], {
      root: path.resolve(__dirname, config.build.assetsRoot),
      verbose: true,
      dry: true
    }))
    */
} else {

    module.exports.plugins.push(new webpack.HotModuleReplacementPlugin())
}

if (process.env.NODE_ENV === 'prop') {
    module.exports.plugins.push(new ExtractTextPlugin({
        filename: utils.assetsPath(process.env.NODE_ENV === 'prop' ? 'css/[name].[chunkhash:7].css' : 'css/[name].css'),
        allChunks: true
    }))
} else {
    browserSync({
        open: config.dev.open,
        host: config.dev.host,
        port: config.dev.port,
        proxy: config.dev.proxy,
        browser: config.dev.browser,
        files: [
            "./webpack/src/**/*.js",
            "./webpack/src/**/*.vue",
            "./webpack/src/**/*.css",
            "./webpack/src/**/*.scss",
            "./webpack/src/**/*.json",
            "./application/**/*.php",
            "./route/**/*.php",
            "./config/**/*.php",
            "./extend/**/*.php"
        ]
    })
    /*
    module.exports.plugins.push(new FriendlyErrorsPlugin({
        compilationSuccessInfo: {
            messages: [`Your application is running here: http://${module.exports.devServer.host}:${module.exports.devServer.port}`],
        },
        onErrors: utils.createNotifierCallback()
    }))
    */
}
