<?php
namespace Admin\Controller;

class IndexController extends AdminController {
    public function userList(){

        $data = array();

        $where = array();
        $data['_list'] = $this->lists('User');

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
}