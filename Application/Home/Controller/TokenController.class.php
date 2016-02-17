<?php
namespace Home\Controller;
use Think\Controller;
use Vendor\Wechat;

/**
 * 监听用户所有动作   用户所有的请求威信都会转发到listen下面。都需要在listen下面处理。
 */
class TokenController extends Controller {
	public function getAccessToken() {
		$accessToken = S("accessToken");
		if(!$accessToken){
			$appId = C('AppID');
			$secret = C('AppSecret');
			$webChatAuth = new \Vendor\Wechat\WechatAuth($appId,$secret);
			$tokenArray = $webChatAuth->getAccessToken();
			$accessToken = $tokenArray['access_token'];
			S("accessToken",$accessToken,"5400");
		}
		return $accessToken;
	}
	private function checkSignature()
	{
		$signature = I("get.signature");
		$timestamp = I("get.timestamp");
		$nonce = I("get.nonce");
		$token = C('Token');

		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if($tmpStr == $signature){
			return true;
		}else{
			return false;
		}
	}
	public function jieru(){
		$echostr = I("get.echostr");
		if($echostr){  //第一次接入
			if($this->checkSignature()){
				echo trim($echostr);
				return true;
			}else{
				return false;
			}
		}else{   //已经接入成功
			return true;
		}
	}
	/**
	 * 监听微信过来的任何请求，并作出相应的处理
	 * @author wangxianlei
	 */
	
	public function listen(){
		$echostr = I("get.echostr");
		if($echostr){ //后台配置，进入接入逻辑。仅在威信配置的时候run一次。
			!$this->jieru()&&$this->error('接入错误');
			exit();
		}
		$token = C('Token');
		$wechat = new \Vendor\Wechat\Wechat($token);
		$data = $wechat->request();
		//	微信返回的数据格式如下：
		// 		$data = array (
		//   'ToUserName' => 'gh_7fb343279666',
		//   'FromUserName' => 'odT4PwcmqN1gyLlHzvpWYtWI37Y1',
		//   'CreateTime' => '1436188156',
		//   'MsgType' => 'event',
		//   'Event' => 'CLICK',
		//   'EventKey' => 'M001_BIND_REG',
		// );
		if($data && is_array($data)){ //接受威信的请求并做相应的处理。
			/**
			 * 你可以在这里分析数据，决定要返回给用户什么样的信息
			 * 接受到的信息类型有9种，分别使用下面九个常量标识
			 * Wechat::MSG_TYPE_TEXT       //文本消息
			 * Wechat::MSG_TYPE_IMAGE      //图片消息
			 * Wechat::MSG_TYPE_VOICE      //音频消息
			 * Wechat::MSG_TYPE_VIDEO      //视频消息
			 * Wechat::MSG_TYPE_MUSIC      //音乐消息
			 * Wechat::MSG_TYPE_NEWS       //图文消息（推送过来的应该不存在这种类型，但是可以给用户回复该类型消息）
			 * Wechat::MSG_TYPE_LOCATION   //位置消息
			 * Wechat::MSG_TYPE_LINK       //连接消息
			 * Wechat::MSG_TYPE_EVENT      //事件消息
			 *
			 * 事件消息又分为下面五种
			 * Wechat::MSG_EVENT_SUBSCRIBE          //订阅
			 * Wechat::MSG_EVENT_SCAN               //二维码扫描
			 * Wechat::MSG_EVENT_LOCATION           //报告位置
			 * Wechat::MSG_EVENT_CLICK              //菜单点击
			 * Wechat::MSG_EVENT_MASSSENDJOBFINISH  //群发消息成功
			 */
			if($data['MsgType']=='event'&&$data['Event']=='CLICK'){
				switch ($data['EventKey']){
					case 'M001_BIND_REG':  //绑定注册
						$content = "";
						$is_bangding = is_bangding($data['FromUserName']);
						$chenghu = $is_bangding['username']?$is_bangding['username']:$is_bangding['mobile'];
						if($is_bangding===false){
							$content = "您尚未绑定微信服务号！\n\n已有账户，请<a href='".SITE_URL.U('Home/User/loginBangding')."'>点击这里</a>绑定。\n\n新用户请<a href='".SITE_URL.U('Home/User/reg')."'>点击这里</a>注册并绑定。";
						}else{
						 	$content = "尊敬的{$chenghu}，您已经成功绑定微信服务。\n\n<a href='".SITE_URL.U('Home/User/autoLogin')."'>点击这里</a>自动登录查看个人信息";
						}
						break;
					case 'M001_MY_ACCOUNT':
							$is_bangding = is_bangding($data['FromUserName']);
							if($is_bangding===false){ //未绑定
								 $content = "绑定微信服务即可随时查看账户。\n\n<a href='".SITE_URL.U('Home/User/loginBangding')."'>点击去绑定</a>\n\n新用户请<a href='".SITE_URL.U('Home/User/reg')."'>点击这里</a>注册并绑定。";
							}else{  //已经绑定
								$chenghu = $is_bangding['username']?$is_bangding['username']:$is_bangding['mobile'];

								$content = "尊敬的".$chenghu."，您目前：\n\n你已经收到发放金额：".number_format($is_bangding['award_total_money'], 2, '.', '')."元\n待发放金额   ：".number_format($is_bangding['except_award_money'], 2, '.', '')."元\n\n个人信息详情请<a href='".SITE_URL.U('Home/User/autoLogin')."'>点击查看</a>";
							}
						break;
				}
			}
//			if($data['MsgType']=='text'&&$data['Content']=='余额'){
//					$is_bangding = is_bangding($data['FromUserName']);
//					if($is_bangding===false){ //未绑定
//						$content = "您还未绑定";
//					}else{
//						$res = jiebang($data['FromUserName']);
//						if($res!==false){
//							$content = "解除绑定成功！\n 我一定会回来的...555";
//						}else{
//							$content = "解除绑定失败";
//						}
//					}
//			}
			/* 响应当前请求(自动回复) */
			$wechat->response($content);
			/**
			 * 响应当前请求还有以下方法可以只使用
			 * 具体参数格式说明请参考文档
			 *
			 * $wechat->replyText($text); //回复文本消息
			 * $wechat->replyImage($media_id); //回复图片消息
			 * $wechat->replyVoice($media_id); //回复音频消息
			 * $wechat->replyVideo($media_id, $title, $discription); //回复视频消息
			 * $wechat->replyMusic($title, $discription, $musicurl, $hqmusicurl, $thumb_media_id); //回复音乐消息
			 * $wechat->replyNews($news, $news1, $news2, $news3); //回复多条图文消息
			 * $wechat->replyNewsOnce($title, $discription, $url, $picurl); //回复单条图文消息
			 *
			 */
		}
	}
}