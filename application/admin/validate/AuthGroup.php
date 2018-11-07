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

class AuthGroup extends Validate
{
	protected $rule = [
		['title'       ,  'require|regex:/[\x7f-\xff]/','权限组名不得为空|权限组名必须为中文'],
		['status'      ,  'require|number|in:0,1','权限状态不得为空|权限状态错误,请重新选择|权限状态错误,请重新选择'],
		['description' ,  'max:255','权限描述不得大于255字节'],
	];
}