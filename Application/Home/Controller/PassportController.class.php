<?php
namespace Mobile\Controller;
use Think\Controller;
use User\Api\UserApi;
/**
 * 处理登录，注册请求。
 * @author wangxianlei
 */
class PassportController  extends MobileController{
	protected function _initialize(){
		parent::_initialize();
	}
	/**
	 * 调用Common/Passport去登录;普通登录。处理登录请求
	 * @author wangxianlei
	 */
	public function loginAction($username='',$password='',$jump=true){
		if(!IS_POST&&(empty($username)&&empty($password))){
			redirect(C('SITE_HTTPS_URL').loginUrl());
			exit;
		}
		//通过用户名或者手机号判断是否是企业用户
		$uname = I("post.username");
		$uname = $uname?$uname:$username;
		if(!empty($uname)){
			$isMobile = is_mobile($uname);
			$map = array();
			$map['m_type'] = 1; //m_type 0,个人用户；1，企业用户
			if($isMobile){
				$map['mobile'] = $uname;
			}else{
				$map['username'] = $uname;
			}
			$isEnterprise = M('UcenterMember')->where($map)->count();
			if($isEnterprise>0){
				$this->error("企业用户不可以登录");
			}
		}
		$verify = I('post.verify');
		!check_verify($verify,'passport') && $this->error('验证码输入错误！',$_SERVER['HTTP_REFERER']);
		$comPassport = A('Common/Passport');
		$httpReferer = cookie('HTTP_REFERER');
		if(!empty($httpReferer)){
			if($jump===true){ //如果$jump 为true，则修改跳转地址。为false则不跳
				$jump = $httpReferer;
			}
		}
		$comPassport->login($username,$password,$jump);
	}
	/**
	 * 登录绑定
	 * @author wangxianlei
	 */
	public function loginBangding(){
		$this->loginAction('','',false);
		$uid = is_login();
		$uid<=0&&$this->error("登录失败，未能绑定",SITE_URL.loginBangdingUrl());
		$map = array();
		$map['id'] = $uid;
		$data['openid'] = think_decrypt( cookie( md5('userOpenid') ) );
		empty($data['openid'])&&$this->error("请开启浏览器cookie或再试一次");
		(is_bangding($data['openid'])!==false)&&$this->error('该微信号已经绑定过袋袋金帐号了');
		$res = M('UcenterMember')->where($map)->save($data);
		if($res!==false){
			$data['shareTitle'] = "放心理财，纵向生活—袋袋金";
			$data['title'] = "袋袋金";
			$this->assign($data);
			$this->display("loginBangdingSuccess");
		}else{
			$this->display("loginBangdingFail");
		}
	}
	/**
	 * 注册绑定
	 * @author wangxianlei
	 */
	public  function regBangding(){
		is_login()>1 && redirect(U('Mobile/User/index'));//如果会员已经登录则自动跳转到会员中心
		$USER_ALLOW_REGISTER = C('USER_ALLOW_REGISTER');
		if( is_numeric($USER_ALLOW_REGISTER) && 1!=$USER_ALLOW_REGISTER ){
			$this->assign('waitSecond',30);
			$this->assign('jumpUrl', $_SERVER['http_referer']);
			$this->error('注册已关闭');
			exit();
		}
		I('post.xieyi')!=1&&$this->error("请先同意协议");
		$comPassport = A('Common/Passport');
		$comPassport->register(false,2,3);
		if(is_login()){
			$data['shareTitle'] = "放心理财，纵向生活—袋袋金";
			$data['title'] = "袋袋金";
			$this->assign($data);
			$this->display("regBangdingSuccess");
		}else{
			echo "注册绑定失败";
		}
	}
}