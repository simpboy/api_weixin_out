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
 * 获取用户信息
 * 未使用缓存
 */
function get_userinfo($user_id=0,$field=''){
	$where = array();
	$where['user_id'] = $user_id;
	$userInfo = M('User')->where($where)->find();
	if(empty($userInfo)){
		return false;
	}
	if(!empty($field)){
		return $userInfo[$field];
	}
	return $userInfo;
}
/**
 * 截取中文字符串
 */
function msubstr($string, $start=0, $length, $charset="utf-8", $suffix=true){
	if(function_exists("mb_substr")){
		if($suffix)
			return mb_substr($string, $start, $length, $charset)."...";
		else
			return mb_substr($string, $start, $length, $charset);
	}elseif(function_exists('iconv_substr')) {
		if($suffix)
			return iconv_substr($string,$start,$length,$charset)."...";
		else
			return iconv_substr($string,$start,$length,$charset);
	}
	$re['utf-8'] = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef][x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";
	$re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";
	$re['gbk'] = "/[x01-x7f]|[x81-xfe][x40-xfe]/";
	$re['big5'] = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";
	preg_match_all($re[$charset], $string, $match);
	$slice = join("",array_slice($match[0], $start, $length));
	if($suffix) return $slice."…";
	return $slice;
}
