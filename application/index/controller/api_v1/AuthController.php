<?php
// +----------------------------------------------------------------------
// | spb2
// +----------------------------------------------------------------------
// | Author: King east <1207877378@qq.com>
// +----------------------------------------------------------------------


namespace app\index\controller\api_v1;


use app\common\controller\Resful;

class AuthController extends Resful
{
    /**
     * @api {POST} login 登录
     * @apiName PostLogin
     * @apiGroup Auth
     *
     * @apiParam {String} username 登录用户
     * @apiParam {String} password 登录密码
     *
     * @apiSuccessExample {json} 成功返回
     * {
     *   code: 1,
     *   message: 'OK',
     *   data: {
     *   }
     * }
     *
     * @apiErrorExample {json} 失败返回
     * {
     *   code: 0,
     *   message: String
     * }
     *
     * @route('/login')
     */
    public function login()
    {

    }

}