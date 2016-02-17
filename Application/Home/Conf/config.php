<?php
return array(
	//'配置项'=>'配置值'
	/* 模板相关配置 */
	'TMPL_PARSE_STRING' => array(
		'__STATIC__' => __ROOT__ . '/Public/static',
		'__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
		'__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
		'__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
	),
	/* 微信配置 */
	'AppID'				=>	'wxea75c703e3c51ec3',	//应用ID
	'AppSecret'			=>	'fbe3871e9afff96942f115e85e0a1504',	//应用密钥
	'URL'				=>	'',	//微信服务器通知的地址
	'Token'				=>	'thnokxlsdjskwweopk', //
);