<?php
// 权限控制器       
// +----------------------------------------------------------------------
// | PHP version 5.6+
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.bcahz.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: White to black <973873838@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;
use app\admin\builder\AdminFormBuilder;
use app\admin\model\AuthRule;
use app\admin\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
use app\common\model\member;
use app\admin\model\MemberGroup;
use org\util\Category;
use app\admin\validate\AuthGroup as AuthGroupValidate;
use think\db;

class Access extends Admin
{

    protected $middleware = ['MemberLogin','Auth'];

    public function initialize(){
        parent::initialize();
        $this->authrule_model          = new AuthRule();
        $this->authgroup_model         = new AuthGroup();
        $this->authgroupaccess_model   = new AuthGroupAccess();
        $this->member_model            = new member();
        $this->member_group_model      = new MemberGroup();
    }

//    public function index()
//    {
//        return $this->fetch();
//    }

    /**
     * [nodeList 节点管理]
     * @return [array] [节点树]
     */
    public function nodeList() 
    {
        $this->assign('meta_title','节点列表');
        $list = array();
        $keyword =isset($this->param['keyword']) ? $this->param['keyword']:false;
        $condition = [];
        if ($keyword) {
            $condition['name|title'] = ['like','%'.$keyword.'%'];
        }
        $cat = new Category('authRule', array('id', 'pid', 'title', 'fullname','sort asc , id desc'));
        $temp = $cat->getList($condition,'','sort asc, id asc');
        $level = array("1" => "项目（GROUP_NAME）", "2" => "模块（MODEL_NAME）", "3" => "操作（ACTION_NAME）", "4" => "操作（ACTION_NAME）");
        foreach ($temp as $k => $v) {
            $temp[$k]['statusTxt'] = $v['status'] == 1 ? "启用" : "禁用";
            $temp[$k]['chStatusTxt'] = $v['status'] == 0 ? "启用" : "禁用";
            $temp[$k]['is_displayTxt'] = $v['is_display'] == 0 ? "隐藏" : "显示";
            $temp[$k]['level'] = $level[$v['level']];
            $list[$v['id']] = $temp[$k];
        }
        $this->assign("list", $list);
        return $this->fetch();
    }

    /**
     * [add 新增节点]
     * @return [string] [新增节点单个处理]
     */
    public function add()
    {
        $ruleData = array();
        $info     = array();
        $title='新增';
        if (IS_POST) {
                $ruleData=$this->authrule_model->allowField(true)->isUpdate(false)->data($this->param)->save();
            if ($ruleData) {
                $this->success('操作成功！','Access/nodeList');
            } else {
                $this->error($this->authrule_model->getError());
            }
        } else {
                $infolist=array();
                $infolist=$this->getPid($ruleData,'','sort asc, id asc');
                $builder = new AdminFormBuilder();
                $builder->setMetaTitle($title.'节点') // 设置页面标题
                        ->addFormItem('id', '','','hidden')
                        ->addFormItem('title', '节点名称','请填写节点名称，例如：会员编辑','text','','required')
                        ->addFormItem('name', '节点地址','请填写节点地址，例如：Admin/User/userEdit','text','','required')
                        ->addFormItem('level', '节点类型','设置“节点”类型','self',$infolist['levelOption'],'required')
                        ->addFormItem('pid', '节点类型','设置“节点”类型','self',$infolist['pidOption'],'required')
                        ->addFormItem('status','节点状态','设置“节点”状态','radio',array(1=>'启用',0=>'禁用'),'required')
                        ->addFormItem('is_display','是否显示','用于导航是否显示','radio',array(1=>'显示',0=>'隐藏'),'required')
                        ->addFormItem('node_icon', '节点图标','请填写节点地址，例如：icon-drds')
                        ->addFormItem('class_icon', '分类图标','请填写节点地址，例如：icon-drds')
                        ->addFormItem('sort', '节点排序','请填写节点序号，例如：2','text','','required')
                        ->setFormData($ruleData)
                        ->addButton('submit')->addButton('back')    // 设置表单按钮
                        ->fetch();
        }
    }

    /**
     * [edit 修改节点]
     * @return [string] [修改节点单个处理]
     */
    public function edit($id=0)
    {
        $ruleData = array();
        $info     = array();
        $title='编辑';
        if (IS_POST) {
                $ruleData=$this->authrule_model->allowField(true)->isUpdate(true)->save($this->param,array('id'=>$this->param['id']));
            if ($ruleData) {
                $this->success('操作成功！','Access/nodeList');
            } else {
                $this->error($this->authrule_model->getError());
            }
        } else {
                $map['id']=$id;
                $ruleData = db::name('AuthRule')->where('id', $id)->find();
                $infolist = array();
                $infolist=$this->getPid($ruleData);
                $builder = new AdminFormBuilder();
                $builder->setMetaTitle($title.'节点') // 设置页面标题
                    ->addFormItem('id', '','','hidden')
                    ->addFormItem('title', '节点名称','请填写节点名称，例如：会员编辑','text','','required')
                    ->addFormItem('name', '节点地址','请填写节点地址，例如：Admin/User/userEdit','text','','required')
                    ->addFormItem('level', '节点类型','设置“节点”类型','self',$infolist['levelOption'],'required')
                    ->addFormItem('pid', '节点类型','设置“节点”类型','self',$infolist['pidOption'],'required')
                    ->addFormItem('status','节点状态','设置“节点”状态','radio',array(1=>'启用',0=>'禁用'),'required')
                    ->addFormItem('is_display','是否显示','用于导航是否显示','radio',array(1=>'显示',0=>'隐藏'),'required')
                    ->addFormItem('node_icon', '节点图标','请填写节点地址，例如：icon-drds')
                    ->addFormItem('class_icon', '分类图标','请填写节点地址，例如：icon-drds')
                    ->addFormItem('sort', '节点排序','请填写节点序号，例如：2','text','','required')
                    ->setFormData($ruleData)
                    ->addButton('submit')->addButton('back')    // 设置表单按钮
                    ->fetch();
        }
    }

    /**
     * [delNode 删除节点]
     */
    public function delNode()
    {
        if (IS_POST) {
                $dataUid = $this->param['ids'];
            if(empty($dataUid)) return json( ['msg' => '参数错误！', 'code' => '0', 'url' =>  url("Access/nodeList")] );
                $arrData = str2arr($dataUid);
            foreach ($arrData as $key => $value) {
                //如果有子节点则不能删除
                $result = db::name('AuthRule')->where(array('pid'=>$value))->count();
                if ($result) return json( ['msg' => '当前节点下还拥有子节点，不能删除！', 'code' => '0', 'url' =>  url("Access/nodeList")] );
            }
            if ($this->authrule_model->where('id','in',$dataUid)->delete()) {
                return json( ['msg' => '删除成功！', 'code' => '1', 'url' =>  url("Access/nodeList")] );
            } else {
                return json( ['msg' => '删除失败！', 'code' => '0', 'url' =>  url("Access/nodeList")] );
            }
        } else {
            $this->fuck();
        }
    }

    /**
     * [roleList 角色列表]
     */
    public function roleList()
    {       
        $this->assign('meta_title','角色管理');
        $keyword =isset($this->param['keyword']) ? $this->param['keyword']:false;
        
        $condition = [];
        if ($keyword) {
            $condition['id|title'] = ['like','%'.$keyword.'%'];
        }

        $AuthGroupData = $this->authgroup_model->where($condition)->order('create_time desc , update_time desc')->paginate(15,false,['query' => request()->param()]);
        $this->assign('authgroup', $AuthGroupData);
        return $this->fetch();
    }

    /**
    * [addRole 添加角色]
    */
    public function addRole()
    {
        if (IS_POST) {
            if(!empty($this->param['rules'])){
                $this->param['rules'] = arr2str($this->param['rules']);
            } else {
                $this->error('请选择管理权限');
            }
            $validate = new AuthGroupValidate;
            if (!$validate->check($this->param)) {
                if ($this->authgroup_model->allowField(true)->isUpdate(false)->data($this->param)->save()) {
                    // $data = ['info' => '节点添加成功！', 'status' => '1', 'url' => url('Access/roleList')];
                    // return json($data);
                    $this->success('操作成功！', 'Access/roleList');
                } else {
                    // $data = ['info' => '节点添加失败！', 'status' => '0'];
                    // return json($data);
                    $this->error($this->authgroup_model->getError());
                }
            }
        } else {
            $data = db::name('AuthRule')->select();
            $data = list_to_tree2($data,'id','pid');
            $this->assign("nodeList", $data);
            return $this->fetch();
        }
    }
    
     /**
     * [authRole 角色授权]
     */
    public function authRole()
    {
        if (IS_POST) {

            if(!empty($this->param['rules'])){
                $this->param['rules'] = arr2str($this->param['rules']);
            } else {
                $this->error('请选择管理权限');
            }

            $this->param['id'] = decode($this->param['id']);
            $validate = new AuthGroupValidate;
            if (!$validate->check($this->param)) {
                if ($this->authgroup_model->allowField(true)->isUpdate(true)->save($this->param, array('id' => $this->param['id']))) {

                    $this->success('操作成功！', 'Access/roleList');
                } else {

                    $this->error($this->authgroup_model->getError());
                }
            }

        } else {

            $id = decode($this->param['id'] );

            if ($id) {
                $result = $this->authgroup_model->where(array('id'=>$id))->find();
                if (empty($result)) {
                    $this->error("不存在该用户组",'Access/roleList');
                }
                $this->assign("info", $result);
            } else {
                $this->error("不存在该用户组",'Access/roleList');
            }

            $data = db::name('AuthRule')->order('sort asc, id asc')->select();
            $data = list_to_tree2($data);
            $this->assign("nodeList", $data);
            $this->assign("id", $this->param['id']);
            return $this->fetch();
        }
    }

    /**
     * [disabledRole 角色禁用]
     */
    public function disabledRole()
    {
        if (IS_GET) {
            $dataUid = decode($this->param['id']);
            $dataStauts = decode($this->param['status']);

            if (empty($dataUid)) $this->error('参数有误！','Access/roleList');
                $sqlmap = array();
                $sqlmap['id'] = array("IN", $dataUid);
                $status = $dataStauts ? 0 : 1;
                $data = array('status'=>$status);
            if ($this->authgroup_model->where($sqlmap)->setField($data)) {
                $this->success('操作成功！','Access/roleList');
            } else {
                $this->error('操作失败！','Access/roleList');
            }
        }
    }

    /**
     * [delRole 删除角色分组]
     */
    public function delRole()
    {
        if (IS_POST) {
            $dataUid =$this->param['ids'];

            if (!$dataUid) return json( ['msg' => '参数错误!', 'code' => '0', 'url' => url('Access/roleList')] );

            $arrData = explode(',',$dataUid);
            if (is_array($arrData)) {
                foreach ($arrData as $key => $value) {
                    //当前分组下如有授权用户则禁止删除
                    $result = $this->authgroupaccess_model->where(array('group_id'=>$value))->count();
                    //if ($result) $this->ajaxReturn(array('status'=>0, 'info'=>'当前分组有授权用户、禁止删除！', 'url'=>url('Access/roleList')));
                    if ($result) return json( ['msg' => '当前分组有授权用户、禁止删除！', 'code' => '0', 'url' =>  url("Access/roleList")] );
                }
            }else{
                 $result = $this->authgroupaccess_model->where(array('group_id'=>$dataUid))->count();
                    //if ($result) $this->ajaxReturn(array('status'=>0, 'info'=>'当前分组有授权用户、禁止删除！', 'url'=>url('Access/roleList')));
                    if ($result) return json( ['msg' => '当前分组有授权用户、禁止删除！', 'code' => '0', 'url' =>  url("Access/roleList")] );
            }

            if ($this->authgroup_model->where('id','in',$dataUid)->delete()) {
                 return json( ['msg' => '删除成功！', 'code' => '1', 'url' =>  url("Access/roleList")] );
            } else {
                return json( ['msg' => '删除失败！', 'code' => '0', 'url' =>  url("Access/roleList")] );
            }
        }else {
            $this->fuck();
        }
    }


    /**
     * 管理员列表
     *
     * @return mixed
     */
    public function authList()
    {   
        //halt(config('USER_ADMINISTRATOR'));
        $this->assign('meta_title','管理列表');
        // 搜索
        $keyword =isset($this->param['keyword']) ? $this->param['keyword']:false;
        $condition=[];
        if($keyword){
            $condition['realname|mobile'] = ['like','%'.$keyword.'%'];
        }

        //$SuperAdminData = $this->member_model->where($condition)->paginate(15,false,['query' => request()->param()]);
        // TODO 需要优化，这里以来表前缀名称
        $SuperAdminData = $this->member_model->where('id in (select uid from hd_auth_group_access)')->order('hd_member.register_time desc , update_time desc')->paginate(8,false,['query' => request()->param()]);
        $this->assign('list',$SuperAdminData);
        return $this->fetch();
    }

    /**
     * 批量或单个删除管理员
     *
     * @return \think\response\Json
     */
    public function delUser()
    {
        if (IS_POST) {
            if (!$this->param['ids']) return json( ['msg' => '参数错误!', 'code' => '0', 'url' => url('Access/authlist')] );
            if ($this->authgroupaccess_model->where('uid','in',$this->param['ids'])->delete()) {
                return json( ['msg' => '删除成功！', 'code' => '1', 'url' => url('Access/authlist')] );
            } else {
                return json( ['msg' => '删除失败！', 'code' => '0', 'url' => url('Access/authlist')] );
            }
        } else {
            $this->fuck();
        }
    }

    /**
     * [disabledUser 修改用户登陆权限]
     */
    public function disabledUser()
    {
        $dataUid = $this->param['id'];
        $status  = $this->param['status'];
        //p($status,1);
        if (empty($dataUid)) $this->error('参数错误！', U('Access/authlist'));
        $sqlmap = array();
        $sqlmap['id'] = array("IN", $dataUid);
        $status = $status ? 0 : 1;
        $data = array('status'=>$status);
        if ($this->member_model->where($sqlmap)->setField($data)) {
            $this->success('操作成功！', url('Access/authlist'));
        }else{
            $this->error('操作失败！', url('Access/authlist'));
        }
    }

    /**
     * [getPid 获取节点]
     */
    private function getPid($info) 
    {
        if(empty($info['level'])){
            $info['level']='';
        }

        if(empty($info['pid'])){
            $info['pid']='';
        }

        $info['levelOption'] = '';
        $arr = array("请选择", "项目", "模块", "操作", '分类');

        $info['levelOption'].='<div class="rule-single-select single-select">';
        $info['levelOption'].='<select name="level" id="level" datatype="*" errormsg="请选择管理员角色" sucmsg=" ">';

        for ($i = 0; $i < 5; $i++) {
            $selected = $info['level'] == $i ? " selected='selected'" : "";
            $info['levelOption'].='<option value="' . $i . '" ' . $selected . '>' . $arr[$i] . '</option>';
        }

        $info['levelOption'].='</select>';
        $info['levelOption'].='</div>';
        $info['levelOption'].='<script type="text/javascript">
                                    $(function(){
                                        $("select[name=\'level\']").change(function(){
                                            var level=$(this).val();
                                            $("select[name=\'pid\']>option").attr("disabled","disabled");
                                            if(level==1){
                                                $("select[name=\'pid\']>option[value=\'0\']").removeAttr("disabled").attr("selected","selected");
                                            }else if(level==2){
                                                $("select[name=\'pid\']>option[level=\'1\']").removeAttr("disabled").attr("selected","selected");
                                            }else if(level==3){
                                                $("select[name=\'pid\']>option[level=\'2\']").removeAttr("disabled").attr("selected","selected");
                                            }else{
                                                $("select[name=\'pid\']>option[level=\'3\']").removeAttr("disabled").attr("selected","selected");
                                            }
                                        });
                                    });
                                </script>';

        $level    = $info['level'];
        $cat      = new Category('authRule', array('id', 'pid', 'title', 'fullname'));
        $list     = $cat->getList('','','sort asc ,id asc');               //获取分类结构
        #         =======================此处有一个BUG,如果加上div有样式了,但是无法进行关联操作.==========================
        //$option ='<div class="rule-single-select single-select">';
        $option   ='<select name="pid" id="pid" datatype="*" errormsg="请选择管理员角色" sucmsg=" ">';
        $option   .= $level == 0 ? '<option value="0" level="0">根节点</option>' : '<option value="0" disabled="disabled">根节点</option>';

        foreach ($list as $k => $v) {
            $disabled = $v['level'] == ($level-1) ? "" : ' disabled="disabled"';
            $selected = $v['id'] != $info['pid'] ? "" : ' selected="selected"';
            $option.='<option value="' . $v['id'] . '"' . $disabled . $selected . '  level="' . $v['level'] . '">' . $v['fullname'] . '</option>';
        }

        $option.='</select>';
        //$option.='</div>';
        $info['pidOption'] = $option;
        return $info;
    }
}
