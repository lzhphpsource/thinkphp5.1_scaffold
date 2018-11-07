<?php
// 文件控制器     
// +----------------------------------------------------------------------
// | PHP version 5.6+
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.bcahz.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: White to black <973873838@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;
use app\common\controller\Base;
use app\common\controller\Upload as UploadController;
class File extends Base
{
    function _initialize()
    {
        parent::_initialize();
        // p($this->member_model);
        // exit;
    }

    /**
     * 上传
     * @return [type] [description]
     */
    public function upload()
    {
        $controller = new UploadController;
        $return = $controller->upload();
        return json($return);
    }
    /**
     *[uploadAvatar] 上传图像操作
     * @return [type] [description]
     */
    public function uploadAvatar($uuid=0)
    {
        $return = [
            'status' =>1,
            'path'   =>'/public/images/defalut.jpg',
            'msg'    =>'提示成功'
        ];
        return json($return);
    }
   
}
