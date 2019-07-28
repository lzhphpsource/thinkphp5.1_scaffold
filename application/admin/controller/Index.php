<?php
namespace app\admin\controller;
use app\common\controller\Base;
class Index extends Base
{
    protected $middleware = ['MemberLogin','Auth'];
// 如果控制器中定义initialize方法，则必须显式调用base类中的initialize方法
//    public function initialize(){
//        parent::initialize();
//    }

    public function index(){
        return $this->fetch();
    }
    public function home(){
        return $this->fetch();
    }
}
