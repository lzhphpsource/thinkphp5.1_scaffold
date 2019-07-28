<?php
// 后台权限控制器
// +----------------------------------------------------------------------
// | PHP version 5.6+
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.bcahz.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: White to black <973873838@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\http\middleware;
use think\facade\Session;
use think\facade\View;
use traits\controller\Jump;

class Auth
{
    use Jump;


    public function handle($request, \Closure $next)
    {
        $auth = new \auth\Auth;
        $leftNav = []; // 左侧导航菜单
        $topNav = []; // 顶部导航菜单

        // 如果登录用户不是管理员，则需要检查权限
        if (!in_array(Session::get('user_auth_session.LoginId'), config('user_administrator'))) {
            // 首先检查该用户是否具有当前动作权限
            if (!$auth->check('/' . $request->module() . '/' . $request->controller() . '/' . $request->action(), Session::get('user_auth_session.LoginId'))) {// 第一个参数是规则名称,第二个参数是用户UID
                $this->error('你没有权限');
            }
            // 如果用户具有该动作权限，则获取用户权限组
            $getGroups = $auth->getGroups(Session::get('user_auth_session.LoginId'));

            $rules = '';

            foreach ($getGroups as $k => $v) {
                if ($v['rules']) {
                    $rules .= $v['rules'] . ',';
                }
            }

            $pieces = explode(",", $rules);
            // 去除重复权限规则
            $rules = implode(',', array_unique(explode(',', $rules)));

            // 根据权限id,查询权限信息
            $hd_auth_rule = db("auth_rule")->where('id', 'in', $rules)->field('name,pid,id,level,title')->where('type', 1)->where('is_display', 1)->order('sort,id')->select();
            foreach ($hd_auth_rule as $key => $value) {
                if ($value['level'] == 3 or $value['level'] == 4) {
                    foreach ($pieces as $k => $v) { // TODO 多余代码？？
                        if ($v == $value['id']) {
                            $leftNav[] = $value;
                        }
                    }
                } elseif ($value['level'] == 2) {
                    foreach ($pieces as $k => $v) { // TODO 多余代码？？
                        if ($v == $value['id']) {
                            $topNav[] = $value;
                        }
                    }
                }
            }
        } else { // 如果是管理员，则具有所有权限，所以获取所有菜单项
            $hd_auth_rule = db("auth_rule")->field('name,pid,id,level,title')->where('is_display', 1)->where('name', 'like', '/' . $request->module() . '%')->order('sort,id')->select();
            foreach ($hd_auth_rule as $key => $value) {
                if ($value['level'] == 3 or $value['level'] == 4) {
                    $leftNav[] = $value;
                } elseif ($value['level'] == 2) {
                    $topNav[] = $value;
                }
            }
        }

        View::share('topNav', $topNav);
        View::share('leftNav', $leftNav);
        return $next($request);
    }
}