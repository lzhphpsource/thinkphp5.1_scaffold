<?php
// 用户控制器       
// +----------------------------------------------------------------------
// | PHP version 5.3+                
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.bcahz.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: White to black <973873838@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;
use app\admin\builder\AdminListBuilder;
use app\admin\builder\AdminFormBuilder;
use app\admin\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
use think\db;

class Member extends Admin
{

    protected $middleware = ['MemberLogin','Auth'];
    public function initialize(){
        parent::initialize();
        $this->authgroup = new AuthGroup();
        $this->auth_group_access = new AuthGroupAccess();
    }
    /**
     * [userlist 用户列表]
     * @return [type] [description]
     */
    public function userlist(){
        $keyword =isset($this->param['keyword']) ? $this->param['keyword']:false;
        $data_list = $this->member_model->where('username|mobile','like','%'.$keyword.'%')->order('register_time desc, id desc')->paginate(15,false,['query' => request()->param()]);

        $builder   = new AdminListBuilder();
        $builder->setMetaTitle('会员列表') // 设置页面标题
            ->setSearch('用户名/手机号','') //如果链接变量,直接写在第二个参数里
        ->addTopButton('self',array('title'=>'导出数据','href'=>url(MODULE_NAME.'/'.CONTROLLER_NAME.'/expMember')))
            ->addTopButton('addnew',['href'=>url('userAdd')])  // 添加新增按钮
            ->addTopButton('all')  // 添加新增按钮
            ->addTopButton('delete',array('model'=>'member'))
            ->keyListItem('id', '用户ID')
            ->keyListItem('avatar', '用户头像','avatar')
            ->keyListItem('username', '用户登录名')
            ->keyListItem('nickname', '会员昵称')
            ->keyListItem('status', '会员状态','array',array('0'=>'禁用','1'=>'启用'))
            ->keyListItem('register_time', '创建时间')
            ->keyListItem('login_time', '登录时间')
            ->keyListItem('right_button', '操作', 'btn')
            ->setListData($data_list) // 数据列表
            ->setListPage($data_list->render()) // 数据列表分页
            ->addRightButton('edit',['href'=>url('userEdit',array('id'=>'__data_id__')),'title'=>'操作'])
            ->addRightButton('self',['href'=>'javascript:;','data-url'=>url('Member/groupAuth',array('id'=>'__data_id__')),'group-url'=>url('Member/groupAuth'),'class'=>"btn-xs btn-link groupAuth",'title'=>'授权'])// 添加失效按钮
            ->addRightButton('delete',array('model'=>'member'))
            ->fetch();
    }

    /**
     * 导出用户
     */
    public function expMember(){
        $keyword =isset($this->param['keyword']) ? $this->param['keyword']:false;
        $data_list = $this->member_model->where('username|mobile','like','%'.$keyword.'%')->order('register_time desc, id desc')->select();
        if(!count($data_list))  $this->error('暂无数据');
        $title = '所有用户列表';
        $filename   = '所有用户列表'.$title.Date('YmdHis');

        $data_array[0] = array(
            iconv('utf-8','gb2312', '编号'),
            iconv('utf-8','gb2312', '用户登录名'),
            iconv('utf-8','gb2312', '会员昵称'),
            iconv('utf-8','gb2312', '手机号码'),
            iconv('utf-8','gb2312', '创建时间')
        );
        foreach ($data_list as $key  => $value) {
            $k=$key+1;
            $data_array[$k]=[
                iconv('utf-8','gb2312',$data_list[$key]['id']),
                iconv('utf-8','GBK',$data_list[$key]['username']),
                iconv('utf-8','GBK',$data_list[$key]['nickname']),
                iconv('utf-8','gb2312',$data_list[$key]['mobile']),
                iconv('utf-8','gb2312',$data_list[$key]['register_time']),
            ];
        }
        exportExcel($data_array,false,$filename);
    }
    /**
     * [userAdd 新增用戶]
     * @return [type] [description]
     */
    public function userAdd(){
        if(IS_POST){
            $data = $this->param;
            $haveUser = $this->member_model->where('username',$data['username'])->find();
            if(!$haveUser){
                //获取用户密码
                if($data['password']){
                    if(empty($data['repassword'])){
                        $this->error('如果设置密码，确认密码也需填写');
                    }
                } else {
                    unset($data['password']);
                    unset($data['repassword']);
                }
                // 调用独立校验器
                $addUser_validate = new \app\common\validate\Member;
                // 数据校验
                if(!$addUser_validate->scene('addUser')->check($data)){
                    $this->error($addUser_validate->getError());
                }
                Db::startTrans();
                try {

                    $member_add = $this->member_model->allowField(true)->isUpdate(false)->save($data);
                    if(!$member_add){
                      db::rollback(); 
                      $this->error($this->member_model->getError());
                    }
                    Db::commit();
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                    exit;
                }
                $this->success('新增成功！',url('Member/userList'));
            } else {
                $this->error('当前账户已存在，请勿重复添加');
            }
        } else {
            $info    =[];
            $info['status'] = 1;
            $info['demo7'] = 123456789;
            $builder = new AdminFormBuilder();
            $builder->setMetaTitle('新增用户') // 设置页面标题
                    ->addFormItem('username', '用户登录名','请填写用户登录名','text','','required')
                    ->addFormItem('nickname', '会员昵称','请填写会员昵称','text','','required')
                    ->addFormItem('mobile', '手机号码','请填写11位手机号码','number','','required')
                    ->addFormItem('password', '登录密码','请填写登录密码','text','','required')
                    ->addFormItem('repassword', '确认密码','请确认登录密码','text','','required')
                    ->addFormItem('avatar', '头像','','picture')
                    ->addFormItem('status', '用户状态','','radio',array(0=>'禁用',1=>'启用'))
                    ->setFormData($info)
                    ->addButton('submit')->addButton('back')    // 设置表单按钮
                    ->fetch();
        }
    }
    /**
     * [userEdit 编辑会员]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function userEdit($id=''){
        if(IS_POST){
            $data=$this->param;

            // 调用独立校验器
            $addUser_validate = new \app\common\validate\Member;
            // 数据校验
            if(!$addUser_validate->scene('editUser')->check($data)){
                $this->error($addUser_validate->getError());
            }

            Db::startTrans();
            try {
                $id = $data['id'];

                $data['password'] = isset($this->param['password']) ? $this->param['password']:false;
                if($data['password'] == ''){
                    unset($data['password']);
                } else {
                    $data['password'] = $data['password'];
                }

                $info = $this->member_model->allowField(true)->isUpdate(true)->save($data,['id'=>$id]);
                if(!$info){
                    db::rollback(); 
                    $this->error($this->member_model->getError());
                }
                Db::commit();
            } catch (Exception $e) {
                Db::rollback();
                $this->error($e->getMessage());
                exit;
            }
            $this->success('编辑成功！',url('Member/userList'));
        } else {
            $map['id']=$id;
            $info=[];
            $info = $this->member_model->where($map)->find();
            unset($info['password']);
            $builder = new AdminFormBuilder();
            $builder->setMetaTitle('编辑用戶') // 设置页面标题
                    ->addFormItem('id', '','','hidden')
                    ->addFormItem('username', '用户登录名','','info')
                    ->addFormItem('nickname', '会员昵称','请填写会员昵称','text','','required')
                    ->addFormItem('mobile', '手机号码','请填写11位手机号码','number','','required')
                    ->addFormItem('password', '登录密码','请填写登录密码，登录密码必须为6-18位数字+字符','text','','required')
                    ->addFormItem('repassword', '确认密码','请确认登录密码，确认登录密码必须为6-18位数字+字符','text','','required')
                    ->addFormItem('avatar', '头像','','picture')
                    ->addFormItem('status', '用户状态','','radio',array(0=>'禁用',1=>'启用'))
                    ->setFormData($info)
                    ->group('基本信息','id,username,nickname,mobile,password,repassword,pay_password,repay_password,problem,problem_pass,avatar,status,is_ratio')
                    //->group('用户积分','frozen_score,be_release_score,release_score,blush_score,purchase_score,lease_score')
                    //->group('推荐信息','referee')

                    ->addButton('submit')->addButton('back')    // 设置表单按钮
                    ->fetch();
        }
    }

    /**
     * [resetPassword 修改密码]
     */  
    public function resetPassword(){
        if (IS_POST) {
            //$oldpassword=I('post.oldpassword',false);
            $newpassword=$this->param['newpassword'];
            $repassword=$this->param['repassword'];
            if ($newpassword==$repassword) {
                $uid=input('post.id',is_login(),'intval');
                $new_password=md5($newpassword);
                $res=$this->member_model->where(array('id'=>$uid))->setField('password',$new_password);
                if ($res) {
                    session(null);
                    cookie(null);
                    $this->success('密码修改成功', url('Admin/login/index'));
                }
            }
        }else {
            // 获取账号信息
            $info = $this->member_model->where(array('id'=>is_login()))->find();
            // 使用FormBuilder快速建立表单页面。
            $builder = new AdminFormBuilder();
            $builder->setMetaTitle('修改密码')
                    ->addFormItem('newpassword','新密码','','password','','','placeholder="填写新密码"')
                    ->addFormItem('repassword','重复密码','','password','','','placeholder="填写重复密码"')
                    ->setFormData($info)
                    ->addButton('submit')->addButton('back')    // 设置表单按钮
                    ->fetch();
        }
    }

    /**
     * [groupAuth 更改用户权限]
     */
    public function groupAuth()
    {
        if (IS_AJAX) {
            if(isset($this->param['fromData'])){
                $fromData = $this->param['fromData'];
            }else{
                $fromData = '';
            }
            $uid = $this->param['uid'];
            if (!$uid) {
                return ['data'=>'参数错误','code'=>0,'info'=>'参数错误'];
            }
            if ($fromData == '') {
                if ($this->auth_group_access->where(array('uid'=>$uid))->delete()) {
                    //$this->success('更新成功', url('Member/userList'));
                    return ['data'=>'更新成功','code'=>1,'info'=>'更新成功'];
                } else {
                    return ['data'=>'更新失败','code'=>0,'info'=>'更新失败'];
                }
            } else {
                $newArr = array();
                foreach ($fromData as $key => $value) {
                    $newArr = explode(',', $value['value']);
                    $newfromData[$key]['uid'] = $newArr['0'];
                    $newfromData[$key]['group_id'] = $newArr['1'];
                }

                $this->auth_group_access->where(array('uid'=>$uid))->delete();
                if ($this->auth_group_access->insertAll($newfromData)) {
                    return json(['data'=>'更新成功','code'=>1,'info'=>'更新成功']);
                }else{
                    return json(['data'=>'更新失败','code'=>0,'info'=>'更新失败']);
                }
            }
        } else {
            $id = $this->param['id'];
            $field = array('id','title','description');
            $sqlmap = array('status'=>1);
            $authGrouData = $this->authgroup->field($field)->where($sqlmap)->select();
            if (empty($authGrouData)) {
                $this->error('暂无分组，请添加分组', url('access/rolelist'));
            }
            $userGroupData = $this->auth_group_access->where(array('uid'=>$id))->select();
            
            $userGroup=[];
            foreach ($userGroupData as $k => $v) {
                foreach ($authGrouData as $key => $value) {
                    if ($value['id'] == $v['group_id']) {

                        $userGroup[$k]['group_id'] = $value['id'];
                        $userGroup[$k]['title'] = $value['title'];
                    } 

                    if ($value['id'] == $v['group_id']) {
                        unset($authGrouData[$key]);
                    }
                }
            }  
            
            $this->assign('authgroup',$authGrouData);
            $this->assign('userGroup',$userGroup);
            $this->assign('uid',$id);
            return $this->fetch();
        }
    }
}
