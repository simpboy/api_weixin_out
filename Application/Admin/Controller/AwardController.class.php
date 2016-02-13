<?php
namespace Admin\Controller;

class AwardController extends AdminController {
    /**
     * 奖励列表
     */
    public function awardList(){
        $p = max(I('get.p'),1);

        $where = array();
        $where['status'] = array('in',array(0,1));
        $data['_list'] = $this->lists('MoneyRecord',$where);

        $data['p'] = $p;
        $this->assign($data);
        $this->assign('meta_title','奖励列表');
        $this->display('awardList');
    }
    /**
     * 给用户发放奖励
     */
    public function awardUser(){
        $p = I('get.p');
        $userId = I('request.userid');

        $where = array();
        $where['user_id'] = $userId;

        $data['userInfo'] = M('User')->where($where)->find();
        if(empty($data['userInfo'])){
            $this->error('参数错误');
        }

        if(IS_POST){
            $postData = I("post.");
            $MoneyRecord = M('MoneyRecord');
            $MoneyRecord->startTrans();
            $data = array();
            $data['user_id'] = $userId;
            $data['money'] = $postData['money'];
            $data['content'] = $postData['content'];
            $data['create_time'] = NOW_TIME;
            $data['update_time'] = NOW_TIME;
            $data['status'] = $postData['status'];
            $addData = $MoneyRecord->create($data);
            $result = $MoneyRecord->add($addData);

            $where = array();
            $where['user_id'] = $userId;

            $data = array();
            if($postData['status']==1) {
                $data['award_total_money'] = array('exp', "award_total_money+{$postData['money']}");
            }else{
                $data['except_award_money'] = array('exp', "except_award_money+{$postData['money']}");
            }

            $updateMoneyRes = M('User')->where($where)->save($data);


            if($result!==false&&$updateMoneyRes!==false){
                $MoneyRecord->commit();
                $this->success('发放奖励成功',U('index/userList',array('p'=>$p)),3);
            }else{
                $MoneyRecord->rollback();
                $this->error('发放奖励失败','',3);
            }
            exit();
        }
        $data['p'] = $p;
        $this->assign($data);
        $this->assign('meta_title','发放奖励');
        $this->display('awardUser');
    }
    /**
     * 查看奖励详情
     */
    public function awardView(){
        $recordId = I('get.recordId');
        $p = max(1,I('get.p'));

        $where = array();
        $where['record_id'] = $recordId;

        $moneyRecord = M('MoneyRecord')->where($where)->find();
        if(empty($moneyRecord)){
            $this->error('参数错误');
        }
        $data['moneyRecord'] = $moneyRecord;
        $data['p'] = $p;
        $this->assign($data);
        if($moneyRecord['status']==1){
            $this->assign('meta_title','查看奖励详情');
        }else{
            $this->assign('meta_title','发放奖励详情');
        }

        $this->display('awardView');
    }

    public function editAward(){
        if(IS_POST){
            $p = max(1,I('get.p'));
            $postData = I('post.');

            $where = array();
            $where['record_id'] = $postData['record_id'];

            $recordInfo = M('MoneyRecord')->where($where)->find();
            if($recordInfo['status']==1){
                $this->error('该笔奖励已经发放，不允许更新');
            }

            if($postData['status']!=1){
                $this->error('请将该记录的状态修改为发放再提交');
            }


            $m = M();
            $m->startTrans();

            //发放后，用户的总金额增加，待发放减少
            $where = array();
            $where['record_id'] = $postData['record_id'];

            $data = array();
            $data['status'] = $postData['status'];
            $data['content'] = $postData['content'];
            $data['update_time'] = NOW_TIME;
            $res = M('MoneyRecord')->where($where)->save($data);

            $where = array();
            $where['user_id'] = $recordInfo['user_id'];

            $data = array();
            $data['award_total_money'] = array('exp',"award_total_money+{$recordInfo['money']}");
            $data['except_award_money'] = array('exp',"except_award_money-{$recordInfo['money']}");
            $res2 = M('User')->where($where)->save($data);

            if($res!==false&&$res2!==false){
                $m->commit();
                $this->success('奖励发放成功！',U('Award/awardList',array('p'=>$p)));
            }else{
                $m->rollback();
                $this->error('发放奖励失败！');
            }
        }
    }

}