<?php
namespace Admin\Controller;

class IndexController extends AdminController {
    public function userList(){
        $p = max(I('get.p'),1);
        $data = array();

        $where = array();
        $where['status'] = array('in',array(-1,0));
        $data['_list'] = $this->lists('User',$where);

        $data['p'] = $p;

        $this->assign($data);
        $this->assign('meta_title','用户列表');
        $this->display('userList');
    }
    public function addUser(){
        if(IS_POST){
            $postData = I("post.");
            $User = M('User');
            $data = array();
            $data['username'] = $postData['username'];
            $data['mobile'] = $postData['mobile'];
            $data['password'] = encrypt_password($postData['password']);
            $data['referer_username'] = $postData['referer_username'];
            $data['referer_mobile'] = $postData['referer_mobile'];
            $data['gender'] = $postData['gender'];
            $data['company'] = $postData['company'];
            $data['self_description'] = $postData['self_description'];
            $data['reg_time'] = NOW_TIME;
            $data['last_login_time'] = NOW_TIME;
            $addData = $User->create($data);
            $result = $User->add($addData);

            if($result!==false){
                $this->success('添加用户成功',U('index/userList'),3);
            }else{
                $this->error('添加用户失败','',3);
            }
            exit();
        }
        $this->assign('meta_title','添加用户');
        $this->display('addUser');
    }
    public function viewUser(){
        $userId = I("get.userid");
        if(!is_int($userId+0)){
            $this->error('参数错误');
        }
        $where = array();
        $where['user_id'] = $userId;

        $data['userInfo'] = M('User')->where($where)->find();

        $this->assign($data);
        $this->assign('meta_title','用户详情');
        $this->display('viewUser');
    }
    public function editUser(){
        if(IS_POST){
            $postData = I('post.');
            if(!empty($postData['password'])){
                $postData['password'] = encrypt_password($postData['password']);
            }else{
                unset($postData['password']);
            }
            $User = M('User');
            $editData = $User->create($postData);

            $where = array();
            $where['user_id'] = $postData['user_id'];
            $editRes = $User->where($where)->save($editData);
            if($editRes!==false){
                $this->success('编辑用户信息成功','',3);
            }else{
                $this->error('编辑用户信息失败','',3);
            }
        }
    }
    public function forbiddenUser(){
        $p = I('get.p');
        $userId = I('get.userid');
        $where =  array();
        $where['user_id'] = $userId;
        $where['status'] = 0;
        $count = M('User')->where($where)->count();
        if($count!=1){
            $this->error('参数错误','',3);
        }

        $where = array();
        $where['user_id'] = $userId;
        $where['status'] = 0;

        $data = array();
        $data['status'] = -1;
        $res = M('User')->where($where)->save($data);
        if($res!==false){
            $this->success('禁用用户成功',U('index/userList',array('p'=>$p)),3);
        }else{
            $this->error('操作失败','',3);
        }
    }

    public function enableUser(){
        $p = I('get.p');
        $userId = I('get.userid');
        $where =  array();
        $where['user_id'] = $userId;
        $where['status'] = -1;
        $count = M('User')->where($where)->count();
        if($count!=1){
            $this->error('参数错误','',3);
        }

        $where = array();
        $where['user_id'] = $userId;
        $where['status'] = -1;

        $data = array();
        $data['status'] = 0;
        $res = M('User')->where($where)->save($data);
        if($res!==false){
            $this->success('启用用户成功',U('index/userList',array('p'=>$p)),3);
        }else{
            $this->error('操作失败','',3);
        }
    }


}