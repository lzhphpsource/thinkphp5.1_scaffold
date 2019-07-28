<?php
// 系统配置控制器       
// +----------------------------------------------------------------------
// | PHP version 5.6+
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.bcahz.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: White to black <973873838@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;
use app\common\controller\Base;
use app\admin\model\Config;
use app\admin\validate\Config as ConfigValidate;

class System extends Base
{

    protected $middleware = ['MemberLogin','Auth'];

    public function initialize(){
        parent::initialize();
        $this->config_model = new Config(); // 配置表对应模型类
    }

    /**
     * 配置界面读取
     *
     * @return mixed
     */
    public function setConfig() 
    {

    	$this->assign('meta_title','网站设置');
        $id = input('id/d', 1); // 配置分组
        $list = $this->config_model
        ->where(['group'=>$id, 'status'=>1])
        ->field('id,name,title,extra,value,remark,type,default,placeholder')
        ->order('sort')
        ->select();
        $this->assign('list',$list);
        $this->assign('id',$id);
        return $this->fetch();
    }

    /**
     * 配置列表
     *
     * @return mixed
     */
    public function configList()
    {
        $this->assign('meta_title','配置列表');
        $configList = $this->config_model->order('sort', 'asc')->paginate(15,false,['query' => request()->param()]);
        $this->assign('list', $configList);
        return $this->fetch();
    }

    /**
     * 添加配置
     *
     * @return mixed
     */
    public function addConfig()
    {
        if(IS_POST){
            $validate = new ConfigValidate;
            if (!$validate->scene('addConfig')->check($this->param)) {
                $this->error($validate->getError());
            } else {
                if ($this->config_model->allowField(true)->isUpdate(false)->data($this->param)->save()) {
                    $this->success('添加成功！');
                } else {
                    $this->error($this->config_model->getError());
                }
            }
        } else {
            $this->assign('meta_title','新增配置');
            return $this->fetch();
        }
    }

    /**
     * 修改配置
     *
     * @param $id
     * @return mixed
     */
    public function editConfig($id)
    {
        if (IS_POST) {
            $validate = new ConfigValidate;
            if (!$validate->scene('editConfig')->check($this->param)) {
                $this->error($validate->getError());
            } else {
                if ($this->config_model->allowField(true)->isUpdate(true)->save($this->param)) {
                    $this->success('修改成功！');
                } else {
                    $this->error($this->config_model->getError());
                }
            }

        } else {
            $this->assign('meta_title','编辑配置');
            if (!$id) $this->error('参数错误', url('System/configList'));
            $configData = $this->config_model->where('id', (int) $id)->find();
            $this->assign('data',$configData);
            return $this->fetch();
        }
    }

    /**
     * 单个或批量删除记录
     *
     * @return \think\response\Json
     */
    public function delConfig()
    {
        if (IS_POST) {
            if (!$this->param['ids']) return json( ['msg' => '参数错误!', 'code' => '0', 'url' => url('System/configList')] );
            
            if ($this->config_model->destroy($this->param['ids'])) {
                return json( ['msg' => '删除成功！', 'code' => '1', 'url' => url('System/configList')] );
            } else {
                return json( ['msg' => '删除失败！', 'code' => '0', 'url' => url('System/configList')] );
            }
        } else {
            $this->fuck(); // TODO 找不到该函数
        }
    }

    /**
     * 批量保存配置
     *
     * @param $config
     */
    public function saveAllConfig($config)
    {
        if($config && is_array($config)){
            foreach ($config as $name => $value) {
                $this->config_model
                ->where(['name'=>$name])
                ->setField('value', $value); // setField 方法返回影响数据的条数，没修改任何数据字段返回 0
                if($name == 'store_money'){
                    // TODO 函数不存在，批量保存需要优化
                    navReadSet('GiftsStoredValue',1);
                }
            }
        }
        $this->success('修改成功！', url('System/setConfig'));
    }
}
