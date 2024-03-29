<?php
// 登录控制器       
// +----------------------------------------------------------------------
// | PHP version 5.6+
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.bcahz.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: White to black <973873838@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;
use app\common\controller\Base;
use think\captcha\Captcha;
use app\admin\model\AuthGroupAccess;
class Login extends Base
{

    function initialize()
    {
        parent::initialize();
        $this->authgroupaccess_model   = new AuthGroupAccess();
    }

    /**
     * 验证码设置
     * @return \think\Response
     */
    public function verify()
    {
        $captcha = new Captcha(config('captcha.'));
        return $captcha->entry();
    }
    /**
     * [index 登录主页]
     */
    public function index($loginId = '', $password = '', $verify = '')
    {
        if (IS_POST) {
            $captcha = new Captcha();
            if (!$captcha->check($verify)) {
                $this->error('验证码错误');
            }
            // 需要校验的数据
            $data = [
                'loginId' => $loginId,
                'password' => $password,
                'verify' => $verify
            ];

            // 调用独立校验器
            $login_validate = new \app\admin\validate\Login;

            // 数据校验
            if (!$login_validate->check($data)) {
                $this->error($login_validate->getError());
            }

            // 登录状态
            $uuid = $this->member_model->login($loginId, $password, $type = 6);

            if (0 < $uuid) {
                if ($loginId != '15875546804') {
                    // 如果不是超级管理员，则需要查看用户是否具有管理权限
                    if (!$this->authgroupaccess_model->where('uid', $uuid)->count()) {
                        $this->error('非管理员，请忽操作！');
                    } else {

                        /**
                         * 登录成功，过滤是否合法管理员操作
                         * 可以根据用户不同的类型跳转致不同的应用接口
                         * 例如：超级管理员、管理员、商户、代理
                         */
                        $this->success('登录中...', 'admin/index/index');
                        // if (is_administrator($uuid)) {
                        //     $this->success('登录中...', 'Admin/Index/index');
                        // } else {
                        //     $this->error('非法管理员，请勿操作！');
                        // }
                    }
                } else {
                    $this->success('登录中...', 'admin/index/index');
                }
            } else {
                /* 登录失败根据模型数据处理任意扩展 */
                switch ($uuid) {
                    case -1:
                        $error = '用户不存在';
                        break;
                    case -2:
                        $error = '用户被禁用';
                        break;
                    case -3:
                        $error = '密码错误';
                        break;
                    default:
                        $error = '未知错误';
                        break;
                }
                $this->error($error);
            }


        }
        return $this->fetch();
    }

    /**
     * 退出登录
     */
    public function loginOut() 
    {
        session(null);
        cookie(null);
        $this->redirect(config('user_auth_gateway'));
    }
}
