<?php
// 公有静态路径
// +----------------------------------------------------------------------
// | PHP version 5.6+
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.bcahz.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: White to black <973873838@qq.com>
// +----------------------------------------------------------------------
namespace app\common\behavior;

use think\facade\Config as thinkConfig;
use app\common\Controller\Base;

class Config
{
    public function run($params)
    {
        defined('PUBLIC_URL') or define('PUBLIC_URL',isset($params['module'][0]) ? $params['module'][0]:config('default_module'));

    	$new_config =[];
        //头信息
        $header_info = request()->header();

        $new_config['view_replace_str'] = [
                '__ROOT__'     => '/',
                '__BASE__'     => BASE_PATH.'/public/static/base',
                '__PUBLIC__'   => BASE_PATH.'/public',
                '__STATIC__'   => BASE_PATH.'/public/static',
                '__LIBS__'     => BASE_PATH.'/public/static/libs',
                '__ADMINCSS__' => BASE_PATH.'/public/static/admin/css',
                '__ADMINJS__'  => BASE_PATH.'/public/static/admin/js',
                '__ADMINIMG__' => BASE_PATH.'/public/static/admin/images',
                '__INDEXCSS__' => BASE_PATH.'/public/static/index/css',
                '__INDEXJS__'  => BASE_PATH.'/public/static/index/js',
                '__INDEXIMG__' => BASE_PATH.'/public/static/index/images',

                '__FINANCECSS__' => BASE_PATH.'/public/static/finance/css',
                '__FINANCEJS__'  => BASE_PATH.'/public/static/finance/js',
                '__FINANCEIMG__' => BASE_PATH.'/public/static/finance/img',
        ];

        $module_public_url = '/public/static/'.PUBLIC_URL;
        $new_config['view_replace_str']['__MODULE__']  = $module_public_url;
        $new_config['view_replace_str']['__MODULE_IMG__']  = $module_public_url.'/images';
        $new_config['view_replace_str']['__MODULE_CSS__']  = $module_public_url.'/css';
        $new_config['view_replace_str']['__MODULE_JS__']   = $module_public_url.'/js';
        $new_config['view_replace_str']['__MODULE_LIBS__'] = $module_public_url.'/libs';

        thinkConfig::set($new_config);

    }
}