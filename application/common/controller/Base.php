<?php
// 公有控制器
// +----------------------------------------------------------------------
// | PHP version 5.3+                
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.bcahz.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: White to black <973873838@qq.com>
// +----------------------------------------------------------------------
namespace app\common\controller;
use think\Controller;
use think\facade\Config;
use app\common\model\Member as MemberModel;
use think\facade\Env;

class Base extends Controller {
    protected $url;
    protected $request;
    protected $module;
    protected $controller;
    protected $action;
    protected $config;
    public static $logIndex = 1;

	public function initialize() {
        //parent::initialize(); // TODO 这没有用
        //halt(123);
       // exit(json_encode(['code'=>0,'msg'=>'项目更新，敬请期待']));
		header("Content-Type: Text/Html;Charset=UTF-8");
		//获取request信息
		$this->requestInfo();
		//读取数据库中的配置
        $configObj = new \config\ConfigApi();
        $config = $configObj->lists();
        //halt($config);

        // if(!in_array($request->domain(),['http://www.qlqwshop.com ','http://api.qlqwshop.com ','http://home.qlqwshop.com '])){
        // 	$config['oss_enable']=0;
        // }
        Config::set($config);
        // 用户模型
        $this->member_model = new MemberModel();
	}

    /**
     * 从request中获取信息并存储到控制器中
     * @return mixed
     */
	protected function requestInfo() {
		$this->param =  $this->request->param();

		defined('MODULE_NAME') or define('MODULE_NAME', $this->request->module());
		defined('CONTROLLER_NAME') or define('CONTROLLER_NAME', $this->request->controller());
		defined('ACTION_NAME') or define('ACTION_NAME', $this->request->action());
		defined('IS_POST') or define('IS_POST', $this->request->isPost());
		defined('IS_AJAX') or define('IS_AJAX', $this->request->isAjax());
		defined('IS_GET') or define('IS_GET', $this->request->isGet());
//		//获取当前地址
//      $this->assign('full_url', $this->request->url());//完整url
//		$this->assign('request', $this->request);
//		$this->assign('param', $this->param);

		$this->url = strtolower($this->request->module() . '/' . $this->request->controller() . '/' . $this->request->action());
        $this->ip=$this->request->ip();
        //获取当前地址
        return $this->full_url=$this->request->url(true);//完整url
	}

    /**
     * 获取单个参数的数组形式
     * @param $param
     * @return array
     */
	protected function getArrayParam($param) {
		if (isset($this->param['id'])) {
			return array_unique((array) $this->param[$param]);
		} else {
			return array();
		}
	}

    /**
     * 日志打印
     * @param $text
     */
    public function log($text) {
    	//是否打印日志
        if(!Config::get('app_debug')){
            return ;
        }

        //分割线
        if (self::$logIndex == 1) {
            $log = '*************************打印数据分割线*************************' . PHP_EOL;
            $log .= date("Y-m-d H:i:s", time()) . PHP_EOL;
        }

        //日志路径目录
        $logPath = Env::get('RUNTIME_PATH') . 'debug/';

        //创建日志目录
        if (!is_dir($logPath)) { self::mkdirs($logPath);}

        //日志名字文件生成
        $logFile = $logPath . 'log'.date("Y-m-d", time()).'.log';
        if (is_array($text)) {
            $log = self::$logIndex . ', array==>';
            $text = var_export($text, true);
        } else {
            $log .= self::$logIndex . ', str==>';
        }

        //写入文件
        $log .= $text . PHP_EOL;
        file_put_contents($logFile, $log, FILE_APPEND);
        self::$logIndex++;
    }

    /**
     * 创建文件夹，可递归打印多层目录
     *
     * @param type $dir
     * @return boolean
     */
    public static function mkdirs($dir) {
        if (!is_dir($dir)) {
            if (!self::mkdirs(dirname($dir))) {
                return false;
            }
            if (!mkdir($dir, 0777)) {
                return false;
            }
        }
        return true;
    }
}
