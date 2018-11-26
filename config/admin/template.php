<?php
// +----------------------------------------------------------------------
// | TpAndVue
// +----------------------------------------------------------------------
// | Author: King east <1207877378@qq.com>
// +----------------------------------------------------------------------

return [
    // 模板替换
    'tpl_replace_string'  =>  [
        '__ROOT__'     => Env::get('APP_PATH', '/'),
        '__BASE__'     => Env::get('APP_PATH', '/') . 'static/base',
        '__PUBLIC__'   => Env::get('APP_PATH', '/'),
        '__STATIC__'   => Env::get('APP_PATH', '/') . 'static',
        '__LIBS__'     => Env::get('APP_PATH', '/') . 'static/libs',
        '__ADMINCSS__' => Env::get('APP_PATH', '/') . 'static/admin/css',
        '__ADMINJS__'  => Env::get('APP_PATH', '/') . 'static/admin/js',
        '__ADMINIMG__' => Env::get('APP_PATH', '/') . 'static/admin/images',
        '__INDEXCSS__' => Env::get('APP_PATH', '/') . 'static/index/css',
        '__INDEXJS__'  => Env::get('APP_PATH', '/') . 'static/index/js',
        '__INDEXIMG__' => Env::get('APP_PATH', '/') . 'static/index/images',
    ],
];