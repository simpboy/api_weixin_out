<?php
/**
 * @autor: wangxl
 */
/**
 * 加密密码
 * @param string $password
 * @return string
 */
function encrypt_password($password=''){
	return md5($password);
}
/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 */
function is_login(){
	$userId = session('user_id');
	if (empty($userId)) {
		return 0;
	} else {
		return $userId;
	}
}
/**
 * @blog http://www.phpddt.com
 * @param $param
 * @param $low 安全别级低
 */
function clean_xss($param, $low = false)
{
	if(is_array($param)){
		foreach ( $param as $k=>$v )
		{
			$param[$k] = clean_xss ( $v );
		}
		return $param;
	}else{
		$param = trim ( $param );
		$param = strip_tags ( $param );
		$param = htmlspecialchars ( $param );
		if ($low)
		{
			return $param;
		}
		$param = str_replace ( array ('"', "\\", "'", "/", "..", "../", "./", "//" ), '', $param );
		$no = '/%0[0-8bcef]/';
		$param = preg_replace ( $no, '', $param );
		$no = '/%1[0-9a-f]/';
		$param = preg_replace ( $no, '', $param );
		$no = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';
		$param = preg_replace ( $no, '', $param );
		return $param;
	}
}

/**
 * 检查此openid是否已经绑定
 * @param $openid/$uid
 * $return true 已经绑定；false 未绑定
 */
function is_bangding($param=''){
	$paramLength = strlen(trim($param));
	if($paramLength>=28){ //openid 28位
		$field = "openid";
	}else{
		$field = "user_id";
		$map['openid'] = array('neq','');
	}
	$map[$field] = $param;
	$userInfo = M('User')->where($map)->field(true)->find();
	//file_put_contents(RUNTIME_PATH."log.txt",json_encode(M('UcenterMember')->getlastsql()));
	if(empty($userInfo)){
		return false;
	}else{
		return $userInfo;
	}
}

/**
 * 拼装url
 * @param  $data 需要拼装的数据。raw_string 按原样连接到url末尾
 * @author wangxianlei
 */
function  buildUrl($data){
	$sub_fix = '';
	if(isset( $data['raw_string'])){
		$sub_fix = $data['raw_string'];
		unset($data['raw_string']);
	}
	$queryString = http_build_query($data);
	return $queryString.$sub_fix;
}
/**
 * 发送http请求
 * @param $data 需要发送的数据。array
 * @param $url 请求的地址
 * @param $ispost 是否用post，默认post，false则使用get方式
 * @return 请求结果
 * @author wangxianlei
 */
function http_request($data,$url,$ispost=true){
	if(!$ispost&&!empty($data)){
		$queryString = buildUrl($data);
		$url = $url."?".$queryString;
	}
	//echo $url;
	$ch=curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //兼容https
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_HEADER,0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); //返回不输出
	//设置是通过post还是get方法  CURLOPT_HTTPGET
	if($ispost){
		curl_setopt($ch,CURLOPT_POST,1);
		//传递的变量
// 		curl_setopt($ch,CURLOPT_HTTPHEADERS,array('Content-Type: application/json'));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
	}
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key  加密密钥
 * @param int $expire  过期时间 单位 秒
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_encrypt($data, $key = '', $expire = 0) {
	$key  = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
	$data = base64_encode($data);
	$x    = 0;
	$len  = strlen($data);
	$l    = strlen($key);
	$char = '';

	for ($i = 0; $i < $len; $i++) {
		if ($x == $l) $x = 0;
		$char .= substr($key, $x, 1);
		$x++;
	}

	$str = sprintf('%010d', $expire ? $expire + time():0);

	for ($i = 0; $i < $len; $i++) {
		$str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
	}
	return str_replace(array('+','/','='),array('-','_',''),base64_encode($str));
}

/**
 * 系统解密方法
 * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param  string $key  加密密钥
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_decrypt($data, $key = ''){
	$key    = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
	$data   = str_replace(array('-','_'),array('+','/'),$data);
	$mod4   = strlen($data) % 4;
	if ($mod4) {
		$data .= substr('====', $mod4);
	}
	$data   = base64_decode($data);
	$expire = substr($data,0,10);
	$data   = substr($data,10);

	if($expire > 0 && $expire < time()) {
		return '';
	}
	$x      = 0;
	$len    = strlen($data);
	$l      = strlen($key);
	$char   = $str = '';

	for ($i = 0; $i < $len; $i++) {
		if ($x == $l) $x = 0;
		$char .= substr($key, $x, 1);
		$x++;
	}

	for ($i = 0; $i < $len; $i++) {
		if (ord(substr($data, $i, 1))<ord(substr($char, $i, 1))) {
			$str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
		}else{
			$str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
		}
	}
	return base64_decode($str);
}