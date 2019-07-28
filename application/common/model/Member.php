<?php
// 会员模型       
// +----------------------------------------------------------------------
// | PHP version 5.6+
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.bcahz.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: White to black <973873838@qq.com>
// +----------------------------------------------------------------------
namespace app\common\model;
use think\Image;

class Member extends Base
{

    // 定义时间戳字段名
    protected $createTime = 'register_time';
    protected $updateTime = 'login_time';
    
    // 自动完成
    protected $auto       = ['login_ip'];
    protected $insert     = ['username', 'nickname', 'register_ip', 'login_time', 'status' => 1];

    protected function setNumberAttr($value)
    {
        if ($value) {
            return build_user_no(5, $value);
        } else {
            return build_user_no(10);
        }
    }

    protected function setUsernameAttr($value)
    {
        if ($value) {
            return $value;
        }

        return 'app_'.mt_rand(1000,9999);
    }

    protected function setPasswordAttr($value)
    {
        if(!empty($value)){
            return md5($value);
        }else{
            return '';
        }
    }

    protected function setNicknameAttr($value)
    {
        if ($value) {
            return $value;
        }

        return 'nickName_'.mt_rand(100,9999);
    }

    protected function setRegisterIpAttr()
    {
        return request()->ip();
    }

    protected function setLoginIpAttr()
    {
        return request()->ip();
    }

    protected function setLoginTimeAttr()
    {
        return time();
    }

    /**
     * login 后端用户登录认证
     *
     * @param $loginId 登录ID
     * @param $password 用户密码
     * @param int $type 用户名类型 （1-用户编号, 2-用户账户, 3-手机, 4-用户昵称, 5-用户邮件, 6-全部）
     * @param string $source 用户登录来源
     * @return bool|int 登录成功-用户ID，登录失败-错误编号
     */
    public function login($loginId, $password, $type = 6, $source = "pc"){
        switch ($type) {
            case 2:
                $sqlmap = 'username';
                break;
            case 3:
                $sqlmap = 'mobile';
                break;
            case 4:
                $sqlmap = 'nickname';
                break;
            case 6:
                $sqlmap = 'username|mobile|nickname';
                break;
            default:
                return 0; //参数错误
        }
        /* 获取用户数据 */
        //$member = Db('member')->whereOr($sqlmap, $loginId)->find();
        $member = self::whereOr($sqlmap, $loginId)->find();

        if($member) {
            if (!$member['status']) {
                return -2; //用户被禁用
            }
            /* 验证用户密码 */
            if(md5($password) === $member['password']){ // TODO 加密强度不够

                $this->autoLogin($member, $source); //更新用户登录信息

                return $member['id']; //登录成功，返回用户ID
            } else {
                return -3; //密码错误
            }
        } else {
            return -1; //用户不存在
        }

        return true;
    }

    /**
     * 自动登录，更新用户登录信息
     *
     * @param $member 用户数组
     * @param $source 用户登录来源
     * @return bool
     */
    private function autoLogin($member, $source){
        if (is_array($member)) {
            return false;
        }

        // 记录登录SESSION和COOKIES
        $authLogin = array(
            'LoginId'    => $member['id'],
            'username'   => $member['username'],
            'nickname'   => $member['nickname'],
            'mobile'     => $member['mobile'],
            'login_time' => time(),
        );

        $auth_login_sign = data_auth_sign($authLogin);

        // 更新登录信息
        $data = array(
            'login_num'       => ['login_num','EXP','`login_num`+1'],
            'login_ip'        => request()->ip(),
            'login_time'      => time(),
            'auth_login_sign' => $auth_login_sign,
            'login_source'    => $source,
        );

        self::allowField(true)->isUpdate(true)->save($data,['id' => $member['id']]);

        session('user_auth_session', $authLogin);

        session('auth_login_sign', $auth_login_sign);

        // TODO 没有cookie 实现记住我
    }

}