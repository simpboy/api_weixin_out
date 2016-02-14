<?php
/**
 * @autor: wangxl
 */

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