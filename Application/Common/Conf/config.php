<?php
return array(
	//'配置项'=>'配置值'
	/**
	URL模式 URL_MODEL设置
	普通模式 0
	PATHINFO模式 1
	REWRITE模式 2
	兼容模式 3
	 */
	'URL_MODEL'=> 0,
	/* 数据库设置 */
	'DB_TYPE'               =>  'mysqli',     // 数据库类型
	'DB_HOST'               =>  '127.0.0.1', // 服务器地址
	'DB_NAME'               =>  'api_weixin',          // 数据库名
	'DB_USER'               =>  'root',      // 用户名
	'DB_PWD'                =>  '123456',          // 密码
	'DB_PORT'               =>  '3306',        // 端口
	'db_charset'			=>  'utf8',
	'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增

	'TMPL_ACTION_ERROR'     =>  COMMON_PATH.'Tpl/dispatch_jump.tpl', // 默认错误跳转对应的模板文件
	'TMPL_ACTION_SUCCESS'   =>  COMMON_PATH.'Tpl/dispatch_jump.tpl', // 默认成功跳转对应的模板文件
	'ADMIN_USER_ID'         => array(14),
);