<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2018/11/7
 * Time: 15:02
 */

namespace app\admin\controller;
use app\admin\builder\AdminListBuilder;
use app\admin\builder\AdminFormBuilder;

class Demo extends Admin
{
    public function demoList(){
        // 这是按名称检索
        $keyword =isset($this->param['keyword']) ? $this->param['keyword']:false;
        $condition=[]; // 收集检索字段
        if($keyword){
            $condition['name'] = ['like','%'.$keyword.'%'];

        }
        //数据是从member表拿到，未新建表
        $data_list = $this->member_model->where($condition)->order('id desc')->paginate(15,false,['query' => request()->param()]);
        foreach($data_list as $key => $value){
            $value['icon'] = ' fa-circle-o-notch fa-spin';
            $value['demo_time'] = time();
            $value['array'] = 1;
        }

        // 根据收集的信息创建列表
        $builder   = new AdminListBuilder();
        $builder->setMetaTitle('列表标题') // 设置页面标题
        ->setSearch('搜索关键词名称','') //如果链接变量,直接写在第二个参数里
        ->addTopButton('addnew',['href'=>url('demoAdd')])  // 添加新增按钮
        ->addTopButton('all')  // 添加新增按钮
        ->addTopButton('delete',array('model'=>'demo'))
        ->addTopButton('self',array('title'=>'额外功能，比如传type参数搜索','href'=>url(MODULE_NAME.'/'.CONTROLLER_NAME.'/demoList',array('status' => 1))))
        ->keyListItem('id', '编号')
        ->keyListItem('icon', '图标','icon','','style="color:green;"')
        ->keyListItem('status', '状态','bool','','style="color:red;"')
        ->keyListItem('update_time', '日期','date','','style="color:orange;"')
        ->keyListItem('demo_time', '日期','datetime','','style="color:#ffff00;"')
        ->keyListItem('avatar', '头像','avatar','','style="color:#ff0000;"')
        ->keyListItem('array', '数组','array',array(0=>'隐藏',1=>'显示'),'style="color:#CC3333;"')
        ->setListData($data_list) // 数据列表
        ->setListPage($data_list->render()) // 数据列表分页
        ->keyListItem('right_button', '操作', 'btn')
        //从回收站里面还原，状态为-1改成1，status
        ->addRightButton('restore')
        //禁用，状态为1改成0，status
        ->addRightButton('forbid')
        //// 移动至回收站状态为1改成-1，status
        ->addRightButton('recycle')
        //__data_id__为约定ID,主键
        ->addRightButton('edit',['href'=>url('demoEdit',array('id'=>'__data_id__'))])// 编辑
        //额外删除，model名必须与库名相同，否则会删错表，代码在Admin
        ->addRightButton('delete',array('model'=>'demo'))
        //额外操作，比如加样式js事件等跳转地址等。
        ->addRightButton('edit',['href'=>'javascript:;','data-url'=>url('castEdit',array('id'=>'__data_id__')),'title'=>'通过','class'=>'check_a btn-xs btn-link isConfirm'])
        ->fetch();
    }

    public function demoAdd(){
        if(IS_POST){
            // 省略
        } else {
            $info    =[];
            $info['status'] = 1;
            $info['demo7'] = 123456789;
            $builder = new AdminFormBuilder();
            $builder->setMetaTitle('新增测试') // 设置页面标题
                ->addFormItem('demo1', '测试多选','','checkbox',array(0=>'测试1',1=>'测试2',3=>'测试3'))
                ->addFormItem('demo2', '测试日期','','date')
                ->addFormItem('demo3', '测试时间','','datetime')
                ->addFormItem('demo4', '测试邮件','','email')
                ->addFormItem('demo5', '测试多图','','figure')
                ->addFormItem('demo6', '测试隐藏域','','hidden')
                ->addFormItem('demo7', '测试禁止写入','','info')
                ->addFormItem('contents', '测试编辑器','测试编辑器，name必须为contents，上传类可以在fields->kindeditor修改','kindeditor','','')
                ->addFormItem('demo8', '测试数字','','number')
                ->addFormItem('demo9', '测试密码','','password')
                ->addFormItem('demo10', '测试单图上传','','picture')
                ->addFormItem('demo11', '测试单选','','radio',array(0=>'我不知道',1=>'我知道'))
                ->addFormItem('demo12', '测试下拉','','select',array(0=>'我不知道',1=>'我知道'))
                ->addFormItem('demo13', '测试其他','','self','<input type="submit" name="测试其他" value="我要测试">')
                ->addFormItem('demo14', '测试文本框','','text','')
                ->addFormItem('demo15', '测试多行文本','','textarea','')

                ->setFormData($info)
                ->group('基本信息','demo1,demo2,demo3,demo4,demo6,demo7,demo8,demo9,demo10,demo11,demo12,demo13,demo14,demo15')
                ->group('推荐信息','demo5,contents')
                ->addButton('submit')->addButton('back')    // 设置表单按钮
                ->fetch();
        }
    }
}