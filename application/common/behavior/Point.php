<?php
// 公有版本检测
// +----------------------------------------------------------------------
// | PHP version 5.6+
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.bcahz.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: White to black <973873838@qq.com>
// +----------------------------------------------------------------------
namespace app\common\behavior;

use think\Config;

class Point 
{
    public function run(&$params)
    {
        //设置基础路径
        // defined('BASE_PATH') or define('BASE_PATH', substr($_SERVER['SCRIPT_NAME'], 0, -10));
    	$new_config =[];
        //头信息
        $header_info = request()->header();

        if (!empty($header_info['apiversion']) && !empty($header_info['deviceuuid']) && !empty($header_info['sign'])) {
        	$new_config['url_controller_layer']='api';
        }
        Config::set($new_config);

    }
}