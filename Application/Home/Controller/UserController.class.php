<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    /**
     * 快速注册
     */
    public function reg(){
        //获取绑定的威信openid
        $code = I('get.code'); //线上
        if(empty($code)){
            $url = SITE_URL.U('Home/User/reg');
            $this->getToken($url);   //线上
            return;
        }
        $userOpenid = $this->getOpenid();   //线上

        cookie(md5('user_openid'), think_encrypt($userOpenid));

        if(IS_POST){
            $postData = I('post.');
            $postData = clean_xss($postData);

            if(!(!empty($postData['username'])&&!empty($postData['mobile'])&&preg_match('/^1\d{10}$/',$postData['mobile']))){
                $this->error('请按规定填写姓名与手机号');
            }
            if(!empty($postData['referer_mobile'])&&!preg_match('/^1\d{10}$/',$postData['referer_mobile'])){
                $this->error('推荐人手机号格式错误');
            }
            $userOpenid = think_decrypt(cookie(md5('user_openid')));

            $data = M('User')->create($postData);
            $data['openid'] = $userOpenid;
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
     * 获取用户token
     * 向该地址获取用户的token,用于换取用户openid:https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxea75c703e3c51ec3&redirect_uri=http%3A%2F%2F119.29.12.215%2FMobile%2FPublic%2Fbangding&response_type=code&scope=snsapi_base#wechat_redirect
     */
    private function getToken($jumpUrl){
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize";
        //$jumpUrl  ：：：： "http://119.29.12.215/Mobile/Public/loginBangding";  //回调地址 js urlencode
        $jumpUrl = $jumpUrl;
        $getData['appid'] = C('AppID');
        $getData['redirect_uri'] =  iconv("utf-8","gb2312//IGNORE",$jumpUrl);
        $getData['response_type'] =  'code';
        $getData['scope'] =  'snsapi_base';
        $getData['raw_string'] = '#wechat_redirect';
        $queryString = buildUrl($getData);
        $url = $url."?".$queryString;
        redirect($url);
    }
    /**
     * token换取用户的openid
     * 需要从威信回调本action : https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxea75c703e3c51ec3&redirect_uri=http%3A%2F%2F119.29.12.215%2FMobile%2FPublic%2Fbangding&response_type=code&scope=snsapi_base#wechat_redirect
     * redirect_uri 必须urlencode 处理。
     */
    private function getOpenid($jumpUrl=''){
        //https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token";
        $getData['appid'] = C('AppID');
        $getData['secret'] = C('AppSecret');
        $code = I("get.code");
        if(!empty($code)){
            $getData['code'] = $code;
        }else{
            $getData['code'] = $this->getToken($jumpUrl);
        }
        $getData['grant_type']	= "authorization_code";

        $data = http_request($getData,$url,false);
        $retArray = json_decode($data,true);
        $openid = $retArray['openid'];
        return $openid;
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

    /**
     * 使用微信openid自动登录
     */
    public function autoLogin(){
        $code = I('get.code'); //线上
        if(empty($code)){
            $url = SITE_URL.U('Home/User/autoLogin');
            $this->getToken($url);   //线上
            return;
        }
        $userOpenid = $this->getOpenid();   //线上
        $isBangding = is_bangding($userOpenid);
        if($isBangding!==false){
            session('user_id',$isBangding['user_id']);
            session('username',$isBangding['username']);
            session('mobile',$isBangding['mobile']);
            $this->success('登录成功!',U('Home/User/showUser'));
            exit();
        }else{
            $this->error("您还没有绑定微信,请正常登录绑定",U('Home/User/loginBangding'));
        }
    }
    /**
     * 登录绑定
     */
    public function loginBangding(){
        $uid = is_login();
        if($uid>0){
            //无论用户原来有没有绑定，自动绑定新的微信
            redirect(U('Home/User/showUser'));//如果会员已经登录则自动跳转到会员中心
        }
        if(IS_POST){
            $postData = I("post.");
            $where = array();
            if(preg_match('/^1\d{10}$/',$postData['username'])){
                $where['mobile'] = $postData['username'];
            }else{
                $where['username'] = $postData['username'];
            }
            $where['password'] = encrypt_password($postData['password']);

            $userInfo = M('user')->where($where)->find();
            if(!in_array($userInfo['user_id'],C('ADMIN_USER_ID'))||empty($userInfo)){
                $this->error('不能成功登录');
            }
            session('user_id',$userInfo['user_id']);
            session('username',$userInfo['username']);
            session('mobile',$userInfo['mobile']);

            $data = array();
            $data['openid'] = think_decrypt( cookie( md5('userOpenid') ) );
            if(empty($data['openid'])){
                session(null);
                $this->error("请开启浏览器cookie或再试一次");
            }
            if(is_bangding($data['openid'])!==false){
                $this->error('该微信号已经绑定过了,您可以直接用微信登录',U('Home/User/showUser'));
            }

            $where = array();
            $where['user_id'] = session('user_id');

            $res = M('User')->where($where)->save($data);
            if($res!==false){
                $this->success('登录绑定成功!',U('Home/User/showUser'));
            }else{
                session(null);
                $this->error('登录绑定失败!',U('Home/User/loginBangding'));
            }
            exit();
        }
        $code = I('get.code'); //线上
        if(empty($code)){
            $url = SITE_URL.U('Home/User/loginBangding');
            $this->getToken($url);   //线上
            return;
        }
        $userOpenid = $this->getOpenid();   //线上
        cookie(md5('userOpenid'), think_encrypt($userOpenid));
        $data = array();
        $data['title'] = "登录绑定";
        $this->assign($data);
        $this->display("loginBangding"); //action 有大写，需要明确指定模板文件
    }
}