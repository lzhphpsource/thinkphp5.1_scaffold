<?php
// 用户登录控制器
// +----------------------------------------------------------------------
// | PHP version 5.6+
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.bcahz.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: White to black <973873838@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\http\middleware;

class MemberLogin
{
    public function handle($request, \Closure $next)
    {

        if( !is_login() ) {
            return redirect('Login/index');
        }
        return $next($request);
    }
}