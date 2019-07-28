<?php
/**
 * Created by PhpStorm.
 * User: LZH
 * Date: 2019/7/4
 * Time: 15:10
 */

namespace app\admin\builder;
use app\common\controller\Base;

/**
 * AdminBuilder：快速建立管理页面。
 *
 * Class AdminBuilder
 * @package Admin\Builder
 */
abstract class AdminBuilder extends Base
{
    /**
     * 解析和获取模板内容 用于输出
     *
     * @param string $templateFile 模板文件名称
     * @param array $vars
     * @param string $replace
     * @param string $config
     * @return mixed|void
     */
    public function fetch($templateFile='',$vars =array(), $replace ='', $config = '') {
        //获取模版的名称
        //$template ='Builder/'.$templateFile;
        //显示页面
        //halt();
        //return $this->fetch('/builder/' . $templateFile);
        // echo parent::fetch('./application/admin/view/builder/'.$templateFile.'.html');
         echo parent::fetch('/builder/' . $templateFile);
    }

    /**
     * 组装html节点属性
     *
     * @param $attr 包含属性键值对的数组
     * @return array|string
     */
    protected function compileHtmlAttr($attr) {
        if (!is_array($attr)) {
            return '';
        }
        $result = array();

        foreach($attr as $key=>$value) {
            $value = htmlspecialchars($value); // 转义特殊字符
            $result[] = "$key=\"$value\"";
        }
        $result = implode(' ', $result);
        return $result;
    }
}

