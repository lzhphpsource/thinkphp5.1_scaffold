<?php
// 公有配置
// +----------------------------------------------------------------------
// | PHP version 5.6+
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.bcahz.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: White to black <973873838@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\model;

use app\common\model\Base;

class Config extends Base
{
	// 设置完整的数据表（包含前缀）
    // protected $table = 'think_access';
    // 设置数据表（不含前缀）
    // protected $name = 'config';

    // 自动完成时间
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
}