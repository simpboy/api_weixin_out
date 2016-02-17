<?php
namespace Home\Controller;
use Think\Controller;
use Vendor\Wechat;
/**
 * 用户中心公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class PublicController extends Controller{
	/**
	 * 注册绑定威信
	 */
	public function regBangding(){
		is_login()>1 && redirect(U('Mobile/User/index'));//如果会员已经登录则自动跳转到会员中心
		//获取绑定的威信openid
		$code = I('get.code'); //线上
		if(empty($code)){
			$url = SITE_URL.regBangdingUrl();
			$this->getToken($url);   //线上
			return;
		}
		$userOpenid = $this->getOpenid();   //线上
		
		cookie(md5('user_openid'), think_encrypt($userOpenid));
		

		$data['title'] = '袋袋金-注册绑定';
		$data['keywords'] = C('WEB_SITE_KEYWORD');
		$data['description'] = C('WEB_SITE_DESCRIPTION');
		$this->assign($data);
		$this->display('regBangding');
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
	 * 登录绑定
	 */
	public function loginBangding(){
		$uid = is_login();
		if($uid>0){
			//无论用户原来有没有绑定，自动绑定新的微信
			redirect(U('Mobile/Public/bangding'));//如果会员已经登录则自动跳转到会员中心
		}
		$code = I('get.code'); //线上
		if(empty($code)){
			$url = SITE_URL.loginBangdingUrl();
			$this->getToken($url);   //线上
			return;
		}
		$userOpenid = $this->getOpenid();   //线上
		cookie(md5('userOpenid'), think_encrypt($userOpenid));
		$data = array();
		$data['title'] = "袋袋金-绑定";
		$this->assign($data);
		$this->display("loginBangding"); //action 有大写，需要明确指定模板文件
	}
	/**
	 * 微信快捷登录
	 */
	public function quickLogin(){
		//登录后跳转
		is_login()>1 && redirect(U('Mobile/User/index'));//如果会员已经登录则自动跳转到会员中心

		$code = I('get.code'); //线上
		if(empty($code)){
			$url = SITE_URL.U('Mobile/Public/quickLogin');
			$this->getToken($url);   //线上
			return;
		}
		$userOpenid = $this->getOpenid();   //线上
		$isBangding = is_bangding($userOpenid);
		if($isBangding!==false){
			$mobileModel = D('Mobile/Mobile');
			$mobileModel->updateLogin($isBangding['id'],$isBangding['username']);//uc登录
			$Member = D('Home/Member');
			if($Member->login($isBangding['id'])){
				$jump = cookie('HTTP_REFERER');
				$jump = $jump?$jump:U('Mobile/User/index');
				cookie('HTTP_REFERER',null);
				$this->success("微信登录成功",$jump);
			}else{
				$this->error($Member->getError(),$_SERVER['HTTP_REFERER']);
			}
		}else{
			$this->error("请先绑定微信",SITE_URL.loginBangdingUrl());
		}
	}	
	/**
	 * 已经登录进行绑定
	 * 将openid绑定到袋袋金账户
	 */
	public function bangding(){
		$code = I('get.code'); //线上
		if(empty($code)){
			$url = SITE_URL.U('Mobile/Public/bangding');
			$this->getToken($url);   //线上
			return;
		}
		$userOpenid = $this->getOpenid();   //线上
		$data['openid'] = $userOpenid;

		$uid = is_login();
		$res = M('UcenterMember')->where(array('id'=>$uid))->save($data);
		$data = array();
		$data['shareTitle'] = "放心理财，纵向生活—袋袋金";
		$data['title'] = "袋袋金";
		$this->assign($data);
		if($res!==false){
			$this->display("Passport:loginBangdingSuccess");
		}else{
			echo 'failed';
		}
	}
}