<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2018/11/1
 * Time: 9:34
 */

namespace app\index\controller;

/**
 * 接口首页
 * @package app\index\controller
 */
class IndexController
{
    /**
     * 默认接口服务
     * @desc 默认接口服务，当未指定接口服务时执行此接口服务
     * @param int test 测试参数
     * @return string title 标题
     * @return string content 内容
     * @return string version 版本，格式：X.X.X
     * @return int time 当前时间戳
     * @exception 400 非法请求，参数传递错误
     */
    public function index()
    {

        return json(['name'=>'thinkphp','status'=>1]);
    }
}
