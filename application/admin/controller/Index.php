<?php
namespace app\admin\controller;
use app\common\controller\Base;
class Index extends Base
{
    protected $middleware = ['MemberLogin','Auth'];

    public function initialize(){
        parent::initialize();
    }

    public function index(){
        return $this->fetch();
    }
    public function home(){
        return $this->fetch();
    }
}
