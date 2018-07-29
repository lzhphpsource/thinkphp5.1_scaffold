<?php
// +----------------------------------------------------------------------
// | 路易通碎屏保
// +----------------------------------------------------------------------
// | Author: King east <1207877378@qq.com>
// +----------------------------------------------------------------------


namespace app\index\controller;


use think\facade\App;

class ErrorController
{
    public function index()
    {
        return view(App::getAppPath() . 'index/view/404.html');
    }

}