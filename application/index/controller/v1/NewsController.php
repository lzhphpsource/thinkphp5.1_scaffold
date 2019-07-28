<?php
namespace app\index\controller\v1;


use app\common\controller\Resful;
use app\common\exception\ApiException;

/**
 * 新闻接口
 * @package app\index\controller\v1
 */
class NewsController extends Resful
{
    public function index()
    {
        $result = [];

        for ($i = 1; $i <= 100; $i++) {
            $result[] = ['id'=>$i, 'title'=>'测试文章' . $i];
        }
        return $this->success([
            'items'=>$result
        ]);
    }

}