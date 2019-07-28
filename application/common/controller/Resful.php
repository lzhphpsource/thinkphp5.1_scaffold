<?php
// +----------------------------------------------------------------------
// | hr
// +----------------------------------------------------------------------
// | Author: King east <1207877378@qq.com>
// +----------------------------------------------------------------------


namespace app\common\controller;

use think\App;
use think\Container;
use think\exception\ValidateException;
use think\Request;

class Resful
{
    /**
     * @var Request $request
     */
    protected $request;

    /**
     * @var App
     */
    protected $app;

    public function __construct()
    {
        $this->app = Container::get('app');
        $this->request = Container::get('request');
    }


    /**
     * 快捷调用验证器
     * @param array $data 验证数据
     * @param mixed $rule 验证规则
     * @param string $scene 验证场景
     * @param array $msg 错误消息
     * @return array|bool
     */
    protected function validate($data, $rule, $scene = '', $msg = [])
    {
        if (is_array($rule)) {
            $valid = $this->app->validate();
            $valid->rule($rule);
        } else {
            $valid = $this->app->validate($rule);
        }
        if ($scene) {
            $valid->scene($scene);
        }
        $valid->message($msg);

        if ($valid->check($data)) {
            return true;
        } else {
            throw new ValidateException($valid->getError()); // TODO 这里应该抛出异常
        }
    }

    /**
    业务状态码：
    正常响应	200～299	200	表示接口服务正常响应
    重定向	300～399	300	表示重定向，对应异常类RedirectException的异常码
    非法请求	400～499	400	表示客户端请求非法，对应异常类BadRequestException的异常码
    服务器错误	500～599	500	表示服务器内容错误，对应异常类InternalServerErrorException的异常码
     */

    /**
     * 返回错误接口数据
     *
     * @param string $message
     * @param int $bzCode
     * @param int $httpCode
     * @return \think\response\Json
     */
    protected function error($message, $bzCode = 200, $httpCode = 200)
    {
        return apiResult($bzCode,$message,[], $httpCode);
    }

    /**
     * 返回成功接口数据
     *
     * @param array $data
     * @param string $message
     * @param int $bzCode
     * @param int $httpCode
     * @return \think\response\Json
     */
    protected function success($data, $message = '', $bzCode = 200, $httpCode = 200)
    {
        return apiResult($bzCode,$message,$data,$httpCode);
    }

}