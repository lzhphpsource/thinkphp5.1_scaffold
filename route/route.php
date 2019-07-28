<?php


use think\facade\Route;

// 默认是域名分组
Route::group('[:api]',function (){
    Route::get(':ver/news', 'index/:ver.news/index');

    Route::post(':ver/login', 'index/:ver.auth/login');
})->prefix('api/')->pattern('ver','\w\d');

//Route::alias('user','index/User');
//
//Route::bind('index');
//
//Route::resource('blog','index/blog');
//
//Route::domain('blog', function () {
//    // 动态注册域名的路由规则
//    Route::rule('new/:id', 'index/news/read');
//    Route::rule(':user', 'index/user/info');
//});
//
//Route::group('blog',[
//    ':id'   => ['Blog/read', ['method' => 'get'], ['id' => '\d+']],
//    ':name' => ['Blog/read', ['method' => 'post']],
//]);

// 绑定泛二级域名域名到book模块,如果规则是字符串，则表示绑定
//Route::domain('*','admin?name=*');
//Route::get('admin/','/member/avatar/id/');
//Route::get('/function', '\admin@method');