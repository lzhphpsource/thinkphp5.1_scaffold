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
        $leftNav = [];
        $topNav  = [];
        if(!in_array(Session::get('user_auth_session.LoginId'), config('user_administrator'))){
            if (!$auth->check('/'.$request->module() . '/' . $request->controller() . '/' . $request->action(), Session::get('user_auth_session.LoginId'))) {// 第一个参数是规则名称,第二个参数是用户UID
                $this->error('你没有权限');
            }
            $getGroups = $auth->getGroups(Session::get('user_auth_session.LoginId'));

            $rules = '' ;

            foreach($getGroups as $k=>$v){
                if($v['rules']){
                    $rules .= $v['rules'].',';
                }
            }

            $pieces = explode(",", $rules);

            $rules = implode(',',array_unique(explode(',',$rules)));

            $hd_auth_rule = db("auth_rule")->where('id','in',$rules)->field('name,pid,id,level,title')->where('type',1)->where('is_display',1)->order('sort,id')->select();
            foreach ($hd_auth_rule as $key => $value) {
                if($value['level'] == 3 or $value['level'] == 4){
                    foreach ($pieces as $k => $v) {
                        if($v == $value['id']){
                            $leftNav[] =$value;
                        }
                    }
                } elseif($value['level'] == 2){
                    foreach ($pieces as $k => $v) {
                        if($v == $value['id']){
                            $topNav[] =$value;
                        }
                    }
                }
            }
        } else {
            $hd_auth_rule = db("auth_rule")->field('name,pid,id,level,title')->where('is_display',1)->where('name','like','/'.$request->module().'%')->order('sort,id')->select();
            foreach ($hd_auth_rule as $key => $value) {
                if($value['level'] == 3 or $value['level'] == 4){
                    $leftNav[] =$value;
                } elseif($value['level'] == 2){
                    $topNav[] =$value;
                }
            }
        }

        View::share('topNav',$topNav);
        View::share('leftNav',$leftNav);
        return $next($request);
    }
}