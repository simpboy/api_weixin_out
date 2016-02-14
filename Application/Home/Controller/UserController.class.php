<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    /**
     * 快速注册
     */
    public function reg(){
        if(IS_POST){
            $postData = I('post.');
            $postData = clean_xss($postData);

            if(!(!empty($postData['username'])&&!empty($postData['mobile'])&&preg_match('/^1\d{10}$/',$postData['mobile']))){
                $this->error('请按规定填写姓名与手机号');
            }
            if(!empty($postData['referer_mobile'])&&!preg_match('/^1\d{10}$/',$postData['referer_mobile'])){
                $this->error('推荐人手机号格式错误');
            }
            $data = M('User')->create($postData);
            $data['reg_time'] = NOW_TIME;
            $data['last_login_time'] = NOW_TIME;
            $data['status'] = 0;
            $res = M('User')->add($data);
            if($res!==false){
                $this->success('注册成功','',3);
            }else{
                $this->error("注册失败",'',3);
            }
            exit();
        }
        $this->assign('title','快速注册');
        $this->display('reg');
    }
    /**
     * 完整信息展示
     */
    public function showUser(){
        $userId = is_login();
        if(!$userId){
            $this->error('请先登录');
        }
        $where = array();
        $where['user_id'] = $userId;

        $data = M('User')->where($where)->find();

        $moneyRecordContent = M('MoneyRecord')->where($where)->field('content')->select();
        $data['projectNumber'] = count($moneyRecordContent);
        $showContent = '';
        foreach($moneyRecordContent as $k=>$v){
            $showContent .= $v['content']."<br/>";
        }
        $data['showContent'] = $showContent;
        $this->assign($data);
        $this->assign('title','个人信息');
        $this->display('showUser');

    }
}