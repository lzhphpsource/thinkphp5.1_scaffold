<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
define ("DEBUG_MODE", true);
// 应用公共文件
use think\facade\Hook;
Hook::add('app_init','app\\common\\behavior\\Config');
/**
 * [get_config_type 获取配置的类型]
 * @param  [integer] $type [配置类型]
 * @return [string ]        [description]
 */
function get_config_type($type=0){
    $list = Config('config_type_list.');
    return $list[$type];
}

/**
 * [get_config_group 获取配置的分组]
 * @param  [integer] $group [配置分组]
 * @return [string]         [description]
 */
function get_config_group($group=0){
    $list = Config('config_group_list.');
    return $group ? $list[$group] : '无分组';
}

/**
 * [parse_config_attr 分析枚举类型配置值 格式 a:名称1,b:名称2]
 * @param  [string] $string [需要解析的字符串]
 */
function parse_config_attr($string) {
    $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
    if(strpos($string,':')){
        $value  =   array();
        foreach ($array as $val) {
            list($k, $v) = explode(':', $val);
            $value[$k]   = $v;
        }
    }else{
        $value  =   $array;
    }
    return $value;
}

/**
 * 导出excel
 * @param  array  $data     [description]
 * @param  array  $title    [description]
 * @param  string $filename [description]
 * @return [type]           [description]
 */
function exportExcel($data=array(),$title=array(),$filename='report')
{
    header("Content-type:application/octet-stream");
    header("Accept-Ranges:bytes");
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:attachment;filename=".$filename.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    echo "<table style='border:solid 1px #ddd;'>";
    echo "<tr style='border:solid 1px #ddd;'>";
    //导出表头（也就是表中拥有的字段）
    foreach ($data[0] as $key => $value) {
        echo "<th>".$value."</th>";
    }
    echo "</tr>";

    unset($data[0]);

    foreach ($data as $key => $row) {
        echo "<tr style='border:solid 1px #ddd;'>";
        foreach ($row as $key => $value) {
            echo "<td>".$value."</td>";
        }
        echo "</tr>";
    }

    echo "</table>";

}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 6; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 时间戳格式化
 * @param int $time
 * @return string 完整的时间显示
 * @author huajie <banhuajie@163.com>
 */
function time_format($time = NULL, $format = 'Y-m-d H:i') {
    $time = $time === NULL ? time() : intval($time);
    return date($format, $time);
}