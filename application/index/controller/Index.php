<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2018/11/1
 * Time: 9:34
 */

namespace app\index\controller;
use app\common\controller\Base;
use think\facade\Log;
class Index extends Base
{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        Log::record('test', 'test');
        if(IS_GET){
            halt($this->param);
        }
    }
}