<?php
// +----------------------------------------------------------------------
// | spb2
// +----------------------------------------------------------------------
// | Author: King east <1207877378@qq.com>
// +----------------------------------------------------------------------


namespace app\index\controller\v1;


use app\common\controller\Resful;

/**
 * 授权接口
 * @package app\index\controller\v1
 */
class AuthController extends Resful
{
    public function login()
    {
        $form = $this->request->post();
        return $this->success(['data'=>$form]);

    }

}