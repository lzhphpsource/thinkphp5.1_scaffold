<?php
// 权限验证       
// +----------------------------------------------------------------------
// | PHP version 5.6+
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.bcahz.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: White to black <973873838@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\validate;

use think\Validate;

class AuthRule extends Validate
{
    // 验证规则
    protected $rule = [
        ['title' ,  'require','节点名称不得为空'],
        ['name'  ,  'require|regex:/\w+\/\w+\/\w+/i','节点地址不得为空|节点地址不符合规范'],
        ['level' ,  'require|gt:0','节点类型不得为空|请选择节点类型'],
        ['status',  'require','请选择节点状态'],
        ['sort'  ,  'require|number','节点排序不得为空|节点排序必须为数字'],
    ];
}