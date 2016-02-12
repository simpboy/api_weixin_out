<?php
/**
 * @autor: wangxl
 */

/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function is_login(){
	$userId = session('user_id');
	if (empty($userId)) {
		return 0;
	} else {
		return $userId;
	}
}